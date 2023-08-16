<?php
    require_once '../models/Post.php';

    class PostController {
        private $postModel;

        public function __construct() {
            $this->postModel = new Post();
        }

        public function index() {
            $posts = $this->postModel->getAllPosts();
            return $posts;
        }

        public function indexPostN(string $id) {
            $posts = $this->postModel->getPostN($id);
            return $posts;
        }

        public function create(string $submitted, string $title, string $level, string $experience, string $target, string $salary, string $address, string $phone) {
            $posts = $this->postModel->createPost($submitted, $title, $level, $experience, $target, $salary, $address, $phone);
            return $posts;
        }

        public function update(string $submitted2, string $id, string $title, string $level, string $experience, string $target, string $salary, string $address, string $phone) {
            $posts = $this->postModel->updatePostN($submitted2, $id, $title, $level, $experience, $target, $salary, $address, $phone);
            // $posts = $this->postModel->getAllPosts();
            return $posts;
        }

        // Thêm các phương thức CRUD khác tương tự
    }
?>
