<?php
require_once "../models/Post.php";

class PostController
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function getPosts($userId)
    {
        return $this->postModel->getPostsByUser($userId);
    }


    public function updatePost($title, $level, $experience, $target, $salary, $address, $phone, $id)
    {
        return $this->postModel->updatePostByUser($title, $level, $experience, $target, $salary, $address, $phone, $id);
    }

    public function createPost($title, $level, $experience, $target, $salary, $address, $phone, $userId)
    {
        return $this->postModel->createPostByUser($title, $level, $experience, $target, $salary, $address, $phone, $userId);
    }
}
