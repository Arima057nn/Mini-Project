<?php
$servername = "db4free.net";
$username = "sbooks";
$password = "books123";
$dbname = "sbooks";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
};
