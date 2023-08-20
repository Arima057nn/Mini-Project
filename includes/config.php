<?php

class DB
{
    private $host = "localhost";  // db4free.net
    private $user = "root"; // sbooks
    private $password = "uchihaSARADA97@"; // books123
    private $database = "Books"; // books123
    protected $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
