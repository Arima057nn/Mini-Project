<?php
require_once "../models/User.php";

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Register user
    public function registerUser($name, $email, $password, $cpassword)
    {
        return $this->userModel->register($name, $email, $password, $cpassword);
    }

    public function loginUser($email, $password)
    {
        return $this->userModel->login($email, $password);
    }


    public function logoutUser()
    {
        $this->userModel->logout();
    }

    public function loginByToken($tokenId)
    {
        $this->userModel->loginToken($tokenId);
    }
}
