<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        $session = session();

        if (strtolower($this->request->getMethod()) === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->getUserByUsername($username);
            $user_role = $userModel->role($user['id']);

            if ($user && password_verify($password, $user['password'])) {
                $session->set([
                    'user_id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'mobile' => $user['mobile'],
                    'username' => $user['username'],
                    'role_id' => $user['role_id'],
                    'role_name' => $user_role['name'],
                    'middle_url' => ((int)$user['role_id'] === 1) ? "admin" : "user",
                    'logged_in' => true
                ]);
                if((int)$user['role_id'] === 1){
                    $redirect = "/admin/dashboard";
                }else{
                    // Fetch unread notifications for the logged-in user
                    $notificationModel = new NotificationModel();
                    $notifications = $notificationModel->where('user_id', $user['id'])
                        ->where('is_read', 0)
                        ->orderBy('created_at', 'DESC')
                        ->findAll();

                    // Pass the notifications to the view or store in session
                    $session->set('notifications', $notifications);
                    $redirect = "/user/dashboard";
                }
                return redirect()->to($redirect);
            } else {
                $session->setFlashdata('error', 'Invalid username or password');
            }

        }

        return view('login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
