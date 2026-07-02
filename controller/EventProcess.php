<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: ../view/login.php"); exit; }
require_once '../model/EventModel.php';

$eventModel = new EventModel();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // LOGIKA TAMBAH DATA (CREATE) & UPLOAD FILE
    if (isset($_POST['id']) && !isset($_POST['edit_id'])) { 
        $id = $_POST['id'];
        $nama_peserta = $_POST['nama_peserta'];
        $nama_event = $_POST['nama_event'];
        $tanggal = date('Y-m-d'); 
        
        // Logika Upload File
        $file_name = $_FILES['file_bukti']['name'];
        $file_tmp = $_FILES['file_bukti']['tmp_name'];
        $file_error = $_FILES['file_bukti']['error'];
        
        $ext = explode('.', $file_name);
        $file_ext = strtolower(end($ext));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf'); 
        
        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                // Membuat nama file unik
                $file_destination = '../uploads/' . uniqid() . '.' . $file_ext;
                
                if (!is_dir('../uploads')) { mkdir('../uploads', 0777, true); }
                
                move_uploaded_file($file_tmp, $file_destination);
                
                if ($eventModel->addEvent($id, $nama_peserta, $nama_event, $tanggal, $file_destination)) {
                    echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='../view/dashboard.php';</script>";
                } else {
                    echo "<script>alert('Gagal menambahkan data!'); window.location.href='../view/tambah_event.php';</script>";
                }
            }
        } else {
            echo "<script>alert('Ekstensi file tidak diizinkan! Hanya JPG, PNG, PDF.'); window.location.href='../view/tambah_event.php';</script>";
        }
    } 
    
    // LOGIKA UBAH DATA (UPDATE)
    elseif (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $nama_peserta = $_POST['nama_peserta'];
        $nama_event = $_POST['nama_event'];
        $status = $_POST['status']; 

        if ($eventModel->updateEvent($id, $nama_peserta, $nama_event, $status)) {
            echo "<script>alert('Data berhasil diubah!'); window.location.href='../view/dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal mengubah data!'); window.location.href='../view/edit_event.php?id=$id';</script>";
        }
    }
}
?>