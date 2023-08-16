<?php
require_once '../controllers/PostController.php';
session_start();

if (!isset($_SESSION['user_success'])) {
    header('location:login.php');
}
$postController = new PostController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitted2']) && $_POST['submitted2'] == 1) {
        $id = $_POST['postId']; // Đặt tên biến tùy theo tên bạn đã đặt trong form

        $title = $_POST['title'];
        $level = $_POST['level'];
        $experience = $_POST['experience'];
        $target = $_POST['target'];
        $salary = $_POST['salary'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $result = $postController->updatePost($title, $level, $experience, $target, $salary, $address, $phone, $id);


        // Sau khi cập nhật, bạn có thể chuyển hướng về trang chính hoặc thực hiện các hành động khác
        header('Location: http://localhost:80/Mini-Project/views/home.php');
        exit();
    }
}



// var_dump($posts);
