<?php
namespace App\Controllers;
use App\Models\User;
use App\Models\Role;
use App\Controllers\Controller;

class UserController extends Controller
{
    private $userModel;
    private $roleModel;
    public function __construct()
    {
        $this->userModel = new User();
        $this->roleModel = new Role();

    }
    public function index()
    {
        $users = $this->userModel->getAll();
        return view('Staff.users.index', compact('users'));
    }
    public function updateStatus($id)
    {
        $user = $this->userModel->findById($id);
        if (!$user) {
            setFlash('error', 'Người dùng không tồn tại');
            redirect('staff/users');
        }

        // Chuyển đổi trạng thái
        $newStatus = $user['status'] === 'active' ? 'banned' : 'active';
        $this->userModel->updateStatus($id, $newStatus);

        setFlash('success', 'Trạng thái người dùng đã được cập nhật thành công');
        redirect('staff/users');
    }

}