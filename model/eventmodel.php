<?php
require_once '../config/Database.php';

class EventModel extends Database {
    
    // Fitur Read (Search, Filter, & Sorting)
    public function getEvents($keyword = "", $sort = "tanggal_daftar", $order = "DESC", $status = "", $bulan = "", $tahun = "") {
        // Validasi kolom agar aman dari SQL Injection
        $allowedSorts = ['id', 'nama_peserta', 'nama_event', 'tanggal_daftar', 'status'];
        $sort = in_array($sort, $allowedSorts) ? $sort : "tanggal_daftar";
        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $query = "SELECT * FROM pendaftaran_event WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            $query .= " AND (nama_peserta LIKE ? OR nama_event LIKE ?)";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
        }
        if (!empty($status)) {
            $query .= " AND status = ?";
            $params[] = $status;
        }
        if (!empty($bulan)) {
            $query .= " AND MONTH(tanggal_daftar) = ?";
            $params[] = $bulan;
        }
        if (!empty($tahun)) {
            $query .= " AND YEAR(tanggal_daftar) = ?";
            $params[] = $tahun;
        }

        $query .= " ORDER BY $sort $order";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addEvent($id, $nama_peserta, $nama_event, $tanggal, $file_bukti) {
        $stmt = $this->conn->prepare("INSERT INTO pendaftaran_event (id, nama_peserta, nama_event, tanggal_daftar, file_bukti) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$id, $nama_peserta, $nama_event, $tanggal, $file_bukti]);
    }

    public function deleteEvent($id) {
        $stmt = $this->conn->prepare("DELETE FROM pendaftaran_event WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getEventById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM pendaftaran_event WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEvent($id, $nama_peserta, $nama_event, $status) {
        $stmt = $this->conn->prepare("UPDATE pendaftaran_event SET nama_peserta = ?, nama_event = ?, status = ? WHERE id = ?");
        return $stmt->execute([$nama_peserta, $nama_event, $status, $id]);
    }
}
?>