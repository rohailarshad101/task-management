<?php

namespace App\Controllers\Admin;

use App\Controllers\ApiResponse;
use App\Models\DepartmentModel;
use App\Models\RoleModel;
use App\Models\TaskModel;
use App\Models\UserModel;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Controller;
use PhpParser\Node\Stmt\Switch_;

class UsersController extends Controller
{
    public function index()
    {
        $user_model = new UserModel();
        $data['users'] = $user_model->where("role_id !=", "1")->findAll();
        foreach ($data['users'] as $key => $user) {
            $data['users'][$key]['user_role'] = $user_model->role($user['id']);
            $data['users'][$key]['user_dept'] = $user_model->department($user['id']);
        }
        return view('admin/users/users_list', $data);
    }

    public function create()
    {
        $role_model = new RoleModel();
        $data['roles'] = $role_model->whereNotIn("key", ["super_admin"])->findAll();
        $dept_model = new DepartmentModel();
        $data['departments'] = $dept_model->where("deleted_at =", null)->findAll();
        return view('admin/users/create_user', $data);
    }

    public function store()
    {
        $model = new UserModel();
        $password = generateRandomPassword(14);
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'mobile' => $this->request->getPost('user_mobile'),
            'email' => $this->request->getPost('user_email'),
            'password' => $password,
            'role_id' => $this->request->getPost('role_id'),
            'dept_id' => $this->request->getPost('dept_id'),
            'is_active' => $this->request->getPost('user_active'),
        ];
        $model->save($data);
        $this->sendCredentialsEmail($data, "Account Created", $password);
        return redirect()->to('admin/users');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $data['user'] = $model->find($id);
        $role_model = new RoleModel();
        $data['roles'] = $role_model->whereNotIn("key", ["super_admin"])->findAll();
        $dept_model = new DepartmentModel();
        $data['departments'] = $dept_model->where("deleted_at =", null)->findAll();
        return view('admin/users/edit_user', $data);
    }

    public function update($id)
    {
        $model = new UserModel();
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'mobile' => $this->request->getPost('user_mobile'),
            'email' => $this->request->getPost('user_email'),
            'role_id' => $this->request->getPost('role_id'),
            'dept_id' => $this->request->getPost('dept_id'),
            'is_active' => $this->request->getPost('user_active'),
        ];
        $model->update($id, $data);

        return redirect()->to('admin/users');
    }

    public function delete($id)
    {
        // Check if ID is provided
        if ($id === null) {
            // Handle error, maybe redirect to tasks list
            return redirect()->to('admin/users');
        }
        $model = new UserModel();
        $model->delete($id);

        return redirect()->to('admin/users');
    }

    private function sendCredentialsEmail($user, $email_title, $password)
    {
        // Load the user model to get the email address
        $userModel = new UserModel();
        if ($user) {
            log_message("info", "inside if");
            $email = \Config\Services::email();

            $email->setTo($user['email']);
            $email->setSubject($email_title);
            $email->setMessage("Dear {$user['first_name']} {$user['last_name']},<br><br>
            Welcome to Task Management! 
            <br><br>
            We're excited to have you on board. Your account has been successfully created, and you can now access our services.
            <br><br>
            Here are your login details:
            <br><br>
            Email: {$user['email']}
            <br><br>
            Password: {$password}
            <br><br>
            If you have any questions or need assistance, please don't hesitate to reach out.
            <br><br>
            Best regards,
            <br><br>
            The Task Management Team");
            log_message('info', 'before');
            $session = session();
            if ($email->send()) {
                log_message('info', 'Email sent successfully to recipient@example.com');
                $session->setFlashdata('success', "An Email with email and password sent to {$user['email']}.");
            } else {
                log_message('error', 'Failed to send email. Debug info: ' . $user);
                $session->setFlashdata('error', "Failed to send email to {$user['email']}.");
            }
        }
    }

    public function activeInActive()
    {
        $user_model = new UserModel();
        $data = [
            'is_active' => $this->request->getPost('status'),
        ];
        $active_text = $this->request->getPost('user_active') == '1' ? 'activated' : 'deactivated';
        $user_model->update($this->request->getPost('user_id'), $data);
        $response = \Config\Services::response();
        return ApiResponse::success("User has been successfully $active_text", [],200, $response);
    }

    public function userView($id)
    {
        $user_model = new UserModel();
        $data['user'] = $user_model->where("id =", $id)->first();
        $data['user']['user_role'] = $user_model->role($id);
        $data['user']['user_dept'] = $user_model->department($id);
        $user_related_tasks = new TaskModel();
        $tasks = $user_related_tasks->getUserRelatedTasks($id);
        $pending_tasks = [];
        $in_progress_tasks = [];
        $on_hold_tasks = [];
        $completed_tasks = [];
        // Calculate total tasks
        $totalTasks = count($tasks);
        // Calculate percentage of tasks status-wise
        $statusCounts = array();
        foreach ($tasks as $task) {
            $status = $task['status'];
            if (!isset($statusCounts[$status])) {
                $statusCounts[$status] = 0;
            }
            $statusCounts[$status]++;
        }
        foreach ($statusCounts as $status => $count) {
            $color = "";
            $percentage = ($count / $totalTasks) * 100;
            switch ($status) {
                case "Completed":
                    $color = "#63CF72";
                    break;

                case "In Progress":
                    $color = "#76C1FA";
                    break;

                case "Pending":
                    $color = "#F36368";
                    break;

            }
            $statusCounts[$status] = [
                "count" => $count,
                "percentage" => $percentage,
                "color" => $color
            ];
        }

        ksort($statusCounts);
        $data['statusCounts'] = $statusCounts;
        $data['task_count'] = $totalTasks;
        return view('admin/users/user_view', $data);
    }

}
