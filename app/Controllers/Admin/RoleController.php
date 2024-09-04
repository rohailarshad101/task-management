<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;

class RoleController extends BaseController
{
    public function index()
    {
        $model = new RoleModel();
        $data['roles'] = $model->findAll();
        return view('admin/roles/roles_list', $data);
    }

    public function create()
    {
        return view('admin/roles/create_role');
    }

    public function store()
    {
        $model = new RoleModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        $model->save($data);
        return redirect()->to('admin/roles');
    }

    public function edit($id)
    {
        $model = new RoleModel();
        $data['role'] = $model->find($id);
        return view('admin/roles/edit_role', $data);
    }

    public function update($id)
    {
        $model = new RoleModel();

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        $model->save($data);
        return redirect()->to('admin/roles/roles_list');
    }

    public function delete($id)
    {
        $model = new RoleModel();
        $model->delete($id);
        return redirect()->to('admin/roles/roles_list');
    }
}
