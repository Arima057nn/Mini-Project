<?php
require_once '../controllers/AuthController.php';

session_start();

if (isset($_SESSION['user_success'])) {
    header('location:home.php');
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
        $_SESSION['user_success'] = "user";
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

            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="submit" name="submit" value="Login" class="form-btn" onclick="showToast()">
            <p>Don't have an account? <a href="register.php">Register now</a></p>
        </form>
    </div>
    <script>
        function showToast() {
            var toast = document.getElementById("toast");
            toast.style.display = "block";
            setTimeout(function() {
                toast.style.display = "none";
            }, 3000); // Hide the toast after 3 seconds
        }
    </script>
</body>

</html>