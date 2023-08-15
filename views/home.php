<?php

session_start();

if (!isset($_SESSION['user_success'])) {
    header('location:login.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
    <!-- <script src="../css/script.js"></script> -->

</head>

<body>

    <h1>Home</h1>
    <a href="logout.php">Logout !</a>

</body>



</html>