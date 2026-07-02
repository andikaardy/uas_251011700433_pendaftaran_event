<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }

require_once '../model/EventModel.php';
$eventModel = new EventModel();

// Mengambil parameter dari URL (GET)
$keyword = isset($_GET['search']) ? $_GET['search'] : "";
$sort = isset($_GET['sort']) ? $_GET['sort'] : "tanggal_daftar";
$order = isset($_GET['order']) ? $_GET['order'] : "DESC";
$statusFilter = isset($_GET['status']) ? $_GET['status'] : "";
$bulanFilter = isset($_GET['bulan']) ? $_GET['bulan'] : "";
$tahunFilter = isset($_GET['tahun']) ? $_GET['tahun'] : "";

// Format tanggal Bahasa Indonesia untuk hari ini
$bulanIndo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$tglHariIni = date('d') . ' ' . $bulanIndo[(int)date('m')] . ' ' . date('Y');

// Membalikkan order untuk klik header tabel selanjutnya
$nextOrder = ($order === 'ASC') ? 'DESC' : 'ASC';

// Query string untuk di-passing ke tombol export (PDF/Excel)
$exportQueryString = http_build_query([
    'search' => $keyword, 'status' => $statusFilter, 
    'bulan' => $bulanFilter, 'tahun' => $tahunFilter, 
    'sort' => $sort, 'order' => $order
]);

