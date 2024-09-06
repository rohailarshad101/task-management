<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Human Resources'],
            ['name' => 'IT Department'],
            ['name' => 'Marketing'],
        ];

        // Using Query Builder
        $this->db->table('departments')->insertBatch($data);
    }
}
