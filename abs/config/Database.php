<?php
class Database {
    private $host = "localhost";
    private $db_name = "abs1_db";
    private $username = "root";
    private $password = ""; // XAMPP default
    public $conn;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        $this->conn = null;
        try {
            // PDO connection for secure DB access
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            // Throw exceptions on error
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Database Connection Error: " . $e->getMessage();
            exit;
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
