<?php
session_start();
if (isset($_SESSION['username'])) { header("Location: dashboard.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk - Pendaftaran Event</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background-color: #f5f5f7; display: flex; justify-content: center; align-items: center; height: 100vh; color: #1d1d1f; }
        .login-container { background: #ffffff; padding: 40px; border-radius: 18px; width: 100%; max-width: 400px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); border: 1px solid #e8e8ed; }
        h2 { font-weight: 600; font-size: 24px; margin-bottom: 8px; text-align: center; letter-spacing: -0.5px; }
        p { color: #86868b; font-size: 14px; text-align: center; margin-bottom: 24px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px; color: #1d1d1f; }
        input, select { width: 100%; padding: 12px; background: #f5f5f7; border: 1px solid #d2d2d7; border-radius: 10px; font-size: 15px; color: #1d1d1f; outline: none; transition: all 0.2s ease; }
        input:focus, select:focus { border-color: #000000; background: #ffffff; }
        .btn { width: 100%; padding: 12px; background: #1d1d1f; color: #ffffff; border: none; border-radius: 10px; font-size: 15px; font-weight: 500; cursor: pointer; margin-top: 10px; transition: background 0.2s ease; }
        .btn:hover { background: #000000; }
        .links { text-align: center; margin-top: 20px; font-size: 13px; color: #86868b; }
        .links a { color: #0066cc; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Pendaftaran Event</h2>
        <p>Silakan masuk ke akun Anda</p>
        <form action="../controller/AuthController.php?action=login" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Masuk</button>
        </form>
        <div class="links">
            Belum punya akun? <a href="register.php">Registrasi Akun</a> 
        </div>
    </div>
</body>
</html>