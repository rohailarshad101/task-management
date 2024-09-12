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
            $user_email = $this->request->getPost('user_email');
            $password = $this->request->getPost('password');
            $userModel = new UserModel();
            $user = $userModel->where('email', $user_email)->active()->first(); // Fetch user by user_email

            if ($user === null) {
                // No user found with the provided user_email
                $session->setFlashdata('error', 'User not found');
            } elseif (!password_verify($password, $user['password'])) {
                // Password does not match
                $session->setFlashdata('error', 'Invalid password');
            }else{
                $user = $userModel->getUserByUserEmail($user_email);
                $user_role = $userModel->role($user['id']);
                // Fetch unread notifications for the logged-in user
                $notificationModel = new NotificationModel();
                $notifications = $notificationModel->where('user_id', $user['id'])
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();

                $session->set([
                    'user_id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'mobile' => $user['mobile'],
                    'role_id' => $user['role_id'],
                    'profile_picture' => $user['profile_picture'],
                    'role_name' => $user_role['name'],
                    'user_role' => $user_role['key'],
                    'middle_url' => ((int)$user['role_id'] === 1) ? "admin" : "user",
                    'logged_in' => true,
                    'notifications' => $notifications
                ]);
                // Set notifications in session
                session()->setFlashdata('notifications', $notifications);
                if((int)$user['role_id'] === 1){
                    $redirect = "/admin/dashboard";
                }else{
                    $redirect = "/user/dashboard";
                }

                return redirect()->to($redirect);
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
