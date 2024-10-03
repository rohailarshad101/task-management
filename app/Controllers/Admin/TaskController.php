<?php

namespace App\Controllers\Admin;

use App\Controllers\ApiResponse;
use App\Models\CategoryModel;
use App\Models\NotificationModel;
use App\Models\TaskCommentAttachmentModel;
use App\Models\TaskCommentModel;
use App\Models\TaskFileModel;
use App\Models\TaskModel;
use App\Models\TaskStatusLog;
use App\Models\TaskUserModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use Config\CustomConfig;

class TaskController extends Controller
{
    protected $user_id;
    protected $customConfig = '';

    protected $maxFileSize = 2048; // Max size in KB

    protected $allowedTypes = 'jpg,jpeg,png,gif';

    protected $db;

    public function __construct()
    {
        $this->user_id = session()->get('user_id');
        $this->db = \Config\Database::connect();
        $this->customConfig = config('CustomConfig');
        $config = new CustomConfig();
    }

    public function index()
    {
        $data['task_statuses_array'] = $this->customConfig->task_statuses_array;
        $data['task_repetition_frequency_array'] = $this->customConfig->task_repetition_frequency_array;
        $model = new TaskModel();
        $tasks = $model->getAllTasks();
        $task_arr  = [];
        foreach ($tasks as $task)
        {
            $task_users = $model->taskUsersArr($model->getTasksRelatedUsers($task['id']));
            $tasks_files = $model->getTasksRelatedFiles($task['id']);
            $task_arr[]=[
                "task_id" => $task['id'],
                "task_name" => $task['title'],
                "category_name" => $model->getTaskCategory($task['id']),
                "responsible_persons" => $task_users,
                "start_date" => getUserFormattedDate($task['start_date']),
                "due_date" => getUserFormattedDate($task['due_date']),
                "completed_at" => !empty($task['completed_at']) ? getUserFormattedDate($task['completed_at']) : "",
                "priority" => $task['priority'],
                "status" => $task['status'],
                "description" => $task['description'],
                "task_files_dir" => $this->customConfig->file_upload_path['tasks_file_path'],
                "tasks_related_files" => $tasks_files
            ];
        }
        $data['tasks'] = $task_arr;
        return view('admin/tasks/task_list', $data);
    }

    public function create()
    {
        $data['task_statuses_array'] = $this->customConfig->task_statuses_array;
        $data['task_repetition_frequency_array'] = $this->customConfig->task_repetition_frequency_array;
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
                'description' => $this->request->getPost('description'),
                'is_recurring' => $this->request->getPost('is_recurring')
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
        $data['task_statuses_array'] = $this->customConfig->task_statuses_array;
        $data['task_repetition_frequency_array'] = $this->customConfig->task_repetition_frequency_array;
        $taskModel = new TaskModel();
        $categoryModel = new CategoryModel();
        $userModel = new UserModel();
        $data['users'] = $userModel->getAllUsersWithoutAdmin();
        $data['task'] = $taskModel->find($id);
        $data['task']['responsible_persons'] = $this->responsiblePersons($taskModel->getTasksRelatedUsers($data['task']['id']));
        $data['categories'] = $categoryModel->findAll();
        return view('admin/tasks/edit_task', $data);
    }

