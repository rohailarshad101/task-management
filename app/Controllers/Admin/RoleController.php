<?php

namespace App\Controllers\Admin;

use App\Controllers\ApiResponse;
use App\Controllers\BaseController;
use App\Models\AccessMatrixModel;
use App\Models\RoleModel;
use Config\CustomConfig;

class RoleController extends BaseController
{
    protected $user_id;
    protected $customConfig = '';

    public function __construct()
    {
        $this->user_id = session()->get('user_id');
        $this->session = session();
        $this->customConfig = config('CustomConfig');
    }

    public function index()
    {
        $model = new RoleModel();
        $data['roles'] = $model->where("key !=", "super_admin")->findAll();
        return view('admin/roles/roles_list', $data);
    }

    public function create()
    {
        return view('admin/roles/create_role');
    }

    public function store()
    {
        $model = new RoleModel();
        $name = $this->request->getPost('name');
        $key = str_replace(" ", "_", $name);
        $data = [
            'name' => $name,
            'key' => $key,
            'description' => $this->request->getPost('description'),
        ];

        $model->save($data);
        return redirect()->to('admin/roles');
    }

    public function edit($id)
    {
        $model = new RoleModel();
        $data['roleAccessMatrix'] = [];
        $roleAccessMatrix = $model->getRoleAccessMatrix($id);
        $data['roleAccessMatrix'] = json_decode($roleAccessMatrix['access']);
        $data['moduleList'] = $this->customConfig->module_list_array;

        $data['role'] = $model->find($id);
        return view('admin/roles/edit_role', $data);
    }

    public function update($id)
    {
        $model = new RoleModel();
        $name = $this->request->getPost('name');
        $key = str_replace(" ", "_", $name);
        $data = [
            'id' => $id,
            'name' => $name,
            'key' => $key,
            'description' => $this->request->getPost('description'),
        ];
        $model->save($data);
        return redirect()->to('admin/roles');
    }

    public function delete($id)
    {
        $model = new RoleModel();
        $model->delete($id);
        return redirect()->to('admin/roles');
    }

    public function storeAccessMatrix()
    {
        $roleId = $this->request->getPost('roleIdForMatrix');
        $postParams = $this->request->getPost('access');
        $modules = $this->customConfig->module_list_array;
        $modules2 = [];
        foreach($modules as $module) {
            $singleModule = ['module'=>$module['module']];
            foreach($module as $keyMod => $valMod) {
                if(isset($postParams[$module['module']][$keyMod])) {
                    $singleModule[$keyMod] = $postParams[$module['module']][$keyMod] == 'on' ? 1 : $postParams[$module['module']][$keyMod];
                } else {
                    $singleModule[$keyMod] = 0;
                }
            }
            $modules2[] = $singleModule;
        }
        $accessMatrix = ['access'=>json_encode($modules2), 'updatedBy' => $this->user_id, 'updatedDtm' => date('Y-m-d H:i:s')];
        $accessMatrixModel = new AccessMatrixModel();
        $updated = $accessMatrixModel->updateAccessMatrix($roleId, $accessMatrix);
        if($updated){
            $this->session->setFlashdata('success', 'Access matrix updated successfully');
        } else {
            $this->session->setFlashdata('error', 'Access matrix update failed');
        }

        return redirect()->to("admin/roles/edit/".$roleId);
    }
}
