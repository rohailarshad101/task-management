<?php

namespace App\Controllers\Admin;

use App\Controllers\ApiResponse;
use App\Models\CategoryModel;
use App\Models\TaskFileModel;
use App\Models\TaskModel;
use App\Models\TaskUserModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TaskController extends Controller
{
    protected $uploadPath = WRITEPATH . 'uploads/';

    protected $maxFileSize = 2048; // Max size in KB

    protected $allowedTypes = 'jpg,jpeg,png,gif';

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $model = new TaskModel();
        $tasks = $model->getAllTasks();
        $task_arr  = [];
        foreach ($tasks as $task)
        {
            $task_users = $model->taskUsersArr($model->getTasksRelatedUsers($task['id']));
            $task_arr[]=[
                "task_id" => $task['id'],
                "task_name" => $task['title'],
                "category_name" => $model->getTaskCategory($task['id']),
                "responsible_persons" => $task_users,
                "start_date" => getUserFormattedDate($task['start_date']),
                "due_date" => getUserFormattedDate($task['due_date']),
                "priority" => $task['priority'],
                "status" => $task['status'],
                "description" => $task['description'],
            ];
        }
        $data['tasks'] = $task_arr;
        return view('admin/tasks/task_list', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();
        $userModel = new UserModel();
        $data['users'] = $userModel->getAllUsersWithoutAdmin();
        return view('admin/tasks/create_task', $data);
    }

    public function store()
    {
        try {
            $this->db->transException(true)->transStart();
            $task_model = new TaskModel();
            $post = $this->request->getPost();
            $responsible_persons = $post['responsible_persons'];
            $task_files = explode(",", $post['task_files']);
            $data = [
                'title' => $this->request->getPost('title'),
                'category_id' => $this->request->getPost('category_id'),
                'start_date' => getDBFormattedDate($this->request->getPost('start_date')),
                'due_date' => getDBFormattedDate($this->request->getPost('due_date')),
                'tags' => $this->request->getPost('tags'),
                'priority' => $this->request->getPost('priority'),
                'status' => $this->request->getPost('status'),
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
            }

            foreach ($task_files as $task_file) {
                $taskFileModel = new TaskFileModel();
                $taskFileModel->where('id', $task_file)->set(['task_id' => $task_id])->update();
            }

            $this->db->transComplete();
        } catch (DatabaseException $e) {
            echo "<pre>";
            print_r($e->getMessage());
            die();
            // Automatically rolled back already.
        }


        return redirect()->to('/admin/tasks');
    }

    public function responsiblePersons($task_users)
    {
        $data = [];
        foreach ($task_users as $task_user)
        {
            $data[] = $task_user['id'];
        }
//        return implode(",", $data);
        return $data;
    }

    public function edit($id)
    {
        $taskModel = new TaskModel();
        $categoryModel = new CategoryModel();
        $userModel = new UserModel();
        $data['users'] = $userModel->getAllUsersWithoutAdmin();
        $data['task'] = $taskModel->find($id);
        $data['task']['responsible_persons'] = $this->responsiblePersons($taskModel->getTasksRelatedUsers($data['task']['id']));
        $data['categories'] = $categoryModel->findAll();
        return view('admin/tasks/edit_task', $data);
    }

    public function update($id)
    {
        try {
            $task_model = new TaskModel();
            $post = $this->request->getPost();
            $responsible_persons = $post['responsible_persons'];
            $data = [
                'title' => $this->request->getPost('title'),
                'category_id' => $this->request->getPost('category_id'),
                'start_date' => getDBFormattedDate($this->request->getPost('start_date')),
                'due_date' => getDBFormattedDate($this->request->getPost('due_date')),
                'tags' => $this->request->getPost('tags'),
                'priority' => $this->request->getPost('priority'),
                'status' => $this->request->getPost('status'),
                'description' => $this->request->getPost('description')
            ];

            $task_model->update($id, $data);
            $task_id = $id;
            $task_user = new TaskUserModel;
            $task_user->where("task_id", $task_id)->delete();
            foreach ($responsible_persons as $responsible_person){
                $task_user = new TaskUserModel();
                $task_user->insert([
                    "user_id" => $responsible_person,
                    "task_id" => $task_id
                ]);
            }
            $this->db->transComplete();
        } catch (DatabaseException $e) {
            echo "<pre>";
            print_r($e->getMessage());
            die();
            // Automatically rolled back already.
        }
        return redirect()->to('/admin/tasks');
    }

    public function delete($id = null)
    {
        $task = new TaskModel();
        // Check if ID is provided
        if ($id === null) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Task ID is required.']);
        }

        // Attempt to delete the task
        try {
            $task->delete($id);
            // Redirect to tasks list after successful deletion
            return $this->response->setJSON(['success' => 'Task deleted successfully.']);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to delete task.']);
        }
    }

    public function uploadTaskFile()
    {
        try {
            $task_file = $this->request->getFile('taskFile');
            if ($task_file->isValid() && !$task_file->hasMoved()) {
                $task_file_model = new TaskFileModel();
                // Define a new filename to avoid conflicts
                $original_file_name = pathinfo($task_file->getName(), PATHINFO_FILENAME);
                $new_file_name = $original_file_name.'-'.$task_file->getRandomName();

                // Move the file to the desired directory
                $filePath = WRITEPATH . 'uploads/task_related_documents/';
                $task_file->move($filePath, $new_file_name);

    //            // Save file details to the database
                $task_file_model->save([
                    'file_path' => $filePath,
                    'file_name' => $new_file_name,
                    'file_type' => $task_file->getClientMimeType()
                ]);
                // Get the ID of the last inserted record
                $lastInsertedId = $task_file_model->insertID();

                // Fetch the last inserted record
                $lastInsertedRecord = $task_file_model->find($lastInsertedId);
                $response = \Config\Services::response();
                return ApiResponse::success('Operation successful', $lastInsertedRecord,200, $response);
//                return $this->response->setJSON(['status' => 'success', 'message' => 'Task deleted successfully.', 'data' => $lastInsertedRecord]);
            }else{
                return $this->response->setStatusCode(422)->setJSON(['error' => 'Invalid file provided']);
            }
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to upload file.']);
        }
    }

    public function deleteTaskFile()
    {
        $file_id = $this->request->getPost('file_id');
        $task_file_model = new TaskFileModel();
        // Check if ID is provided
        if ($file_id === null) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'File ID is required.']);
        }

        // Attempt to delete the task
        try {
            $task_file_model->delete($file_id);
            $response = \Config\Services::response();
            return ApiResponse::success('File deleted successfully.', [],200, $response);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to delete File.']);
        }
    }
}
