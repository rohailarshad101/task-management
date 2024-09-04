<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class LoginController extends BaseController
{
    public function index()
    {
//        dd(password_verify("Aa(q^0d4#W5kEy", '$2y$10$aUdRjllyeZ9.exi06epDAeyvjJTnOQz17OodxLS0Uz0wj5v88cmFW'));
//        return password_hash("Aa(q^0d4#W5kEy", PASSWORD_BCRYPT);
        return view('login');
    }
}
