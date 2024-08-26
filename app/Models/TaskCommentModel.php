<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskCommentModel extends Model
{
    protected $table = 'task_comments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['task_id', 'user_id', 'user_role', 'comment', 'created_at'];

    public function getCommentsByTask($taskId)
    {
        return $this->where('task_id', $taskId)->orderBy('created_at', 'ASC')->findAll();
    }

    public function getCommentRelatedUser($taskId)
    {
        return $this->select('users.*')
            ->join('users', 'users.id = task_comments.user_id', 'left')
            ->where('task_id', $taskId)->orderBy('created_at', 'ASC')->findAll();
    }
}
