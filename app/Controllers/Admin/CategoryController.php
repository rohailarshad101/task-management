<?php

namespace App\Controllers\Admin;

use App\Models\CategoryModel;
use CodeIgniter\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $model = new CategoryModel();
        $data['categories'] = $model->findAll();

        return view('admin/categories/category_list', $data);
    }

    public function create()
    {
        return view('admin/categories/create_category');
    }

    public function store()
    {
        $model = new CategoryModel();

        $data = [
            'name' => $this->request->getPost('name'),
        ];

        $model->save($data);

        return redirect()->to('admin/categories');
    }

    public function edit($id)
    {
        $model = new CategoryModel();
        $data['category'] = $model->find($id);

        return view('admin/categories/edit_category', $data);
    }

    public function update($id)
    {
        $model = new CategoryModel();

        $data = [
            'name' => $this->request->getPost('name'),
        ];

        $model->update($id, $data);

        return redirect()->to('admin/categories');
    }

    public function delete($id)
    {
        // Check if ID is provided
        if ($id === null) {
            // Handle error, maybe redirect to tasks list
            return redirect()->to('admin/categories');
        }
        $model = new CategoryModel();
        $model->delete($id);

        return redirect()->to('admin/categories');
    }
}
