<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; } 

require_once '../model/EventModel.php';
require_once '../libs/fpdf/fpdf.php'; 

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

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 7, 'UNIVERSITAS PAMULANG', 0, 1, 'C'); 
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 5, 'FAKULTAS ILMU KOMPUTER - SISTEM INFORMASI S-1', 0, 1, 'C'); 
$pdf->SetFont('Arial', 'I', 9);
$pdf->Cell(0, 5, 'Jl. Puspitek Raya No. 10, Serpong, Tangerang Selatan', 0, 1, 'C'); 
$pdf->Ln(4);
$pdf->Line(10, 32, 200, 32); 
$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'LAPORAN DATA PENDAFTARAN EVENT', 0, 1, 'C');
$pdf->Ln(5);

// Membuat Header Tabel Dokumen Laporan 
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(245, 245, 247); 
$pdf->Cell(35, 8, 'ID / NIM', 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Nama Peserta', 1, 0, 'L', true);
$pdf->Cell(50, 8, 'Nama Event', 1, 0, 'L', true);
$pdf->Cell(30, 8, 'Tgl Daftar', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Status', 1, 1, 'C', true);

// Looping Pengisian Data Dinamis dari Database 
$pdf->SetFont('Arial', '', 10);
if(count($dataEvent) > 0) {
    foreach ($dataEvent as $row) {
        $pdf->Cell(35, 8, $row['id'], 1, 0, 'C');
        $pdf->Cell(50, 8, $row['nama_peserta'], 1, 0, 'L');
        $pdf->Cell(50, 8, $row['nama_event'], 1, 0, 'L');
        $pdf->Cell(30, 8, date('d-m-Y', strtotime($row['tanggal_daftar'])), 1, 0, 'C');
        $pdf->Cell(25, 8, $row['status'], 1, 1, 'C');
    }
} else {
    $pdf->SetTextColor(134, 134, 139);
    $pdf->Cell(190, 10, 'Tidak ada data yang ditemukan sesuai filter.', 1, 1, 'C');
}

$pdf->Output('I', 'Laporan_Pendaftaran_Event_251011700433.pdf');
?>