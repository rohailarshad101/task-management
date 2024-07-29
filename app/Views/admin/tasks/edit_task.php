<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Edit Task
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/tasks">Tasks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Task</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="/admin/tasks/update/<?= $task['id'] ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= $task['title'] ?>" required>
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
<!--                            <input type="text" class="form-control" id="responsible_persons" name="responsible_persons[]" value="--><?php //= $task['responsible_persons'] ?><!--" required>-->
                            <select class="js-example-basic-multiple w-100" multiple="multiple" id="responsible_persons" name="responsible_persons[]" required>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id']?>" <?= in_array($user['id'], $task['responsible_persons']) ? 'selected' : '' ?>><?= $user['first_name'].''.$user['last_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label for="responsible_persons">Responsible Persons</label>-->
<!--                            <label for="category">Category</label>-->
<!--                            <select class="form-control" id="responsible_persons" name="responsible_persons" required>-->
<!--                                --><?php //foreach ($users as $user): ?>
<!--                                    <option value="--><?php //= $user['id'] ?><!--" --><?php //= $task['category_id'] == $user['id'] ? 'selected' : '' ?><!-- >--><?php //= $user['first_name'].''.$user['last_name'] ?><!--</option>-->
<!--                                --><?php //endforeach; ?>
<!--                            </select>-->
<!--                        </div>-->

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <div id="datepicker-start_date" class="input-group date datepicker">
                                <input type="text" id="start_date" name="start_date" class="form-control" value="<?= $task['start_date'] ?>" required>
                                <span class="input-group-addon input-group-append border-left">
                                  <span class="far fa-calendar input-group-text"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <!--                            <input type="date" class="form-control" id="due_date" name="due_date" required>-->
                            <div id="datepicker-due_date" class="input-group date datepicker">
                                <input type="text" id="due_date" name="due_date" class="form-control" value="<?= $task['due_date'] ?>" required>
                                <span class="input-group-addon input-group-append border-left">
                                  <span class="far fa-calendar input-group-text"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" name="priority" required>
                                <option value="Low" <?= $task['priority'] == 'Low' ? 'selected' : '' ?>>Low</option>
                                <option value="Medium" <?= $task['priority'] == 'Medium' ? 'selected' : '' ?>>Medium
                                </option>
                                <option value="High" <?= $task['priority'] == 'High' ? 'selected' : '' ?>>High</option>
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
                            <label>File upload</label>
                            <input type="file" id="task_files" name="task_files[]" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" multiple class="form-control file-upload-info" placeholder="Upload file" disabled>
                                <span class="input-group-append">
                                  <button class="file-upload-browse btn btn-primary" type="button" onclick='$("#task_files").trigger("click")'>Upload</button>
                                </span>
                            </div>
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
