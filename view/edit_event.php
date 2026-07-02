<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
require_once '../model/EventModel.php';

if (!isset($_GET['id'])) { header("Location: dashboard.php"); exit; }

$eventModel = new EventModel();
$data = $eventModel->getEventById($_GET['id']);

if (!$data) { echo "Data tidak ditemukan!"; exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        body { background-color: #f5f5f7; display: flex; justify-content: center; align-items: center; min-height: 100vh; color: #1d1d1f; padding: 20px; }
        .form-container { background: #ffffff; padding: 40px; border-radius: 18px; width: 100%; max-width: 500px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); }
        h2 { margin-bottom: 24px; font-size: 22px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px; }
        input[type="text"], input[type="number"], input[type="file"] { width: 100%; padding: 12px; background: #f5f5f7; border: 1px solid #d2d2d7; border-radius: 10px; font-size: 14px; outline: none; }
        .btn-group { display: flex; gap: 10px; margin-top: 24px; }
        .btn { flex: 1; padding: 12px; border: none; border-radius: 10px; font-size: 14px; font-weight: 500; cursor: pointer; text-align: center; text-decoration: none; }
        .btn-primary { background: #1d1d1f; color: #ffffff; }
        .btn-secondary { background: #e8e8ed; color: #1d1d1f; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Pendaftaran Event</h2>
        <form action="../controller/EventProcess.php" method="POST">
            <!-- Hidden input untuk membedakan antara insert dan update di controller -->
            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($data['id']); ?>">
            
            <div class="form-group">
                <label>ID / NIM (Tidak dapat diubah)</label>
                <input type="number" value="<?php echo htmlspecialchars($data['id']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Nama Peserta</label>
                <input type="text" name="nama_peserta" value="<?php echo htmlspecialchars($data['nama_peserta']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Event</label>
                <input type="text" name="nama_event" value="<?php echo htmlspecialchars($data['nama_event']); ?>" required>
            </div>
            <div class="form-group">
                <label>Status Pendaftaran</label>
                <select name="status" style="width: 100%; padding: 12px; background: #f5f5f7; border: 1px solid #d2d2d7; border-radius: 10px; font-size: 14px; outline: none;" required>
                    <option value="Pending" <?php if($data['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Dikonfirmasi" <?php if($data['status'] == 'Dikonfirmasi') echo 'selected'; ?>>Dikonfirmasi</option>
                </select>
            </div>
            <div class="btn-group">
                <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>