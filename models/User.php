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

    public function login($email, $password, $remember)
    {
        try {
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
                    if ($remember === 1) {
                        $tokenId = $this->createToken($user['id']);
                        $this->setRembermeCookie($tokenId);
                    }
                    return true;
                } else
                    throw new Exception("mat khau khong chinh xac.");
            } else throw new Exception("Email khong chinh xac."); // dang nhap that bai

        } catch (Exception $e) {

            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng
        }
    }

    public function logout()
    {
        // Hủy phiên làm việc và xóa tất cả dữ liệu phiên
        session_unset();
        session_destroy();

        if (isset($_COOKIE['remember_me'])) {

            // Xóa cookie 'remember_me'
            $cookie_name = 'remember_me';
            $cookie_path = '/'; // Đảm bảo cookie có phạm vi toàn bộ trang web
            $cookie_domain = $_SERVER['localhost']; // Lấy tên miền của trang web
            setcookie($cookie_name, '', time() - 3600, $cookie_path, $cookie_domain, true, true);

            $tokenId = $_COOKIE['remember_me'];
            $sql = "DELETE FROM Tokens WHERE tokenId = '$tokenId'";
            //truy van
            $this->conn->query($sql);
        }
        header('location:login.php');
    }


    public function loginToken($tokenId)
    {
        try {
            $sql = "SELECT * FROM Tokens WHERE tokenId = '$tokenId'";
            //truy van
            $result = $this->conn->query($sql);
            if ($result->num_rows === 1) {
                //Lấy dữ liệu của người dùng từ đối tượng kết quả truy vấn và lưu trữ nó vào user
                $user = $result->fetch_assoc();
                $_SESSION['user_success'] = $user['userId'];
                $this->setRembermeCookie($tokenId);
                header('location:home.php');
                return true;
            } else throw new Exception("Email khong chinh xac."); // dang nhap that bai

        } catch (Exception $e) {

            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng
        }
    }


    private function setRembermeCookie($tokenId)
    {


        $cookieExpiration = time() + (60 * 10); // thoi gian het han 
        setcookie('remember_me', $tokenId, $cookieExpiration, '/');
    }

    private function createToken($userId)
    {
        try {
            $token = bin2hex(random_bytes(32));
            $insert = "INSERT INTO Tokens (userId,tokenId) VALUES (?,?)";
            $stmt = $this->conn->prepare($insert);
            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $this->conn->error);
            }
            $stmt->bind_param("ss", $userId, $token);
            $result = $stmt->execute();
            if ($result) {
                if ($stmt->affected_rows > 0) {
                    return $token;
                } else {
                    throw new Exception("No posts updated");
                }
            } else {
                throw new Exception("Error executing statement: " . $stmt->error);
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng
        }
    }
}
