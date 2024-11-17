<?php

namespace App\Models;

use CodeIgniter\Model;

class AccessMatrixModel extends Model
{
    protected $table = 'tbl_access_matrix';
    protected $primaryKey = 'id';
    protected $allowedFields = ['access', 'roleId', 'isDeleted', 'createdBy', 'updatedDtm'];
    protected $useTimestamps = false;

    public function updateAccessMatrix($roleId, $accessMatrix)
    {
        $this->where('roleId', $roleId)->set($accessMatrix)->update();
        return $this->affectedRows();
    }
}
