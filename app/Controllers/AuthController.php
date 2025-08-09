<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class AuthController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showLoginForm()
    {
        return view('Auth.login');
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['flash']['danger'] = 'Email hoặc mật khẩu không đúng.';
            header('Location: ' . route('login'));
            exit;
        }

        if ($user['status'] == 'inactive') {
            $_SESSION['flash']['warning'] = 'Tài khoản đã bị khóa.';
            header('Location: ' . route('login'));
            exit;
        }

        $_SESSION['user'] = [
            'id' => $user['user_id'],
            'name' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role_id']
        ];

        header('Location: ' . route('user'));
        exit;
    }

    public function showRegisterForm()
    {
        echo view('Auth.register');
    }

    public function register()
    {
        $name = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // Validate dữ liệu
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Vui lòng nhập họ tên';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        }

        if (empty($password) || strlen($password) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
        }

        if ($password !== $confirm) {
            $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp';
        }

        // Nếu có lỗi thì trả về view với thông báo lỗi
        if (!empty($errors)) {
            $_SESSION['flash'] = $errors;
            header('Location: ' . route('register'));
            exit;
        }

        // Kiểm tra email đã tồn tại chưa
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['flash']['email'] = 'Email đã được sử dụng';
            header('Location: ' . route('register'));
            exit;
        }

        // Thêm user vào database
        try {
            $inserted = $this->userModel->insert([
                'username' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role_id' => 1,
                'status' => 'active',
            ]);

            if ($inserted) {
                $_SESSION['flash']['success'] = 'Đăng ký thành công. Vui lòng đăng nhập.';
                header('Location: ' . route('login'));
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['flash']['error'] = 'Lỗi hệ thống: ' . $e->getMessage();
            header('Location: ' . route('register'));
            exit;
        }

        $_SESSION['flash']['error'] = 'Đăng ký không thành công';
        header('Location: ' . route('register'));
        exit;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: ' . route('/user'));
        exit;
    }
}
