<?php
require_once "../includes/config.php";

class User extends DB
{
    public function register($name, $email, $password, $cpassword)
    {
        try {
            $select = "SELECT * FROM Users WHERE email = '$email'";
            $find = $this->conn->query($select);

            // Hash mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if ($find->num_rows > 0) {
                throw new Exception("Tai khoan da ton tai");
            } else {
                if ($password != $cpassword) {
                    throw new Exception("password not matched!");
                } else {
                    $insert = "INSERT INTO Users(name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
                    $result = $this->conn->query($insert);
                    if (!$result) {
                        throw new Exception("Đã xảy ra lỗi khi đăng ký người dùng.");
                    }
                    return true;
                }
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng
        }
    }

    public function login($email, $password)
    {
        // Lấy thông tin người dùng từ cơ sở dữ liệu dựa trên tên người dùng
        $sql = "SELECT * FROM Users WHERE email = '$email'";
        //truy van
        $result = $this->conn->query($sql);
        if ($result->num_rows === 1) {
            //Lấy dữ liệu của người dùng từ đối tượng kết quả truy vấn và lưu trữ nó vào user
            $user = $result->fetch_assoc();

            // ham kiểm tra mật khẩu có khớp với mật khẩu đã hash hay không
            if (password_verify($password, $user['password'])) {
                //dang nhap thanh cong
                $_SESSION['user_success'] = $user['id'];
                $this->setRembermeCookie($email, $password);
                return true;
            } else return "mat khau khong chinh xac";
        } else return "Email khong chinh xac"; // dang nhap that bai
    }

    public function logout()
    {
        // Hủy phiên làm việc và xóa tất cả dữ liệu phiên
        session_unset();
        session_destroy();

        // Xóa cookie 'remember_me'
        $cookie_name = 'remember_me';
        $cookie_path = '/'; // Đảm bảo cookie có phạm vi toàn bộ trang web
        $cookie_domain = $_SERVER['localhost']; // Lấy tên miền của trang web
        setcookie($cookie_name, '', time() - 3600, $cookie_path, $cookie_domain, true, true);
    }

    private function setRembermeCookie($email, $password)
    {
        $dataToEncrypt = $email . '|' . $password;
        $cipher_algo = "aes-256-cbc"; // Thuật toán mã hóa
        $encryption_key = "your_encryption_key_here"; // khóa bạn sử dụng để mã hóa và giải mã dữ liệu
        $iv_length = openssl_cipher_iv_length($cipher_algo); //  độ dài của Initialization Vector (IV) dành cho thuật toán mã hóa 
        $iv = openssl_random_pseudo_bytes($iv_length); //  Initialization Vector (IV) 

        // Mã hóa thông tin đăng nhập
        $encryptedData = openssl_encrypt($dataToEncrypt, $cipher_algo, $encryption_key, 0, $iv);

        // Kết hợp IV với dữ liệu mã hóa để giải mã sau này
        $cookieValue = base64_encode($iv . $encryptedData);

        $cookieExpiration = time() + (180); // thoi gian het han 
        setcookie('remember_me', $cookieValue, $cookieExpiration, '/');
    }

    // hàm sinh chuỗi ngẫu nhiên với độ dài mặc định là 32 byte.
    // private function generateEncryptionKey($length = 32)
    // {
    //     return bin2hex(random_bytes($length)); // tạo ra chuỗi ngẫu nhiên dưới dạng byte.
    // }
}
