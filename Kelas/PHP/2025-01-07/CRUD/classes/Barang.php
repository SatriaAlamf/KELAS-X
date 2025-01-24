<?php
require_once 'config/database.php';

class Barang {
    private $db;
    private $table = 'barang';

    public function __construct() {
        $this->db = new Database();
    }

    // Method Create
    public function tambahBarang($nama, $deskripsi, $harga, $stok, $gambar) {
        $nama = $this->db->conn->real_escape_string($nama);
        $deskripsi = $this->db->conn->real_escape_string($deskripsi);
        
        $query = "INSERT INTO $this->table (nama_barang, deskripsi, harga, stok, gambar) 
                  VALUES ('$nama', '$deskripsi', $harga, $stok, '$gambar')";
        
        return $this->db->conn->query($query);
    }

    // Method Read
    public function ambilSemuaBarang() {
        $query = "SELECT * FROM $this->table ORDER BY id DESC";
        $result = $this->db->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method Update
    public function updateBarang($id, $nama, $deskripsi, $harga, $stok, $gambar = null) {
        $query = "UPDATE $this->table SET 
                  nama_barang = '$nama', 
                  deskripsi = '$deskripsi', 
                  harga = $harga, 
                  stok = $stok";
        
        if ($gambar) {
            $query .= ", gambar = '$gambar'";
        }
        
        $query .= " WHERE id = $id";
        
        return $this->db->conn->query($query);
    }

    // Method Delete
    public function hapusBarang($id) {
        $query = "DELETE FROM $this->table WHERE id = $id";
        return $this->db->conn->query($query);
    }

    // Method Upload Gambar
    public function uploadGambar($file) {
        $target_dir = "uploads/";
        $nama_file = time() . '_' . basename($file["name"]);
        $target_path = $target_dir . $nama_file;
        
        if (move_uploaded_file($file["tmp_name"], $target_path)) {
            return $nama_file;
        }
        
        return null;
    }
}