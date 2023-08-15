<?php
    require_once '../config/db.php';

    class Post extends DB {
        public function getAllPosts() {
            $sql = "SELECT * FROM Posts";
            $result = $this->conn->query($sql);
            if (!$result) {
                throw new Exception("Database Error [{$this->conn->errno}] {$this->conn->error}");
            }
            // var_dump($result);
            return $result;
        }

        public function getPostN(string $id) {
            $sql = "SELECT * FROM Posts WHERE id = \"$id\"";
            $result = $this->conn->query($sql);
            if (!$result) {
                throw new Exception("Database Error [{$this->conn->errno}] {$this->conn->error}");
            }
            // var_dump($result);
            return $result;
        }

        public function createPost(string $submitted, string $title, string $level, string $experience, string $target, string $salary, string $address, string $phone) {
            $_POST['submitted'] = $submitted;
            $_POST['title'] = $title;
            $_POST['level'] = $level;
            $_POST['experience'] = $experience;
            $_POST['target'] = $target;
            $_POST['salary'] = $salary;
            $_POST['address'] = $address;
            $_POST['phone'] = $phone;

            $submitted = isset($_POST['submitted']) && $_POST['submitted'] == 1;
            if ($submitted) {
                $errors = [];

                if (!isset($_POST['title']) || $_POST['title'] == null)
                    $errors[] = 'title is not specified';
                if (!isset($_POST['level']) || $_POST['level'] == null)
                    $errors[] = 'level is not specified';
                if (!isset($_POST['experience']) || $_POST['experience'] == null)
                    $errors[] = 'experience is not specified';
                if (!isset($_POST['target']) || $_POST['target'] == null)
                    $errors[] = 'target is not specified';
                if (!isset($_POST['salary']) || $_POST['salary'] == null)
                    $errors[] = 'salary is not specified';
                if (!isset($_POST['address']) || $_POST['address'] == null)
                    $errors[] = 'address is not specified';
                if (!isset($_POST['phone']) || $_POST['phone'] == null)
                    $errors[] = 'phone is not specified';

                if (count($errors) > 0) {
                    print('<p>Errors:</p>' .
                        implode(array_map(fn($e) => "<p>- $e</p>", $errors)));
                } else {

                    try {
                        $query = 'insert into Posts set title = ?, level = ?, experience = ?, target = ?, salary = ?, address = ?, phone = ?';
                        $stmt = $this->conn->prepare($query);

                        $stmt->bind_param('sssssss', $_POST['title'], $_POST['level'], $_POST['experience'], $_POST['target'], $_POST['salary'], $_POST['address'], $_POST['phone']);
                        $stmt->execute();

                        print('<p>New post was added successfully.</p>');

                        // Return to dashboard and update index() method
                        header("Location: http://localhost:3000/views/dashboard.php");
                        die();

                    } catch(mysqli_sql_exception $e) {
                        print('<p>Error with database: ' . $e . '</p>');
                    }

                }
            }
        }

        // Thêm các phương thức CRUD khác tương tự
    }
?>
