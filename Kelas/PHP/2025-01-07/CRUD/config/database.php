<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'crud_barang';
    public $conn;

    public function __construct() {
        // Buat koneksi dengan error reporting
        $this->conn = new mysqli($this->host, $this->username, $this->password);
        
        if ($this->conn->connect_error) {
            die("Koneksi database gagal: " . $this->conn->connect_error);
        }

        // Cek dan buat database jika tidak ada
        $this->createDatabaseIfNotExists();
        
        // Pilih database
        $this->conn->select_db($this->database);
    }

    private function createDatabaseIfNotExists() {
        $sql = "CREATE DATABASE IF NOT EXISTS $this->database";
        if ($this->conn->query($sql) === FALSE) {
            die("Error membuat database: " . $this->conn->error);
        }
    }

    public function migrateTable() {
        $migration = new BarangTableMigration($this->conn);
        $migration->up();
        $migration->seedData();
    }

    public function __destruct() {
        $this->conn->close();
    }
}