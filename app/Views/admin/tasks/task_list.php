<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Tasks List
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/tasks">Tasks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tasks List</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3></h3>
                        </div>
                        <div>
                            <a href="tasks/create" class="btn btn-primary">New Task</a>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="order-listing"  class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Responsible Persons</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td class="font-weight-bold"><?= $task['task_name'] ?></td>
                                <td class="font-weight-bold"><?= $task['category_name'] ?></td>
                                <td>
                                <?php foreach ($task['responsible_persons'] as $responsible_person): ?>
                                    <span class="font-weight-bold btn btn-info">
                                        <?= $responsible_person['name'] ?>
                                    </span>
                                <?php endforeach; ?>
                                </td>
                                <td><?= $task['start_date'] ?></td>
                                <td><?= $task['due_date'] ?></td>
                                <td><?php
                                    switch ($task['priority'])
                                    {
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
                                    switch ($task['status'])
                                    {
                                        case "Active":
                                            $status = "badge-success";
                                            break;

                                        case "Completed":
                                            $status = "badge-primary";
                                            break;

                                        case "High":
                                            $status = "badge-danger";
                                            break;
                                    }
                                    ?>
                                    <label class="badge <?= $status ?> badge-pill"><?= $task['status'] ?></label></td>
                                <td>
                                    <a href="/admin/tasks/edit/<?= $task['task_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <!--                    <a href="/tasks/delete/--><?php //= $task['id'] ?><!--" class="btn btn-danger btn-sm">Delete</a>-->
                                    <a href="javascript:void(0)" onclick="showSwal(<?= $task['task_id']; ?>)" class="btn btn-danger delete-btn" data-id="<?= $task['task_id']; ?>">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(function () {
        showSwal = function(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                closeOnEsc: false,
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: false,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                    confirm: {
                        text: "OK",
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: true
                    }
                }
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/admin/tasks/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Include CSRF token if necessary
                            'Authorization': 'Bearer <your_token>' // Include authorization token if necessary
                        },
                        success: function(response) {
                            var message = response.success ? response.success : response.error;
                            $.toast({
                                heading: 'Success',
                                text: message,
                                showHideTransition: 'slide',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-right'
                            })
                            setTimeout(function() {
                                location.reload();
                            }, 2000); // Adjust the delay as needed
                        },
                        error: function(xhr, status, error) {
                            $.toast({
                                heading: 'Danger',
                                text: message,
                                showHideTransition: 'slide',
                                icon: 'error',
                                loaderBg: '#f2a654',
                                position: 'top-right'
                            })
                        }
                    });
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>
