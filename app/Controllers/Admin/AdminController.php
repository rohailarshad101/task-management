<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $customConfig = '';

    public function __construct()
    {
        $this->customConfig = config('CustomConfig');
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
        $userModel = new UserModel();
        $data['user'] = $userModel->find(session()->get('user_id'));

        if(empty($data['user']['profile_picture'])){
            $data['user']['profile_picture'] = 'vendors/images/faces/default.png';
        }
        return view('admin/admin_profile', $data);
    }

    public function updateUserProfile()
    {
        $user_model = new UserModel();
        $post = $this->request->getPost();
        $user_id = session()->get('user_id');
        $session = \Config\Services::session();
        $data = [];
        $user_profile_picture = $this->request->getFile('profile_picture');
        if ($user_profile_picture->isValid() && !$user_profile_picture->hasMoved()&& !$user_profile_picture->getSize() !== 0) {
            // Define a new filename to avoid conflicts
            $original_file_name = pathinfo($user_profile_picture->getName(), PATHINFO_FILENAME);
            $new_file_name = $original_file_name.'-'.substr($user_profile_picture->getRandomName(),11);

            // Move the file to the desired directory
            $filePath = $this->customConfig->file_upload_path['tasks_file_path'];
            $user_profile_picture->move($filePath, $new_file_name);
            $user_profile_picture = $filePath.'/'.$new_file_name;
            $data['profile_picture'] = $user_profile_picture;
            $session->set(['profile_picture' => $user_profile_picture]);
        }

        $data['first_name'] = $post['first_name'];
        $data['last_name'] = $post['last_name'];
        $data['email'] = $post['user_email'];
        $data['mobile'] = $post['user_mobile'];
        $user_model->update($user_id, $data);


        $session->set([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile']
        ]);

        return redirect()->to('admin/profile');
    }
}
