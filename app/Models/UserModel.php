<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['first_name', 'last_name', 'email', 'mobile', 'password', 'profile_picture', 'dept_id', 'role_id', 'is_active'];

    protected $beforeInsert = ['hashPassword'];

    protected $beforeUpdate = ['hashPassword'];

    protected $useSoftDeletes = true; // Enable soft deletes
    protected $deletedField = 'deleted_at'; // Name of the deleted_at field

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    public function active()
    {
        return $this->where('is_active', 1);
    }

    public function role($user_id)
    {
        return $this->join("roles", 'users.role_id=roles.id', 'left')->where("users.id", $user_id)->first();
    }
    
    public function getUserByUserEmail($user_email)
    {
        return $this->where('email', $user_email)->first();
    }

    public function getAllUsersWithoutAdmin()
    {
        return $this->whereNotIn("role_id", [1])->where("is_active = ", 1)->findAll();
    }

    public function getAllUsers()
    {
        return $this->findAll();
    }

    public function department($user_id)
    {
        return $this->join("departments", 'users.dept_id=departments.id', 'left')->where("users.id", $user_id)->first();
    }
}
