<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DepartmentModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DepartmentController extends BaseController
{
    protected $departmentModel;

    public function __construct()
    {
        $this->departmentModel = new DepartmentModel();
    }

    // List all departments
    public function index()
    {
        $data['departments'] = $this->departmentModel->findAll();
        return view('admin/departments/departments_list', $data);
    }

    // Show the create department form
    public function create()
    {
        return view('admin/departments/create_department');
    }

    // Store a new department
    public function store()
    {
        $this->departmentModel->save([
            'name' => $this->request->getPost('name')
        ]);
        return redirect()->to('/admin/departments');
    }

    // Show the edit form
    public function edit($id)
    {
        $data['department'] = $this->departmentModel->find($id);
        if (!$data['department']) {
            throw PageNotFoundException::forPageNotFound();
        }
        return view('admin/departments/edit_department', $data);
    }

    // Update a department
    public function update($id)
    {
        $this->departmentModel->update($id, [
            'name' => $this->request->getPost('name')
        ]);
        return redirect()->to('/admin/departments');
    }

    // Delete a department
    public function delete($id)
    {
        $this->departmentModel->delete($id);
        return redirect()->to('/admin/departments');
    }
}
