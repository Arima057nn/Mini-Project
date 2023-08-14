<?php
    class DB {
        private $host = 'db4free.net';
        private $user = 'sbooks';
        private $password = 'books123';
        private $database = 'sbooks';
        protected $conn;

        public function __construct() {
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            // else printf("Connection succeeded!");
        }
    }
?>