// Memanggil data dengan filter terpasang
$dataEvent = $eventModel->getEvents($keyword, $sort, $order, $statusFilter, $bulanFilter, $tahunFilter); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Manajemen Event</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background-color: #f5f5f7; color: #1d1d1f; display: flex; min-height: 100vh; }
        
        .sidebar { width: 260px; background: #ffffff; border-right: 1px solid #e8e8ed; padding: 30px 20px; display: flex; flex-direction: column; }
        .sidebar h3 { font-size: 18px; font-weight: 600; margin-bottom: 30px; padding-left: 10px; letter-spacing: -0.5px; }
        .sidebar a { padding: 12px 14px; color: #1d1d1f; text-decoration: none; font-size: 14px; border-radius: 10px; margin-bottom: 6px; display: block; transition: all 0.2s; }
        .sidebar a.active, .sidebar a:hover { background: #f5f5f7; font-weight: 500; }
        .sidebar .logout { margin-top: auto; color: #ff3b30; }
        .sidebar .logout:hover { background: #ffe5e5; }

        .main-content { flex: 1; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .header h1 { font-size: 28px; font-weight: 600; letter-spacing: -0.8px; margin-bottom: 5px; }
        .date-display { font-size: 14px; color: #86868b; font-weight: 500; }
        .user-profile { font-size: 14px; color: #86868b; text-align: right; }

        .action-bar { background: #ffffff; padding: 16px; border-radius: 14px; border: 1px solid #e8e8ed; margin-bottom: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.02); }
        .search-form { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
        .search-form input, .search-form select { padding: 10px 14px; background: #f5f5f7; border: 1px solid #d2d2d7; border-radius: 8px; font-size: 13px; outline: none; }
        .search-form input { flex: 1; min-width: 200px; }
        .search-form input:focus, .search-form select:focus { border-color: #000000; background: #ffffff; }
        
        .btn-action { padding: 10px 16px; border: 1px solid #d2d2d7; background: #ffffff; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; color: #1d1d1f; transition: all 0.2s; white-space: nowrap; }
        .btn-action:hover { background: #f5f5f7; border-color: #86868b; }
        .btn-primary { background: #1d1d1f; color: #ffffff; border: none; }
        .btn-primary:hover { background: #000000; }

        .btn-group-right { display: flex; gap: 8px; margin-left: auto; padding-top: 10px; border-top: 1px solid #e8e8ed; width: 100%; justify-content: flex-end;}

        .table-container { background: #ffffff; border-radius: 14px; border: 1px solid #e8e8ed; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { background: #f5f5f7; padding: 16px; font-weight: 600; color: #86868b; border-bottom: 1px solid #e8e8ed; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        th a { color: #86868b; text-decoration: none; }
        th a:hover { color: #1d1d1f; }
        td { padding: 16px; border-bottom: 1px solid #e8e8ed; color: #1d1d1f; }
        tr:last-child td { border-bottom: none; }
        .status-badge { padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-block; }
        .status-confirm { background: #e3f2fd; color: #0d47a1; }
        .status-pending { background: #fff3e0; color: #e65100; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>Manajemen Event</h3>
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="tambah_event.php">+ Tambah Data</a>
        <a href="../controller/AuthController.php?action=logout" class="logout">Keluar</a>
    </div>

    <div class="main-content">
        <div class="header">
            <div>
                <h1>Data Pendaftaran Event</h1>
                <div class="date-display">Hari ini: <?php echo $tglHariIni; ?></div>
            </div>
            <div class="user-profile">Halo,<br><strong style="color:#1d1d1f;"><?php echo htmlspecialchars($_SESSION['username']); ?></strong></div>
        </div>

        <div class="action-bar">
            <form class="search-form" method="GET" action="dashboard.php">
                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                <input type="hidden" name="order" value="<?php echo htmlspecialchars($order); ?>">
                
                <input type="text" name="search" placeholder="Cari nama peserta atau event..." value="<?php echo htmlspecialchars($keyword); ?>">
                
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="Pending" <?php if($statusFilter == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Dikonfirmasi" <?php if($statusFilter == 'Dikonfirmasi') echo 'selected'; ?>>Dikonfirmasi</option>
                </select>

                <select name="bulan">
                    <option value="">Semua Bulan</option>
                    <?php 
                    for($m=1; $m<=12; ++$m){
                        $selected = ($bulanFilter == $m) ? 'selected' : '';
                        echo "<option value='$m' $selected>".$bulanIndo[$m]."</option>";
                    }
                    ?>
                </select>

                <select name="tahun">
                    <option value="">Semua Tahun</option>
                    <?php 
                    $currentYear = date('Y');
                    for($y=$currentYear; $y>=($currentYear-2); $y--){
                        $selected = ($tahunFilter == $y) ? 'selected' : '';
                        echo "<option value='$y' $selected>$y</option>";
                    }
                    ?>
                </select>

                <button type="submit" class="btn-action btn-primary">Filter Data</button>
            </form>

            <div class="btn-group-right">
                <a href="cetak_pdf.php?<?php echo $exportQueryString; ?>" target="_blank" class="btn-action">Unduh PDF</a> 
                <a href="export_excel.php?<?php echo $exportQueryString; ?>" class="btn-action">Unduh Excel</a> 
                <a href="tambah_event.php" class="btn-action btn-primary">+ Tambah Event</a>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <?php $baseQS = "&search=$keyword&status=$statusFilter&bulan=$bulanFilter&tahun=$tahunFilter"; ?>
                        <th><a href="?sort=id&order=<?php echo $nextOrder . $baseQS; ?>">ID / NIM ↕</a></th>
                        <th><a href="?sort=nama_peserta&order=<?php echo $nextOrder . $baseQS; ?>">Nama Peserta ↕</a></th>
                        <th><a href="?sort=nama_event&order=<?php echo $nextOrder . $baseQS; ?>">Nama Event ↕</a></th>
                        <th>File Bukti</th>
                        <th><a href="?sort=status&order=<?php echo $nextOrder . $baseQS; ?>">Status ↕</a></th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($dataEvent) > 0): ?>
                        <?php foreach($dataEvent as $row): ?>
                        <tr>
                            <td style="font-weight: 600;"><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_peserta']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_event']); ?></td>
                            <td>
                                <?php if(!empty($row['file_bukti'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['file_bukti']); ?>" target="_blank" style="color: #0066cc; text-decoration: none; font-weight: 500;">Lihat Berkas</a>
                                <?php else: ?>
                                    <span style="color:#86868b;">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge <?php echo ($row['status'] == 'Dikonfirmasi') ? 'status-confirm' : 'status-pending'; ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_event.php?id=<?php echo $row['id']; ?>" style="color: #0066cc; text-decoration: none; margin-right: 12px; font-weight: 500;">Edit</a>
                                <a href="../controller/hapus_event.php?id=<?php echo $row['id']; ?>" style="color: #ff3b30; text-decoration: none; font-weight: 500;" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #86868b; padding: 40px;">Tidak ada data yang ditemukan sesuai filter yang dipilih.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>