<?php

require_once '../controllers/AuthController.php';

session_start();

$authController = new AuthController($conn);
$authController->logoutUser();

header('location:login.php');
