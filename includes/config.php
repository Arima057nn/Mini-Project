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
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
