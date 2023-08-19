<?php
require_once '../controllers/AuthController.php';

session_start();


if (isset($_SESSION['user_success'])) {
    header('location:home.php');
}

// // Trong một phần kiểm tra cookie ở trang đăng nhập
if (isset($_COOKIE['remember_me'])) {
    $cipher_algo = "aes-256-cbc"; // Cùng thuật toán đã sử dụng để mã hóa

    // Chuỗi mã hóa được lưu trong cookie
    $encoded_cookie_value = $_COOKIE['remember_me'];

    // Giải mã chuỗi base64 để lấy IV và dữ liệu mã hóa
    $decoded_cookie_value = base64_decode($encoded_cookie_value);

    $iv_length = openssl_cipher_iv_length($cipher_algo);
    $iv = substr($decoded_cookie_value, 0, $iv_length); // Lấy IV từ đầu chuỗi
    $encrypted_data = substr($decoded_cookie_value, $iv_length); // Lấy dữ liệu mã hóa

    $encryption_key = "your_encryption_key_here"; // Khóa mã hóa mà bạn đã sử dụng

    // Giải mã dữ liệu
    $decrypted_data = openssl_decrypt($encrypted_data, $cipher_algo, $encryption_key, 0, $iv);

    list($email, $password) = explode('|', $decrypted_data);



    // Thực hiện đăng nhập tự động với thông tin từ cookie
    $authController = new AuthController($conn);
    $result = $authController->loginUser($email, $password, true);
    if ($result === true) {
        header('location:home.php');
        $_SESSION['user_success'] = "user";
        exit();
    }
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