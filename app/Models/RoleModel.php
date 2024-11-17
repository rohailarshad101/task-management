<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'key'];

    protected $returnType = 'array';


    protected $customConfig = '';

    public function __construct()
    {
        parent::__construct();
        $this->customConfig = config('CustomConfig');
    }

    public static function getTableName()
    {
        return (new RoleModel())->getTable();
    }

    public function users()
    {
        return $this->hasMany(UserModel::class, 'role_id', 'id');
    }

    public function getRoleAccessMatrix($roleId)
    {
        $result = $this->getRoleAccessMatrixQuery($roleId);
        if (is_null($result)) {
            $modules = $this->customConfig->module_list_array;
            $accessMatrix = array('roleId' => $roleId, 'access' => json_encode($modules), 'createdBy' => 1, 'createdDtm' => date('Y-m-d H:i:s'));
            $this->insertAccessMatrix($accessMatrix);
            $result = $this->getRoleAccessMatrixQuery($roleId);
        }
        return $result;
    }

    private function getRoleAccessMatrixQuery($roleId)
    {
        $accessMatrixModel = new AccessMatrixModel();
        // Query to get role access matrix
        return $accessMatrixModel
            ->select('roleId, access')
            ->where('roleId', $roleId)
            ->first(); // Returns the first matching row as an array or object
    }

    public function insertAccessMatrix($accessMatrix)
    {
        $accessMatrixModel = new AccessMatrixModel();
        $db = \Config\Database::connect();
        $db->transStart();
        $accessMatrixModel->insert($accessMatrix);
        $db->transComplete();
//        $query = $db->getLastQuery();
        if ($db->transStatus() === false) {
            // Handle error (e.g., log, throw exception, etc.)
            throw new \Exception('Failed to insert access matrix data.');
        }
    }

}

