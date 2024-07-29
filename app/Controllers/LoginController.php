<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class LoginController extends BaseController
{
    public function index()
    {
//        return password_hash("user123", PASSWORD_BCRYPT);
        return view('login');
    }
}
