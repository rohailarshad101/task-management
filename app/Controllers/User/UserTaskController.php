<?php

namespace App\Controllers\User;

use App\Models\CategoryModel;
use App\Models\TaskModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class UserTaskController extends Controller
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $user_related_tasks = new TaskModel();
        $data['tasks'] = $user_related_tasks->getUserRelatedTasks($user_id);
        // Get the generated SQL query
        return view('user/tasks/task_list', $data);
    }

    public function create()
    {
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
        $taskModel = new TaskModel();
        $categoryModel = new CategoryModel();

        $data['task'] = $taskModel->find($id);
        $data['categories'] = $categoryModel->findAll();

        return view('user/tasks/edit_task', $data);
    }

    public function update($id)
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

        $model->update($id, $data);

        return redirect()->to('/user/tasks');
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
