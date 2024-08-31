<?php

namespace App\Controllers;

use App\Models\TaskModel;

class UserBaseController extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('logged_in') || session()->get('role_id') != 2) {
            return redirect()->to('/login');
        }

        $model = new TaskModel();
        $data['tasks'] = $model->getUserRelatedTasks();
        return view('user_dashboard');
    }
}
