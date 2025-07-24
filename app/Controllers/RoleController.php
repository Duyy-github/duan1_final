<?php
namespace App\Controllers;
use App\Models\Role;
use App\Controllers\Controller;

class RoleController extends Controller
{
    private $roleModel;

    public function __construct()
    {
        $this->roleModel = new Role();
    }
    public function index()
    {
        $roles = $this->roleModel->getAll();
        return view('Staff.roles.index', compact('roles'));
    }
}