<?php
namespace App\Models;

use CodeIgniter\Model;

class TaskCommentAttachmentModel extends Model
{
    protected $table = 'task_comment_attachments';

    protected $primaryKey = 'id';

    protected $allowedFields = ['task_comment_id', 'file_path'];
}
