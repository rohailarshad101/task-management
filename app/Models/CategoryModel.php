<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];

    protected $useSoftDeletes = true; // Enable soft deletes
    protected $deletedField = 'deleted_at'; // Name of the deleted_at field

    public function getAllCategories()
    {
        return $this->findAll();
    }
}
