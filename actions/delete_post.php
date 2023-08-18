<?php
require_once '../controllers/PostController.php';
session_start();
if (!isset($_SESSION['user_success'])) {
    header('location:login.php');
}
if (isset($_GET['id'])) {
    $postController = new PostController();
    $postController->deletePost($_GET['id']);

    $response = array('message' => 'Post deleted successfully.');
    header('Location: http://localhost/Mini-Project/views/home.php');
    exit();
}
?>