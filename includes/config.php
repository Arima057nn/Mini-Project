<?php

class DB
{
    private $host = "db4free.net";  // db4free.net
    private $user = "sbooks"; // sbooks
    private $password = "books123"; // books123
    private $database = "sbooks"; // books123
    protected $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
