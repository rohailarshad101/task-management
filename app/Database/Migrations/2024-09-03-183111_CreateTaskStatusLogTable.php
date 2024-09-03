<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskStatusLogTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'task_comment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Active', 'In Progress', 'On Hold', 'Completed', 'Canceled', 'Closed'],
                'default' => 'Active',
            ],
            'comment' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('task_comment_id', 'task_comments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('task_status_log');
    }

    public function down()
    {
        $this->forge->dropTable('task_status_log');
    }
}
