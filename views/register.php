<?php

require_once '../controllers/AuthController.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Tạo đối tượng AuthController và gọi phương thức đăng ký
    $authController = new AuthController($conn);
    $result = $authController->registerUser($name, $email, $password, $cpassword);
    if ($result === true) {
        header('location:login.php');
    } else {
        $errors[] = $result;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../public/css/styles.css">

</head>

<body>
    <div class="form-container">
        <form action="" method="POST">
            <h3>Register</h3>
            <input type="text" name="name" required placeholder="enter your name">
            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="password" name="cpassword" required placeholder="confirm your password">
            <input type="submit" name="submit" value="register" class="form-btn">
            <p>already have an account? <a href="login.php">Login now</a></p>
        </form>
    </div>
</body>

</html>