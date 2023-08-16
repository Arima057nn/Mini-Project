<?php
require_once "../includes/config.php";

class Post extends DB
{
    public function getPostsByUser($userId)
    {
        try {
            $select = "SELECT * FROM Posts WHERE userId = ?";
            $stmt = $this->conn->prepare($select);
            $stmt->bind_param("s", $userId);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $posts = array();
                while ($row = $result->fetch_assoc()) {
                    $posts[] = $row;
                }
                return $posts;
            } else {
                throw new Exception("No posts found for this user");
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng
        }
    }

    public function createPostByUser($title, $level, $experience, $target, $salary, $address, $phone, $userId)
    {
        try {
            $insert = "INSERT INTO Posts (userId, title, level, experience, target, salary, address, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($insert);

            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $this->conn->error);
            }

            $stmt->bind_param("sssisiss", $userId, $title, $level, $experience, $target, $salary, $address, $phone);
            $result = $stmt->execute();

            if ($result) {
                if ($stmt->affected_rows > 0) {
                    return true;
                } else {
                    throw new Exception("No posts updated {$title} {$level} -{$userId}-");
                }
            } else {
                throw new Exception("Error executing statement: " . $stmt->error);
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng

        }
    }

    public function updatePostByUser($title, $level, $experience, $target, $salary, $address, $phone, $id)
    {
        try {
            $update = "UPDATE Posts SET title = ?, level = ?, experience = ?,target = ?, salary =?, address =?, phone =? WHERE id = ?";
            $stmt = $this->conn->prepare($update);
            $stmt->bind_param("ssisisss", $title, $level, $experience, $target, $salary, $address, $phone, $id); // "si" cho dữ liệu kiểu string và integer
            $stmt->execute();

            // Kiểm tra số hàng bị ảnh hưởng sau cập nhật
            if ($stmt->affected_rows > 0) {
                return true; // Trả về true nếu cập nhật thành công
            } else {
                // throw new Exception("No posts updated" . $title);
                throw new Exception("No posts updated {$title} {$level} -{$id}-");
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Trả về thông báo lỗi cho người dùng
        }
    }
}
