<?php

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $db = connectDB();
        $this->userModel = new User($db);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = ($_POST['password']);

            $user =$this->userModel->authenticate($email, $password);
            if($user){
                $_SESSION['user'] =$user;
                if($user['role_name'] == 'admin'){
                    header('Location:' . BASE_URL . '?act=admin');
                }else{
                    header('Location:' . BASE_URL);
                }
                exit;
            }else{
                $error = 'Email hoặc mật khẩu không đúng';
            }
        }
        require_once './views/user/login.php';
    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data = [
                'role_id'=> 2,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => $_POST['name'],
                'phone' => trim($_POST['phone']),
            ];

            if($this->userModel->create($data)){
                header('Location:' . BASE_URL . '?act=login');
                exit;
            }else{
                $error = 'Đăng ký thất bại';
            }
        }
        require_once './views/user/register.php';
    }

    public function logout(){
        session_destroy();
        header('Location:' . BASE_URL);
        exit;
    }
}
