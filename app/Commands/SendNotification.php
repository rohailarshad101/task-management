<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\TaskModel;

class SendNotification extends BaseCommand
{
    protected $group       = 'Tasks';
    protected $name        = 'task:notify';
    protected $description = 'Send notification one hour before task submission date.';

    public function run(array $params)
    {
        $taskModel = new TaskModel();
        $tasks = $taskModel->where('due_date >', date('Y-m-d H:i:s', strtotime('+1 hour')))
            ->where('due_date <=', date('Y-m-d H:i:s'))
            ->findAll();

        foreach ($tasks as $task) {
            // Assuming you have a function to send notification
            $this->sendNotification($task);
        }

        CLI::write('Notifications sent successfully!', 'green');
    }

    private function sendNotification($task)
    {
        // Implement your notification logic here
        // Example: Send an email, push notification, etc.
        CLI::write("Sending notification for Task ID: {$task['id']}", 'yellow');
    }
}

//crontab -e
//0 * * * * /path/to/php /path/to/your/project/public/index.php task:notify
//php /path/to/your/project/public/index.php task:notify
