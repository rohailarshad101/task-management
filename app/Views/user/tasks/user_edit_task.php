<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Edit Task
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/tasks">Tasks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Task</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="admin/tasks/update/<?= $task['id'] ?>" method="post">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="<?= $task['title'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $task['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                        <?= $category['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="responsible_person">Responsible Persons</label>
                            <input type="text" class="form-control" id="responsible_persons" name="responsible_persons"
                                   value="<?= $task['responsible_persons'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                   value="<?= $task['start_date'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date"
                                   value="<?= $task['due_date'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags" value="<?= $task['tags'] ?>"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" name="priority" required>
                                <option value="low" <?= $task['priority'] == 'low' ? 'selected' : '' ?>>Low</option>
                                <option value="medium" <?= $task['priority'] == 'medium' ? 'selected' : '' ?>>Medium
                                </option>
                                <option value="high" <?= $task['priority'] == 'high' ? 'selected' : '' ?>>High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active" <?= $task['status'] == 'Active' ? 'selected' : '' ?>>Active
                                </option>
                                <option value="completed" <?= $task['status'] == 'Completed' ? 'selected' : '' ?>>
                                    Completed
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required><?= $task['description'] ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
