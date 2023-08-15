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
                return true;
            } else return "mat khau khong chinh xac";
        } else return "Email khong chinh xac"; // dang nhap that bai
    }

    public function logout()
    {
        // Hủy phiên làm việc và xóa tất cả dữ liệu phiên
        session_unset();
        session_destroy();
    }
}
