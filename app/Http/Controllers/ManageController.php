<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageController extends Controller
{
    // Action thực hiện chức năng dashboard (xử lý route /manage/)
    public function index() {
        // Điều hướng về route tên manage.dashboard
        return redirect()->route('manage.dashboard');
    }

    // Action thực hiện chức năng dashboard (xử lý route /manage/dashboard/)
    public function dashboard() {
        // Kết xuất view tương ứng trong file views/manage/dashboard.blade.php
        return view('manage.dashboard');
    }
}
