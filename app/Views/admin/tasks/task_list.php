<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<?php
$middle_url = session()->get('middle_url');

?>
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
                <form action="/<?= $middle_url; ?>/tasks/update/" method="post" id="task_update_form" class="forms-sample" enctype="multipart/form-data">
                    <input type="hidden" id="task_id" name="task_id" value="">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="taskStatus" name="taskStatus" value="" required>
                            <?php foreach ($task_statuses_array as $key => $val): ?>
                                <option value="<?= $key ?>"><?= $val ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="formFileMultiple" class="col-form-label">File:</label>
                        <input class="form-control" type="file" id="task_update_files" name="task_update_files" multiple>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="task_comment" name="task_comment" value=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="update_task_status" >Update Task</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </form>
                <div class="profile-feed" id="comments">
                </div>
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
                url: '/<?= $middle_url; ?>/tasks/detail',
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
                        response.data.comments.forEach(commentRow => {
                            let task_comment_attachments = commentRow.task_comment_attachments;
                            let comment_user = commentRow.comment_user;
                            console.log(comment_user.profile_picture);
                            let user_full_name = comment_user.first_name+' ' +comment_user.last_name;
                            let time_diff = calculateTimeDiff(commentRow.created_at);
                            commentsHtml += '<div class="d-flex align-items-start profile-feed-item">';
                            commentsHtml += '<img src="<?= base_url() ?>'+comment_user.profile_picture+'" alt="profile" class="img-sm rounded-circle"/>';
                            commentsHtml += '<div class="ml-4">';
                            commentsHtml += '<h6>'+user_full_name+'<small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>'+time_diff+'</small></h6>';
                            commentsHtml += '<p>'+commentRow.comment+'</p>';
                            $.each(task_comment_attachments, function(index, attachment) {
                                // Simplify the file path
                                attachment.file_path = attachment.file_path.replace(/\\\\/g, '\\');
                                commentsHtml += '<img src="<?= base_url() ?>'+attachment.file_path+'" alt="sample" class="rounded mw-100"/>';
                            });

                            commentsHtml += '</div>';
                            commentsHtml += '</div>';
                        });
                        $('#attachments').html(task_attachments_html);
                        $('#comments').html(commentsHtml);
                        $("#task_id").val(task_id);
                        $('#update_task_modal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        $(document).on('submit', '#task_update_form', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let form = $(this);
            let task_id = $("#task_id").val();
            $.ajax({
                type:'POST',
                url: '/<?= $middle_url; ?>/tasks/update/comment/' + task_id,
                dataType: 'json',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data : formData,
                success: function(response){
                    if(response.status == "success") {
                        $.toast({
                            heading: 'Success',
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'success',
                            loaderBg: '#04B76B',
                            position: 'top-right'
                        });
                        getTaskLatestComment(task_id)
                        form[0].reset();
                    } else if(response.status == "error") {
                        $.toast({
                            heading: 'Danger',
                            text: response.message,
                            showHideTransition: 'slide',
                            // icon: 'error,
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        })
                    }
                }
            });
        });

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
                        url: '/<?= $middle_url; ?>/tasks/' + id,
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

    function calculateTimeDiff(created_at) {
        // Convert the datetime string to a Date object
        let givenDate = new Date(created_at);

        // Get the current date and time
        let currentDate = new Date();

        // Calculate the difference in milliseconds
        let timeDifference = currentDate - givenDate;

        // Calculate the difference in days, hours, minutes, and seconds
        let daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        let hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutesDifference = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        let secondsDifference = Math.floor((timeDifference % (1000 * 60)) / 1000);

        // Determine the most appropriate time unit to return
        if (daysDifference > 0) {
            return `${daysDifference} day(s) ago`;
        } else if (hoursDifference > 0) {
            return `${hoursDifference} hour(s) ago`;
        } else if (minutesDifference > 0) {
            return `${minutesDifference} minute(s) ago`;
        } else {
            return `${secondsDifference} second(s) ago`;
        }
    }

    function getTaskLatestComment(task_id) {
        $.ajax({
            url: '/<?= $middle_url; ?>/tasks/detail',
            type: 'POST',
            data: { task_id: task_id },
            dataType: 'json',
            success: function(response) {
                if (response.status == "success") {
                    // Handle comments
                    let commentsHtml = '';
                    response.data.comments.forEach(commentRow => {
                        let task_comment_attachments = commentRow.task_comment_attachments;
                        let comment_user = commentRow.comment_user;
                        let user_full_name = comment_user.first_name+' ' +comment_user.last_name;
                        let time_diff = calculateTimeDiff(commentRow.created_at);
                        commentsHtml += '<div class="d-flex align-items-start profile-feed-item">';
                        commentsHtml += '<img src="<?= base_url() ?>vendors/images/faces/face19.html" alt="profile" class="img-sm rounded-circle"/>';
                        commentsHtml += '<div class="ml-4">';
                        commentsHtml += '<h6>'+user_full_name+'<small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>'+time_diff+'</small></h6>';
                        commentsHtml += '<p>'+commentRow.comment+'</p>';
                        $.each(task_comment_attachments, function(index, attachment) {
                            // Simplify the file path
                            attachment.file_path = attachment.file_path.replace(/\\\\/g, '\\');
                            commentsHtml += '<img src="<?= base_url() ?>'+attachment.file_path+'" alt="sample" class="rounded mw-100"/>';
                        });

                        commentsHtml += '</div>';
                        commentsHtml += '</div>';
                    });
                    $('#comments').html(commentsHtml);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
</script>
<?= $this->endSection() ?>
