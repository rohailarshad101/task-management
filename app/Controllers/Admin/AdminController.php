<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function __constrcut()
    {
        if (!session()->get('logged_in') || session()->get('role_id') != 1) {
            return redirect()->to('/login');
        }
    }

    public function dashboard()
    {
        return view('admin/admin_dashboard');
    }

    public function profile()
    {
        $data['user_id'] = session()->get('user_id');
        $data['first_name'] = session()->get('first_name');
        $data['last_name'] = session()->get('last_name');
        $data['email'] = session()->get('email');
        $data['mobile'] = session()->get('mobile');
        return view('admin/admin_profile', $data);
    }
}
