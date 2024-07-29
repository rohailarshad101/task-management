<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'key'];

    protected $returnType = 'array';


    public static function getTableName()
    {
        return (new RoleModel())->getTable();
    }

    public function users()
    {
        return $this->hasMany(UserModel::class, 'role_id', 'id');
    }
}
