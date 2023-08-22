<?php
require_once "../includes/config.php";

class Post extends DB
{
    public function getPostsByUser($userId)
    {
        try {
            $select = "SELECT * FROM Posts WHERE userId = ?";
            $stmt = $this->conn->prepare($select);
            $stmt->execute([$userId]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                return $result;
            } else {
                throw new Exception("No posts found for this user");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function createPostByUser($title, $level, $experience, $target, $salary, $address, $phone, $userId)
    {
        try {
            $insert = "INSERT INTO Posts (userId, title, level, experience, target, salary, address, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($insert);
            $result = $stmt->execute([$userId, $title, $level, $experience, $target, $salary, $address, $phone]);

            if ($result) {
                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    throw new Exception("No posts updated {$title} {$level} -{$userId}-");
                }
            } else {
                throw new Exception("Error executing statement: " . $stmt->errorInfo()[2]);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ... Remaining methods here ...

    public function updatePostByUser($title, $level, $experience, $target, $salary, $address, $phone, $id)
    {
        try {
            $update = "UPDATE Posts SET title = ?, level = ?, experience = ?, target = ?, salary = ?, address = ?, phone = ? WHERE id = ?";
            $stmt = $this->conn->prepare($update);

            $result = $stmt->execute([$title, $level, $experience, $target, $salary, $address, $phone, $id]);

            // Kiểm tra số hàng bị ảnh hưởng sau cập nhật
            if ($stmt->rowCount() > 0) {
                return true; // Trả về true nếu cập nhật thành công
            } else {
                // throw new Exception("No posts updated" . $title);
                throw new Exception("No posts updated {$title} {$level} -{$id}-");
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng
        }
    }

    public function deletePost(string $id) {
        $sql = "DELETE FROM Posts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        try {
            $stmt->execute([$id]);
            print('<p>Post was deleted successfully.</p>');
            header("Location: http://localhost/Mini-Project/views/home.php");
            die();
        } catch (PDOException $e) {
            print('<p>Error with database: ' . $e->getMessage() . '</p>');
        }
    }    
}
