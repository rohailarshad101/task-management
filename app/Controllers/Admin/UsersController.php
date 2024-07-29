<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll();

        return view('admin/users/users_list', $data);
    }

    public function create()
    {
        return view('admin/users/create_user');
    }

    public function store()
    {
        $model = new UserModel();

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
        ];

        $model->save($data);

        return redirect()->to('admin/users');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $data['user'] = $model->find($id);

        return view('admin/users/edit_user', $data);
    }

    public function update($id)
    {
        $model = new UserModel();

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
        ];

        $model->update($id, $data);

        return redirect()->to('admin/users');
    }

    public function delete($id)
    {
        // Check if ID is provided
        if ($id === null) {
            // Handle error, maybe redirect to tasks list
            return redirect()->to('admin/users');
        }
        $model = new UserModel();
        $model->delete($id);

        return redirect()->to('admin/users');
    }
}
