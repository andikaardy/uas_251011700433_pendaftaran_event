<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }

require_once '../model/EventModel.php';
$eventModel = new EventModel();

// Menerima parameter filter dari URL jika ada
$keyword = isset($_GET['search']) ? $_GET['search'] : "";
$sort = isset($_GET['sort']) ? $_GET['sort'] : "tanggal_daftar";
$order = isset($_GET['order']) ? $_GET['order'] : "DESC";
$statusFilter = isset($_GET['status']) ? $_GET['status'] : "";
$bulanFilter = isset($_GET['bulan']) ? $_GET['bulan'] : "";
$tahunFilter = isset($_GET['tahun']) ? $_GET['tahun'] : "";

// Hanya mengambil data sesuai filter
$dataEvent = $eventModel->getEvents($keyword, $sort, $order, $statusFilter, $bulanFilter, $tahunFilter);

// Memanipulasi HTTP Header agar halaman dibaca sebagai Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Event_251011700433.xls");
?>
<table border="1">
    <tr>
        <th colspan="5" style="background-color: #f2f2f2; font-size: 16px; padding: 10px;">LAPORAN PENDAFTARAN EVENT</th>
    </tr>
    <tr>
        <th style="background-color: #e6e6e6;">ID / NIM</th>
        <th style="background-color: #e6e6e6;">Nama Peserta</th>
        <th style="background-color: #e6e6e6;">Nama Event</th>
        <th style="background-color: #e6e6e6;">Tanggal Daftar</th>
        <th style="background-color: #e6e6e6;">Status</th>
    </tr>
    <?php foreach($dataEvent as $row): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['nama_peserta']; ?></td>
        <td><?php echo $row['nama_event']; ?></td>
        <td><?php echo date('d M Y', strtotime($row['tanggal_daftar'])); ?></td>
        <td><?php echo $row['status']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>