<?php
require_once '../controllers/PostController.php';
session_start();

if (!isset($_SESSION['user_success'])) {
    header('location:login.php');
}
$postController = new PostController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitted2']) && $_POST['submitted2'] == 1 && preg_match("/^[0-9]{10}$/", trim($_POST['phone'])) && strlen(trim($_POST['phone'])) == 10
    && preg_match("/^\d+$/", trim($_POST['salary'])) && preg_match("/^\d+$/", trim($_POST['experience']))) {
        $id = trim($_POST['postId']); // Đặt tên biến tùy theo tên bạn đã đặt trong form
        $title = trim($_POST['title']);
        $level = trim($_POST['level']);
        $experience = trim($_POST['experience']);
        $target = trim($_POST['target']);
        $salary = trim($_POST['salary']);
        $address = trim($_POST['address']);
        $phone = trim($_POST['phone']);
        $result = $postController->updatePost($title, $level, $experience, $target, $salary, $address, $phone, $id);
    }
    // Sau khi cập nhật, bạn có thể chuyển hướng về trang chính hoặc thực hiện các hành động khác
    header('Location: http://localhost:80/Mini-Project/views/home.php');
    exit();
}



// var_dump($posts);
