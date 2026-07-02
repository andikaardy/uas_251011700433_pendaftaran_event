<?php
session_start();
if (isset($_SESSION['username'])) { header("Location: dashboard.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Pendaftaran Event</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background-color: #f5f5f7; display: flex; justify-content: center; align-items: center; height: 100vh; color: #1d1d1f; }
        .login-container { background: #ffffff; padding: 40px; border-radius: 18px; width: 100%; max-width: 450px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); border: 1px solid #e8e8ed; }
        h2 { font-weight: 600; font-size: 24px; margin-bottom: 8px; text-align: center; letter-spacing: -0.5px; }
        p { color: #86868b; font-size: 14px; text-align: center; margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px; color: #1d1d1f; }
        input { width: 100%; padding: 12px; background: #f5f5f7; border: 1px solid #d2d2d7; border-radius: 10px; font-size: 14px; outline: none; transition: all 0.2s; }
        input:focus { border-color: #000000; background: #ffffff; }
        .btn { width: 100%; padding: 12px; background: #1d1d1f; color: #ffffff; border: none; border-radius: 10px; font-size: 15px; font-weight: 500; cursor: pointer; margin-top: 10px; transition: 0.2s; }
        .btn:hover { background: #000000; }
        .links { text-align: center; margin-top: 20px; font-size: 13px; }
        .links a { color: #0066cc; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Buat Akun Baru</h2>
        <p>Silakan isi data diri Anda</p>
        <form action="../controller/AuthController.php?action=register" method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Daftar Sekarang</button>
        </form>
        <div class="links">
            Sudah punya akun? <a href="login.php">Masuk di sini</a>
        </div>
    </div>
</body>
</html>