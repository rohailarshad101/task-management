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
                                    <th>Completed At</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td class="font-weight-bold">
                                    <?= $task['task_name'] ?>
                                    <input type="hidden" id="task_title_<?= $task['task_id'] ?>" value="<?= $task['task_name'] ?>">
                                </td>
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
                                <td><?= $task['completed_at'] ?></td>
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
                                    $hide_edit_btn = false;
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
                                            $hide_edit_btn = true;
                                            break;

                                        case "In Progress":
                                            $status = "badge-info";
                                            break;

                                        case "On Hold":
                                            $status = "badge-warning";
                                            break;

                                    }
                                    ?>
                                    <label class="badge <?= $status ?> badge-pill"><?= $task['status'] ?></label>
                                    <input type="hidden" id="task_status_<?= $task['task_id'] ?>" value="<?= $task['status'] ?>">
                                </td>
                                <td>
                                    <?php if(!$hide_edit_btn){ ?>
                                        <a href="/admin/tasks/edit/<?= $task['task_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <?php }else{ ?>
                                        <a href="javascript:void(0)" class="btn btn-secondary btn-sm" disabled="">Edit</a>
                                    <?php } ?>
                <!--                    <a href="/tasks/delete/--><?php //= $task['id'] ?><!--" class="btn btn-danger btn-sm">Delete</a>-->
                                    <a href="javascript:void(0)" onclick="showSwal(<?= $task['task_id']; ?>)" class="btn btn-danger delete-btn" data-id="<?= $task['task_id']; ?>">Delete</a>
                                    <a href="javascript:void(0)" class="btn btn-info delete-btn updateTaskBtn" data-id="<?= $task['task_id']; ?>">
                                        <i class="fa fa-eye text-light-primary"></i> &nbsp;View
                                    </a>
<!--                                    <div id="task_related_files--><?php //= $task['task_id'] ?><!--" style="display: none" count="--><?php //= count($task['tasks_related_files']) ?><!--">-->
<!--                                        <ul>-->
<!--                                            --><?php //foreach ($task['tasks_related_files'] as $file): ?>
<!--                                                --><?php
//                                                switch ($file['file_type'])
//                                                {
//                                                    case "image/jpeg":
//                                                        $fa_file_icon = "fa-file-image";
//                                                        break;
//
//                                                    case "Completed":
//                                                        $fa_file_icon = "fa-file-pdf";
//                                                        break;
//
//                                                    default:
//                                                        $fa_file_icon = "fa-file";
//                                                        break;
//                                                }
//
//                                                ?>
<!--                                                <li class="mt-sm-1">-->
<!--                                                    <div class="thumb"><i class="fa --><?php //= $fa_file_icon ?><!--"></i></div>-->
<!--                                                    <div class="details">-->
<!--                                                        <p class="file-name">--><?php //= $file['file_name']  ?><!--</p>-->
<!--                                                        <div class="buttons">-->
<!--                                                            <p class="file-size">--><?php //= $file['file_size']  ?><!--</p>-->
<!--                                                            <a href="/download/--><?php //= $file['file_name']  ?><!--" class="download">Download</a>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </li>-->
<!--                                            --><?php //endforeach; ?>
<!--                                        </ul>-->
<!--                                    </div>-->
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
                <div class="email-wrapper wrapper">
                    <div class="message-body">
                        <h5>Attachments</h5>
                        <div class="attachments-sections" id="attachments">
                        </div>
                    </div>
                </div>
                <form>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="modalStatus" name="modalStatus" required>
                            <?php foreach ($task_statuses_array as $key => $val): ?>
                                <option value="<?= $key ?>"><?= $val ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
                <div class="profile-feed" id="comments">

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
        $(".updateTaskBtn").on("click", function (e)
        {
            const task_id = $(this).attr("data-id");
            $.ajax({
                url: '/admin/task/detail',
                type: 'POST',
                data: { task_id: task_id },
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Handle task details
                        $("#modalStatus").val($("#task_status_"+task_id).val());
                        $('#task-title').text(response.data.task.title);
                        $('#task-description').text(response.data.task.description);


                        let task_attachments_html = '';
                        let fa_file_icon = 'fa-file';
                        task_attachments_html += '<ul>';
                        response.data.tasks_related_files.forEach(file => {
                            switch (file.file_type) {
                                case "image/jpeg":
                                    fa_file_icon = "fa-file-image";
                                    break;

                                case "Completed":
                                    fa_file_icon = "fa-file-pdf";
                                    break;

                            }
                            task_attachments_html += '<li class="mt-sm-1">';
                            task_attachments_html += '<div class="thumb"><i class="fa '+fa_file_icon+'"></i></div>';
                            task_attachments_html += '<div class="details">';
                            task_attachments_html += '<p class="file-name">'+file.file_name+'</p>';
                            task_attachments_html += '<div class="buttons">';
                            task_attachments_html += '<p class="file-size">'+file.file_size+'</p>';
                            task_attachments_html += '<a href="/download/'+file.file_name+'" class="download">Download</a>';
                            task_attachments_html += '</div>';
                            task_attachments_html += '</div>';
                            task_attachments_html += '</li>';
                        });
                        task_attachments_html +='</ul>';
                        // Handle comments
                        let commentsHtml = '';
                        response.data.comments.forEach(comment => {
                            commentsHtml += '<div class="d-flex align-items-start profile-feed-item">';
                            commentsHtml += '<img src="<?= site_url() ?>'+comment.comment_user.profile_picture+'" alt="profile" class="img-sm rounded-circle"/>';
                            let comment_user = comment.comment_user;
                            let calculate_timeDiff = calculateTimeDiff(comment.created_at);
                            let time_diff = calculate_timeDiff.daysDifference;
                            if (time_diff < 1) {
                                time_diff = calculate_timeDiff.hoursDifference;
                            }
                                commentsHtml += '<div class="ml-4">';
                                    commentsHtml += '<h6>'+comment_user.first_name+' '+comment_user.last_name+' <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>'+time_diff+'</small></h6>';
                                    commentsHtml += '<p>'+comment.comment+'.</p>';
                                commentsHtml += '</div>';
                            commentsHtml += '</div>';
                        });
                        $('#attachments').html(task_attachments_html);
                        $('#comments').html(commentsHtml);
                        $('#update_task_modal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        function calculateTimeDiff(created_at) {
            let datetimeString = "2024-08-15 10:45:00";

            // Convert the datetime string to a Date object
            let givenDate = new Date(created_at);

            // Get the current date and time
            let currentDate = new Date();

            // Calculate the difference in milliseconds
            let timeDifference = currentDate - givenDate;

            // Convert the difference from milliseconds to days
            let daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

            // Convert the difference from milliseconds to hours
            let hoursDifference = Math.floor(timeDifference / (1000 * 60 * 60));

            return { "hoursDifference": hoursDifference+" hours ago", "daysDifference": daysDifference+" days ago", }
        }

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
