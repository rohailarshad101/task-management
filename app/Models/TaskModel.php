<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'category_id', 'responsible_persons', 'start_date', 'responsible_person', 'due_date', 'tags', 'priority', 'status', 'description'
    ];

    protected $useSoftDeletes = true; // Enable soft deletes
    protected $deletedField = 'deleted_at'; // Name of the deleted_at field

    public function getAllTasks($where = [])
    {
        $tasks_obj =  $this->select('tasks.*');
        if(!empty($where)){
            $tasks_obj->where($where);
        }
        return $tasks_obj->findAll();
    }

    public function getTaskCategory($task_id)
    {
        $category =  $this->select('categories.name as category_name')
            ->join('categories', 'categories.id = tasks.category_id', 'inner')
            ->where("tasks.id", $task_id)
            ->first();
        return $category['category_name'];
    }

    public function getTasksRelatedUsers($task_id)
    {
        $task_users = $this->select('users.*')
            ->join('tasks_users', 'tasks_users.task_id = tasks.id', 'inner')
            ->join('users', 'users.id = tasks_users.user_id', 'inner')
            ->where("tasks.id", $task_id)
            ->findAll();
        return $task_users;
    }

    public function getUserRelatedTasks($user_id)
    {
        $task_users = $this->select('tasks.*')
            ->join('tasks_users', 'tasks_users.task_id = tasks.id', 'inner')
            ->where("tasks_users.user_id", $user_id)
            ->findAll();
        return $task_users;
    }

    public function taskUsersArr($task_users)
    {
        $data = [];
        foreach ($task_users as $task_user)
        {
            $data[] = [
                "id" => $task_user['id'],
                "name" => $task_user['first_name'].' '.$task_user['last_name'],
            ];
        }
        return $data;
    }

}
