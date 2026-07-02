<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Event</title>
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
        <h2>Tambah Pendaftaran Event</h2>
        <form action="../controller/EventProcess.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID / NIM</label>
                <input type="number" name="id" placeholder="Contoh: 251011700433" required>
            </div>
            <div class="form-group">
                <label>Nama Peserta</label>
                <input type="text" name="nama_peserta" required>
            </div>
            <div class="form-group">
                <label>Nama Event</label>
                <input type="text" name="nama_event" required>
            </div>
            <div class="form-group">
                <label>Unggah File Bukti (JPG/PNG/PDF)</label>
                <input type="file" name="file_bukti" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
            <div class="btn-group">
                <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</body>
</html>