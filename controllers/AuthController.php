<?php

require_once './models/User.php';

class AuthController
{
    private $userModel;
    private $contactModel;

    public function __construct()
    {
        $db = connectDB();
        $this->userModel = new User($db);
        $this->contactModel = new Contact($db);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = $this->userModel->authenticate($email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                if ($user['role_name'] == 'admin') {
                    header('Location:' . BASE_URL . '?act=admin');
                } else {
                    header('Location:' . BASE_URL);
                }
                exit;
            } else {
                $error = 'Email hoặc mật khẩu không đúng';
            }
        }
        require_once './views/user/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = [
                'role_id' => 2,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'phone' => trim($_POST['phone']),
            ];

            if ($this->userModel->create($data)) {
                header('Location:' . BASE_URL . '?act=login');
                exit;
            } else {
                $error = 'Đăng ký thất bại';
            }
        }
        require_once './views/user/register.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location:' . BASE_URL);
        exit;
    }

       public function profile() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $user = $this->userModel->getById($userId);
        $success = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'role_id' => $user['role_id'],
                'name' => trim($_POST['name'] ?? $user['name']),
                'email' => trim($_POST['email'] ?? $user['email']),
                'phone' => trim($_POST['phone'] ?? $user['phone'])
            ];

            if ($this->userModel->update($userId, $data)) {
                $success = 'Cập nhật thông tin thành công';
                $_SESSION['user'] = $this->userModel->getById($userId);
                $user = $_SESSION['user'];
            } else {
                $error = 'Cập nhật thông tin thất bại';
            }
        }

        require_once './views/user/profile.php';
    }
        public function contact() {
        $success = '';
        $error = '';
        $name = '';
        $email = '';
        $phone = '';

        if (isset($_SESSION['user'])) {
            $name = $_SESSION['user']['name'];
            $email = $_SESSION['user']['email'];
            $phone = $_SESSION['user']['phone'] ?? '';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_SESSION['user']['id'] ?? null,
                'name' => trim($_POST['name'] ?? $name),
                'email' => trim($_POST['email'] ?? $email),
                'phone' => trim($_POST['phone'] ?? $phone),
                'subject' => trim($_POST['subject'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),
                'status' => 'mới'
            ];

            if ($data['name'] === '' || $data['email'] === '' || $data['subject'] === '' || $data['message'] === '') {
                $error = 'Vui lòng điền đầy đủ thông tin liên hệ';
            } else {
                if ($this->contactModel->create($data)) {
                    $success = 'Gửi liên hệ thành công. Chúng tôi sẽ phản hồi sớm nhất.';
                    $subject = '';
                    $message = '';
                } else {
                    $error = 'Gửi liên hệ thất bại';
                }
            }
        }

        require_once './views/user/contact.php';
    }
}
