<?php namespace App\Models;

use CodeIgniter\Model;

class TaskUserModel extends Model
{
    protected $table = 'tasks_users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'task_id'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
