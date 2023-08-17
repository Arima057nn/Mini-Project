<?php
require_once '../controllers/PostController.php';
session_start();

if (!isset($_SESSION['user_success'])) {
    header('location:login.php');
}
$postController = new PostController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitted']) && $_POST['submitted'] == 1) {
        $title = $_POST['title'];
        $level = $_POST['level'];
        $experience = $_POST['experience'];
        $target = $_POST['target'];
        $salary = $_POST['salary'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $result = $postController->createPost($title, $level, $experience, $target, $salary, $address, $phone, "US0003");
        // var_dump($result);

        // Sau khi cập nhật, bạn có thể chuyển hướng về trang chính hoặc thực hiện các hành động khác
        header('Location: http://localhost:80/Mini-Project/views/home.php');
        exit();
    }
}



// var_dump($posts);