    public function updateTask($id)
    {
        try {
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
                'repetition_frequency' => $this->request->getPost('repetition_frequency'),
                'description' => $this->request->getPost('description'),
                'is_recurring' => $this->request->getPost('is_recurring'),
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

    public function updateTaskComment($id)
    {
        $db = \Config\Database::connect();
        // Start the transaction
        $db->transStart();
        try {
            $data = [];
            $post = $this->request->getPost();
            $user_id = session()->get('user_id');
            $task_model = new TaskModel();
            $task_arr = $task_model->find($id);

            $task_comment = new TaskCommentModel();
            $data = [
                'task_id' => $post['task_id'],
                'user_id' => $user_id,
                'comment' => $post['task_comment']
            ];
            $task_comment->insert($data);
            // Get the ID of the last inserted record
            $task_comment_id = $task_comment->insertID();

            $task_update_files = $this->request->getFile('task_update_files');
            if ($task_update_files->isValid() && !$task_update_files->hasMoved()) {

                $task_comment_attachment_model = new TaskCommentAttachmentModel();
                // Define a new filename to avoid conflicts
                $original_file_name = pathinfo($task_update_files->getName(), PATHINFO_FILENAME);
                $new_file_name = $original_file_name.'-'.substr($task_update_files->getRandomName(),11);

                // Move the file to the desired directory
                $filePath = $this->customConfig->file_upload_path['tasks_file_path'];
                $task_update_files->move($filePath, $new_file_name);

                // Save file details to the database
                $task_comment_attachment_model->save([
                    'task_comment_id' => $task_comment_id,
                    'file_path' => $filePath.DIRECTORY_SEPARATOR.$new_file_name,
                    'file_size' => formatBytes($task_update_files->getSize())
                ]);
            }
            if($task_arr['status'] !== $post['task_status']){
                $task_status_log = "Task Status Changed From ".$task_arr['status']." to ".$post['task_status'];
            }else if($task_arr['status'] == $post['task_status'] && !empty($post['task_comment'])){
                $task_status_log = "Admin Commented against the task ".$post['task_comment'];
            }
            addTaskComment($task_comment_id, $task_status_log, $post['task_status']);

            $task_model->where("id", $post['task_id'])->set(["status" => $post['task_status']])->update();
            // Complete the transaction
            $db->transComplete();
            // Check the transaction status
            if ($db->transStatus() === false) {
                // If something went wrong, rollback
                $db->transRollback();
                return $this->response->setStatusCode(500)->setJSON(['error' => 'Error occurred while saving the task comment.']);
            }

            $response = \Config\Services::response();
            return ApiResponse::success("Task Status added", $data,200, $response);
        } catch (\Exception $e) {
            // Rollback manually if an exception occurs
            $db->transRollback();
            return 'Transaction failed: ' . $e->getMessage();
        }
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
                $new_file_name = $original_file_name.'-'.substr($task_file->getRandomName(),11);

                // Move the file to the desired directory
                $filePath = $this->customConfig->file_upload_path['tasks_file_path'];
                $task_file->move($filePath, $new_file_name);

    //            // Save file details to the database
                $task_file_model->save([
                    'user_id' => $this->user_id,
                    'file_path' => $filePath,
                    'file_name' => $new_file_name,
                    'file_type' => $task_file->getClientMimeType(),
                    'file_size' => formatBytes($task_file->getSize())
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

    public function getTaskDetails()
    {
        // Check if it's an AJAX request
        if ($this->request->isAJAX()) {
            $task_id = $this->request->getPost('task_id');

            // Load models
            $taskModel = new TaskModel();

            $commentModel = new TaskCommentModel();

            $taskStatusModal = new TaskStatusLog();

            // Fetch task details
            $task = $taskModel->find($task_id);
            // Fetch comments related to the task
            $comments = $commentModel->getCommentsByTask($task_id);

            $tasks_files = $taskModel->getTasksRelatedFiles($task_id);

            $user_model = new UserModel();
            $task_comment_attachment = new TaskCommentAttachmentModel();
            foreach ($comments as $index => $comment) {
                $comments[$index]['task_comment_attachments'] = $task_comment_attachment->where('task_comment_id', $comment['id'])->findAll();
                $comments[$index]['comment_user'] = $user_model->where('id', $comment['user_id'])->find()[0];
                $comment_related_logs = $taskStatusModal->where('task_comment_id', $comment['id'])->find();
                $comments[$index]['comment_related_logs'] = $comment_related_logs ? $comment_related_logs[0] : [];
                $comments[$index]['comment_time_diff'] = calculateTimeDiff($comment['created_at']);
            }
            // Prepare response data
            $data = [
                'task' => $task,
                'comments' => $comments,
                "tasks_related_files" => $tasks_files
            ];
            $response = \Config\Services::response();
            return ApiResponse::success('', $data,200, $response);
        }

        // If not an AJAX request, show 404 page
        return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setBody('Page not found');
    }

    public function addComment()
    {
        $commentModel = new TaskCommentModel();
        $attachmentModel = new TaskCommentAttachmentModel();

        $commentData = [
            'task_id' => $this->request->getPost('task_id'),
            'user_id' => $this->request->getPost('user_id'),
            'comment' => $this->request->getPost('comment')
        ];

        $commentId = $commentModel->insert($commentData);

        // Handle file upload
        $file = $this->request->getFile('attachment');
        if ($file->isValid() && !$file->hasMoved()) {
            $filePath = $file->store('uploads');
            $attachmentModel->insert([
                'comment_id' => $commentId,
                'file_path'  => $filePath
            ]);
        }

        return redirect()->to('/task/view/'.$this->request->getPost('task_id'));
    }

    public function insertNotitifcation($user_id, $message) {
        $notification_model = new NotificationModel();
        $notification_model->insert([
            'user_id' => $user_id,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getTaskRelatedFiles($task_id)
    {
        $task_file_model = new TaskFileModel();
        $tasks_files = $task_file_model->where("task_id", $task_id)->findAll();
        $response = \Config\Services::response();
        if(!empty($tasks_files)) {
            return ApiResponse::success('', $tasks_files,200, $response);
        }else{
            return ApiResponse::error('Task files not found', 400, $response);
        }
    }
}
