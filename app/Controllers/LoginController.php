<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class LoginController extends BaseController
{
    public function index()
    {
//        dd(password_verify("test123", '$2y$10$HtFwpSbgzfdbKZKbe7ZmSOZ7Ye5MnPJbgyifmrPftbfEVCudSklvO'));
//        return password_hash("test123", PASSWORD_BCRYPT);
        return view('login');
    }
}
