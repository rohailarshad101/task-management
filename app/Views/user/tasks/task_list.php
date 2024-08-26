<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Tasks List
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin/tasks">Tasks</a></li>
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
                            <a href="admin/tasks/create" class="btn btn-primary">New Task</a>
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
                                    <th>Tags</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?= $task['title'] ?></td>
                                <td><?= $task['category_name'] ?></td>
                                <td><?= $task['responsible_persons'] ?></td>
                                <td><?= $task['start_date'] ?></td>
                                <td><?= $task['due_date'] ?></td>
                                <td><?= $task['tags'] ?></td>
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
                                    $status = "";
                                    switch ($task['status'])
                                    {
                                        case "Active":
                                            $status = "badge-success";
                                            break;

                                        case "Completed":
                                            $status = "badge-primary";
                                            break;

                                        case "Canceled":
                                            $status = "badge-danger";
                                            break;

                                        case "Closed":
                                            $status = "badge-dark";
                                            break;

                                        case "In Progress":
                                            $status = "badge-info";
                                            break;

                                        case "On Hold":
                                            $status = "badge-warning";
                                            break;

                                    }
                                    ?>
                                    <label class="badge <?= $status ?> badge-pill"><?= $task['status'] ?></label></td>
                                <td>
                                    <a href="admin/tasks/edit/<?= $task['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <!--                    <a href="/tasks/delete/--><?php //= $task['id'] ?><!--" class="btn btn-danger btn-sm">Delete</a>-->
                                    <a href="#" class="btn btn-danger delete-btn" data-id="<?= $task['id']; ?>">Delete</a>
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
        // Show confirmation modal on delete button click
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#deleteModal').modal('show');

            // Handle confirmation button click
            $('#confirmDelete').on('click', function() {
                $('#deleteModal').modal('hide');
                // AJAX call to delete task
                $.ajax({
                    url: 'admin/tasks/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        var message = response.success ? response.success : response.error;
                        showToast(message);
                    },
                    error: function(xhr, status, error) {
                        showToast('Error deleting task. Please try again.');
                    }
                });
            });
        });

        // Function to show toast notification
        function showToast(message) {
            var toastHTML = '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">' +
                '<div class="toast-header">' +
                '<strong class="me-auto">Notification</strong>' +
                '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
                '</div>' +
                '<div class="toast-body">' +
                message +
                '</div>' +
                '</div>';

            $('#toastContainer').append(toastHTML);
            var toast = $('.toast');
            toast.toast({ delay: 3000 }); // Auto close after 3 seconds
            toast.toast('show');
            toast.on('hidden.bs.toast', function () {
                $(this).remove();
            });
        }
    });
</script>
<?= $this->endSection() ?>
