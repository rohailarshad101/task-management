<?php

namespace App\Commands;

use App\Libraries\Notification;
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
            $task_users = $taskModel->taskUsersArr($taskModel->getTasksRelatedUsers($task['id']));
            foreach ($task_users as $user) {
//                CLI::write("User ID {$user['id']} ", 'green');
                $nextDate = $this->calculateNextDate($task['completed_at'], $task['repetition_frequency']);
                if($this->shouldReassign($nextDate)) {
                    $taskModel->update($task['id'], [
                        'due_date' => $nextDate,
                        'status' => "Pending"
                    ]);

                    // Send notification
                    $message = "Task '{$task['title']}' has been reassigned to you and is due on {$nextDate}.";
                    $notification->send($user['id'], $message);

                    // Send email
                    $this->sendEmail($user['id'], $task['title'], $nextDate);

                    CLI::write("Task ID {$task['id']} has been reassigned to {$nextDate}.", 'green');
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

    public function createNewTask($post)
    {
        $this->db->transException(true)->transStart();
        $task_model = new TaskModel();
        $responsible_persons = $post['responsible_persons'];
        $task_files = explode(",", $post['task_files']);
        $due_date = $this->request->getPost('due_date');
        $data = [
            'title' => $this->request->getPost('title'),
            'category_id' => $this->request->getPost('category_id'),
            'start_date' => getDBFormattedDate($this->request->getPost('start_date')),
            'due_date' => getDBFormattedDate($due_date),
            'tags' => $this->request->getPost('tags'),
            'priority' => $this->request->getPost('priority'),
            'status' => $this->request->getPost('status'),
            'repetition_frequency' => $this->request->getPost('repetition_frequency'),
            'description' => $this->request->getPost('description')
        ];

        $task_model->insert($data);
        $task_id = $task_model->getInsertID();
        foreach ($responsible_persons as $responsible_person) {
            $task_user = new TaskUserModel;
            $task_user->insert([
                "user_id" => $responsible_person,
                "task_id" => $task_id
            ]);
            $message = "Task '{$data['title']}' has been reassigned to you and is due on {$due_date}.";
            $this->insertNotitifcation($responsible_person, $message);
        }

        foreach ($task_files as $task_file) {
            $taskFileModel = new TaskFileModel();
            $taskFileModel->where('id', $task_file)->set(['task_id' => $task_id])->update();
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
}
