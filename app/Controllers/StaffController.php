<?php
//Nơi này xử lý các thứ đến nhân viên
namespace App\Controllers;
class StaffController {
    public function index(){
        return view('Staff.layouts.admin');
    }
}