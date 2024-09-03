<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskStatusLog extends Model
{
    protected $table = 'task_status_log';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'task_comment_id',
        'status',
        'comment',
        'created_at',
    ];

    protected $useTimestamps = false;
}
