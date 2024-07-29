<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Dashboard
        </h3>
    </div>
    <div class="row grid-margin">
        <div class="col-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="statistics-item">
                            <p>
                                <i class="icon-sm fa fa-user mr-2"></i>
                                My Tasks
                            </p>
                            <h2><?= $task_count; ?></h2>
                        </div>
                        <div class="statistics-item">
                            <p>
                                <i class="icon-sm fas fa-check-circle mr-2"></i>
                                Pending
                            </p>
                            <h2>7500</h2>
                            <label class="badge badge-outline-success badge-pill">57% increase</label>
                        </div>
                        <div class="statistics-item">
                            <p>
                                <i class="icon-sm fas fa-chart-line mr-2"></i>
                                Sales
                            </p>
                            <h2>9000</h2>
                            <label class="badge badge-outline-success badge-pill">10% increase</label>
                        </div>
                        <div class="statistics-item">
                            <p>
                                <i class="icon-sm fas fa-circle-notch mr-2"></i>
                                Pending
                            </p>
                            <h2>7500</h2>
                            <label class="badge badge-outline-danger badge-pill">16% decrease</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="fas fa-table"></i>
                        Tasks
                    </h4>
                    <div class="table-responsive">
                        <table id="order-listing cursor-pointer" class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
                                <th>Responsible Persons</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tasks as $task): ?>
                                <tr style="cursor: pointer;">
                                    <td>
                                        <?= $task['task_name'] ?>
                                        <input type="hidden" id="task_title_<?= $task['task_id'] ?>" value="<?= $task['task_name'] ?>">
                                    </td>
                                    <td>
                                        <?= $task['category_name'] ?>
                                    </td>
                                    <td>
                                        <?php foreach ($task['responsible_persons'] as $responsible_person): ?>
                                            <span class="font-weight-bold btn btn-info my-1">
                                            <?= $responsible_person['name'] ?>
                                        </span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td><?= $task['start_date'] ?></td>
                                    <td><?= $task['due_date'] ?></td>
                                    <td><?php
                                        switch ($task['priority']) {
                                            case "Low":
                                                $priority = "badge-success";
                                                break;

                                            case "Medium":
                                                $priority = "badge-warning";
                                                break;

                                            case "High":
                                                $priority = "badge-danger";
                                                break;
                                        }
                                        ?>
                                        <label class="badge <?= $priority ?> badge-pill"><?= $task['priority'] ?></label>
                                    </td>
                                    <td><?php
                                        $disabled = false;
                                        switch ($task['status']) {
                                            case "Active":
                                                $status = "badge-success";
                                                break;

                                            case "Completed":
                                                $status = "badge-primary";
                                                $disabled = true;
                                                break;

                                            case "High":
                                                $status = "badge-danger";
                                                break;
                                        }
                                        ?>
                                        <label class="badge <?= $status ?> badge-pill"><?= $task['status'] ?></label>
                                        <input type="hidden" id="task_status_<?= $task['task_id'] ?>" value="<?= $task['status'] ?>">
                                    </td>
                                    <td>
                                        <?php if($disabled): ?>
                                            <a href="javascript:void(0)" class="btn btn-light delete-btn" data-id="<?= $task['task_id']; ?>" <?= $disabled ?>>Update Task</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)" class="btn btn-primary delete-btn updateTaskBtn" data-id="<?= $task['task_id']; ?>" >Update Task</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="fas fa-calendar-alt"></i>
                        Calendar
                    </h4>
                    <div id="inline-datepicker-example" class="datepicker"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update_task_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Update Task 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="modalStatus" name="modalStatus" required>
                            <option value="Active">Active</option>
                            <option value="Completed">Completed</option>
                            <option value="On Hold">On Hold</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">File:</label>
                        <input type="file" class="form-control" id="task_file" name="task_file">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
                <div class="profile-feed">
                    <div class="d-flex align-items-start profile-feed-item">
                        <img src="<?= base_url() ?>vendors/images/faces/face13.jpg" alt="profile"
                             class="img-sm rounded-circle"/>
                        <div class="ml-4">
                            <h6>
                                Mason Beck
                                <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                            </h6>
                            <p>
                                There is no better advertisement campaign that is low cost and also successful at the
                                same time.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start profile-feed-item">
                        <img src="<?= base_url() ?>vendors/images/faces/face16.jpg" alt="profile"
                             class="img-sm rounded-circle"/>
                        <div class="ml-4">
                            <h6>
                                Willie Stanley
                                <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                            </h6>
                            <img src="<?= base_url() ?>vendors/images/samples/1280x768/12.jpg" alt="sample" class="rounded mw-100"/>
                        </div>
                    </div>
                    <div class="d-flex align-items-start profile-feed-item">
                        <img src="<?= base_url() ?>vendors/images/faces/face19.html" alt="profile"
                             class="img-sm rounded-circle"/>
                        <div class="ml-4">
                            <h6>
                                Dylan Silva
                                <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                            </h6>
                            <p>
                                When I first got into the online advertising business, I was looking for the magical
                                combination
                                that would put my website into the top search engine rankings
                            </p>
                            <img src="<?= base_url() ?>vendors/images/samples/1280x768/5.jpg" alt="sample" class="rounded mw-100"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Send message</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".updateTaskBtn").on("click", function (e){
           const task_id = $(this).attr("data-id");
           $("#ModalLabel").text($("#task_title_"+task_id).val());
           $("#modalStatus").val($("#task_status_"+task_id).val());
            $('#update_task_modal').modal('show');
        });
    });
</script>
<?= $this->endSection() ?>
