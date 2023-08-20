<?php
require_once '../controllers/AuthController.php';

session_start();


if (isset($_SESSION['user_success'])) {
    header('location:home.php');
}

// // Trong một phần kiểm tra cookie ở trang đăng nhập
if (isset($_COOKIE['remember_me'])) {

    // Thực hiện đăng nhập tự động với thông tin từ cookie
    $authController = new AuthController($conn);
    $result = $authController->loginByToken($_COOKIE['remember_me']);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Tạo đối tượng AuthController và gọi phương thức đăng ký
    $authController = new AuthController($conn);
    $result = $authController->loginUser($email, $password);
    if ($result === true) {
        header('location:home.php');
        exit;
    } else {
        $error = $result;
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/styles.css">

</head>

<body>

    <div class="form-container">
        <form action="" method="POST">
            <h3>Login</h3>


            <?php
            if (isset($error)) {
                echo '<span class="error-msg">' . $error . '</span>';
            };
            ?>
            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="submit" name="submit" value="Login" class="form-btn" onclick="showToast()">
            <p>Don't have an account? <a href="register.php">Register now</a></p>
        </form>
    </div>

</body>

</html>