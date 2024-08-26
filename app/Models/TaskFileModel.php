<?php
namespace App\Models;

use CodeIgniter\Model;

class TaskFileModel extends Model
{
    protected $table = 'tasks_files';

    protected $primaryKey = 'id';

    protected $allowedFields = ['task_id', 'user_id', 'file_path', 'file_name', 'file_type', 'file_size', 'uploaded_at'];

    protected $useSoftDeletes = true; // Enable soft deletes
    protected $deletedField = 'deleted_at'; // Name of the deleted_at field

}
