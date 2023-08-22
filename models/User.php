<?php
require_once "../includes/config.php";

class User extends DB
{
    public function register($name, $email, $password, $cpassword)
    {
        try {
            $select = "SELECT * FROM Users WHERE email = ?";
            $stmt = $this->conn->prepare($select);
            $stmt->execute([$email]);

            // Hash mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->rowCount() > 0) {
                throw new Exception("Account already existed");
            } else {
                if ($password != $cpassword) {
                    throw new Exception("Password isn't matched!");
                } else {
                    $insert = "INSERT INTO Users(name, email, password) VALUES (?, ?, ?)";
                    $stmt = $this->conn->prepare($insert);
                    $result = $stmt->execute([$name, $email, $hashedPassword]);
                    if (!$result) {
                        throw new Exception("Error occurs when registering new user");
                    }
                    return true;
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ... Remaining methods here ...

    public function login($email, $password, $remember)
    {
        try {
            // Sử dụng prepared statement để tránh sự cố bảo mật SQL injection
            $sql = "SELECT * FROM Users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                // Lấy dữ liệu của người dùng từ kết quả truy vấn và lưu trữ nó vào biến user
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (password_verify($password, $user['password'])) {
                    // Đăng nhập thành công
                    $_SESSION['user_success'] = $user['id'];
                    $_SESSION['username'] = $user['name'];
                    
                    if ($remember === 1) {
                        $tokenId = $this->createToken($user['id'], $user['name']);
                        $this->setRememberMeCookie($tokenId);
                    }
                    
                    return true;
                } else {
                    throw new Exception("Password isn't correct");
                }
            } else {
                throw new Exception("Email isn't correct");
            }
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
            $sql = "DELETE FROM Tokens WHERE tokenId = :tokenId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':tokenId', $tokenId, PDO::PARAM_STR);
            $stmt->execute();
        }
        
        header('location: login.php');
    }

    public function loginToken($tokenId)
    {
        try {
            $sql = "SELECT * FROM Tokens WHERE tokenId = :tokenId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':tokenId', $tokenId, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                // Lấy dữ liệu của người dùng từ kết quả truy vấn và lưu trữ nó vào biến user
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_success'] = $user['userId'];
                $_SESSION['username'] = $user['name'];
                $this->setRememberMeCookie($tokenId);
                header('location: home.php');
                return true;
            } else {
                throw new Exception("Email isn't correct");
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng
        }
    }

    private function setRememberMeCookie($tokenId)
    {
        $cookieExpiration = time() + (60 * 10); // thoi gian het han 
        setcookie('remember_me', $tokenId, $cookieExpiration, '/');
    }

    private function createToken($userId, $name)
    {
        try {
            $token = bin2hex(random_bytes(32));
            $insert = "INSERT INTO Tokens (userId, name, tokenId) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($insert);

            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $this->conn->errorInfo()[2]);
            }

            $result = $stmt->execute([$userId, $name, $token]);

            if ($result) {
                if ($stmt->rowCount() > 0) {
                    return $token;
                } else {
                    throw new Exception("No rows inserted");
                }
            } else {
                throw new Exception("Error executing statement: " . $stmt->errorInfo()[2]);
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng
        }
    }
}
