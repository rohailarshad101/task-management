<?php

namespace App\Controllers\User;

use App\Controllers\ApiResponse;
use App\Models\CategoryModel;
use App\Models\TaskCommentAttachmentModel;
use App\Models\TaskCommentModel;
use App\Models\TaskModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use Config\CustomConfig;

class UserTaskController extends Controller
{
    protected $customConfig = '';

    public function __construct()
    {
        $this->customConfig = config('CustomConfig');
    }

    public function index()
    {
        $data['task_statuses_array'] = $this->customConfig->task_statuses_array_for_user;
        $user_id = session()->get('user_id');
        $user_related_tasks = new TaskModel();
        $data['tasks'] = $user_related_tasks->getUserRelatedTasks($user_id);
        // Get the generated SQL query
        return view('user/tasks/task_list', $data);
    }

    public function create()
    {
        $data['task_statuses_array'] = $this->customConfig->task_statuses_array_for_user;
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        return view('user/tasks/create_task', $data);
    }

    public function store()
    {
        $model = new TaskModel();

        $data = [
            'title' => $this->request->getPost('title'),
            'category_id' => $this->request->getPost('category_id'),
            'responsible_persons' => $this->request->getPost('responsible_persons'),
            'start_date' => $this->request->getPost('start_date'),
            'due_date' => $this->request->getPost('due_date'),
//            'tags' => implode(',', $this->request->getPost('tags')),
            'tags' => $this->request->getPost('tags'),
            'priority' => $this->request->getPost('priority'),
            'status' => $this->request->getPost('status'),
            'description' => $this->request->getPost('description')
        ];

        $model->save($data);

        return redirect()->to('/user/tasks');
    }

    public function edit($id)
    {
        $data['task_statuses_array'] = $this->customConfig->task_statuses_array_for_user;
        $taskModel = new TaskModel();
        $categoryModel = new CategoryModel();

        $data['task'] = $taskModel->find($id);
        $data['categories'] = $categoryModel->findAll();

        return view('user/tasks/edit_task', $data);
    }

    public function getTaskDetails()
    {
        // Check if it's an AJAX request
        if ($this->request->isAJAX()) {
            $task_id = $this->request->getPost('task_id');

            // Load models
            $taskModel = new TaskModel();

            $commentModel = new TaskCommentModel();

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

    public function updateTaskComment($id)
    {
        $post = $this->request->getPost();
        $user_id = session()->get('user_id');
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

        $response = \Config\Services::response();
        return ApiResponse::success("Task Status added", $data,200, $response);
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
}
