<?php

namespace App\Commands;

use App\Libraries\Notification;
use App\Models\NotificationModel;
use App\Models\TaskFileModel;
use App\Models\TaskUserModel;
use App\Models\UserModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\TaskModel;
use DateTime;

class ReassignTasks extends BaseCommand
{
    protected $group       = 'Tasks';
    protected $name        = 'tasks:reassign';
    protected $description = 'Reassign tasks to the users already assigned to them.';

    public function run(array $params)
    {
        $taskModel = new TaskModel();
        $notification = new Notification();

        // Get all completed tasks
        $completedTasks = $taskModel->where('status', 'completed')->findAll();

        foreach ($completedTasks as $task) {
            if($task['is_recurring']) {
                $task_users = $taskModel->taskUsersArr($taskModel->getTasksRelatedUsers($task['id']));
                foreach ($task_users as $user) {
                    $nextDate = $this->calculateNextDate($task['completed_at'], $task['repetition_frequency']);
                    if($this->shouldReassign($nextDate)) {
                        $this->createNewTask($task);
                        // Send notification
                        $message = "Task '{$task['title']}' has been reassigned to you and is due on {$nextDate}.";
                        $notification->send($user['id'], $message);
                        // Send email
                        $this->sendEmail($user['id'], $task['title'], $nextDate);
                        CLI::write("Task ID {$task['id']} has been reassigned to {$nextDate}.", 'green');
                    }
                }
            }
        }

        CLI::write('Tasks reassigned successfully!', 'green');
    }

    private function calculateNextDate($completedAt, $frequency)
    {
        $date = new DateTime($completedAt);

        switch ($frequency) {
            case 'daily':
                $date->modify('+1 day');
                break;
            case 'weekly':
                $date->modify('+1 week');
                break;
            case 'bi-weekly':
                $date->modify('+2 weeks');
                break;
            case 'monthly':
                $date->modify('+1 month');
                break;
        }

        return $date->format('Y-m-d');
    }

    private function shouldReassign($nextDate)
    {
        $currentDate = new DateTime();
        return $currentDate >= new DateTime($nextDate);
    }

    public function createNewTask($old_task_arr)
    {

        $this->db->transException(true)->transStart();
        $task_model = new TaskModel();
        $responsible_persons = $old_task_arr['responsible_persons'];
        $task_files = $old_task_arr['task_files'];
        $due_date = $old_task_arr['due_date'];
        $data = [
            'title' => $old_task_arr['title'],
            'category_id' => $old_task_arr['category_id'],
            'start_date' => getDBFormattedDate($old_task_arr['start_date']),
            'due_date' => getDBFormattedDate($due_date),
            'tags' => $old_task_arr['tags'],
            'priority' => $old_task_arr['priority'],
            'status' => "Pending",
            'repetition_frequency' => $old_task_arr['repetition_frequency'],
            'description' => $old_task_arr['description'],
            'is_recurring' => $old_task_arr['is_recurring'],
        ];

        $task_model->save($data);
        $task_id = $task_model->getInsertID();
        foreach ($responsible_persons as $responsible_person) {
            $task_user = new TaskUserModel;
            $task_user->save([
                "user_id" => $responsible_person['id'],
                "task_id" => $task_id
            ]);
            $message = "Task '{$data['title']}' has been reassigned to you and is due on {$due_date}.";
            $this->insertNotitifcation($responsible_person['id'], $message);
        }

        foreach ($task_files as $task_file) {
            $taskFileModel = new TaskFileModel();
            $taskFileModel->save([
                "task_id" => $task_id,
                "user_id" => $task_file['user_id'],
                "file_name" => $task_file['file_name'],
                "file_path" => $task_file['file_path'],
                "file_type" => $task_file['file_type'],
                "file_size" => $task_file['file_size'],
            ]);
        }

        $this->db->transComplete();
    }

    private function sendEmail($userId, $taskTitle, $dueDate)
    {
        // Load the user model to get the email address
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if ($user) {
            $email = \Config\Services::email();

            $email->setTo($user['email']);
            $email->setSubject('Task Reassigned');
            $email->setMessage("Dear {$user['first_name']},<br><br>
                The task '{$taskTitle}' has been reassigned to you. The new due date is {$dueDate}.<br><br>
                Best regards,<br>Your Team");

            if ($email->send()) {
                CLI::write("Email sent to {$user['email']} for task reassignment.", 'green');
            } else {
                CLI::write("Failed to send email to {$user['email']}.", 'red');
            }
        }
    }

    private function insertNotitifcation($user_id, $message) {
        $notification_model = new NotificationModel();
        $notification_model->save([
            'user_id' => $user_id,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
