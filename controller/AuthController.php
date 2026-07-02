<?php
session_start();
require_once '../config/Database.php';

class AuthController extends Database {
    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header("Location: ../view/dashboard.php");
        } else {
            echo "<script>alert('Username atau Password salah!'); window.location.href='../view/login.php';</script>";
        }
    }

    public function register($nama_lengkap, $username, $password) {
        // Cek username apakah sudah ada
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if($stmt->rowCount() > 0) {
            echo "<script>alert('Username sudah terdaftar!'); window.location.href='../view/register.php';</script>";
            return;
        }

        // Enkripsi password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (nama_lengkap, username, password) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$nama_lengkap, $username, $hashed_password])) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='../view/login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal!'); window.location.href='../view/register.php';</script>";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../view/login.php");
    }
}

$auth = new AuthController();
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'login') {
    $auth->login($_POST['username'], $_POST['password']);
} elseif ($action == 'register') {
    $auth->register($_POST['nama_lengkap'], $_POST['username'], $_POST['password']);
} elseif ($action == 'logout') {
    $auth->logout();
}
?>