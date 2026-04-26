<?php

class Database {
    private static $instance = null;
    private $conn;

    private $host;
    private $db_name;
    private $username;
    private $password;

    private function __construct() {
        $creds = require_once __DIR__ . '/../../config/db_credentials.php';
        $this->host = $creds['host'];
        $this->db_name = $creds['db_name'];
        $this->username = $creds['username'];
        $this->password = $creds['password'];
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            die("Database connection failed. Please try again later.");
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Traditional mysqli wrapper for backward compatibility
    public function getMysqli() {
        return mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }
}
