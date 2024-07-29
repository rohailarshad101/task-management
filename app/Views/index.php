<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            New Task
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/tasks">Tasks</a></li>
                <li class="breadcrumb-item active" aria-current="page">New Task</li>
            </ol>
        </nav>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">New Task</h4>
                    <p class="card-description">
                        Basic form layout
                    </p>
                    <form action="/tasks/store" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Choose</option>
<!--                                            --><?php //foreach ($categories as $category): ?>
<!--                                                <option value="--><?php //= $category['id'] ?><!--">--><?php //= $category['name'] ?><!--</option>-->
<!--                                            --><?php //endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="responsible_persons">Responsible Persons</label>
                            <label for="category">Category</label>
                            <select class="form-control" id="responsible_persons" name="responsible_persons" required>
                                <option value="">Choose</option>
<!--                                            --><?php //foreach ($users as $user): ?>
<!--                                                <option value="--><?php //= $user['id'] ?><!--">--><?php //= $user['first_name'].''.$user['last_name'] ?><!--</option>-->
<!--                                            --><?php //endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
<!--                                        <input type="date" class="form-control" id="start_date" name="start_date" required>-->
                            <div id="datepicker-start_date" class="input-group date datepicker">
                                <input type="text" class="form-control" name="start_date" required>
                                    <span class="input-group-addon input-group-append border-left">
                                  <span class="far fa-calendar input-group-text"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <div id="datepicker-due_date" class="input-group date datepicker">
                                <input type="text" class="form-control" name="due_date" required>
                                <span class="input-group-addon input-group-append border-left">
                                  <span class="far fa-calendar input-group-text"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags" required>
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" name="priority" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Completed">Completed</option>
                                <option value="On Hold">On Hold</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
<?= $this->endSection() ?>
