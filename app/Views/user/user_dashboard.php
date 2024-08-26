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
        <div class="col-md-9 grid-margin stretch-card">
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
                                <th>Responsible Persons</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
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
                                        <input type="hidden" id="task_title_<?= $task['task_id'] ?>"
                                               value="<?= $task['task_name'] ?>">
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
                                    <td>
                                        <?php
                                            $disabled = false;
                                            switch ($task['status'])
                                            {
                                                case "Active":
                                                    $status = "badge-success";
                                                    break;

                                                case "Completed":
                                                    $status = "badge-primary";
                                                    $disabled = true;
                                                    break;

                                                case "Canceled":
                                                    $status = "badge-danger";
                                                    break;

                                                case "Closed":
                                                    $status = "badge-dark";
                                                    $disabled = true;
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
                                        <?php if ($disabled): ?>
                                            <a href="javascript:void(0)" class="btn btn-light delete-btn"
                                               data-id="<?= $task['task_id']; ?>" <?= $disabled ?>>Update Task</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)"
                                               class="btn btn-primary delete-btn updateTaskBtn"
                                               data-id="<?= $task['task_id']; ?>">Update Task</a>
                                        <?php endif; ?>
                                        <div id="task_related_files<?= $task['task_id'] ?>" style="display: none"
                                             count="<?= count($task['tasks_related_files']) ?>">
                                            <ul>
                                                <?php foreach ($task['tasks_related_files'] as $file): ?>
                                                    <?php
                                                    switch ($file['file_type']) {
                                                        case "image/jpeg":
                                                            $fa_file_icon = "fa-file-image";
                                                            break;

                                                        case "Completed":
                                                            $fa_file_icon = "fa-file-pdf";
                                                            break;

                                                        default:
                                                            $fa_file_icon = "fa-file";
                                                            break;
                                                    }

                                                    ?>
                                                    <li class="mt-sm-1">
                                                        <div class="thumb"><i class="fa <?= $fa_file_icon ?>"></i></div>
                                                        <div class="details">
                                                            <p class="file-name"><?= $file['file_name'] ?></p>
                                                            <div class="buttons">
                                                                <p class="file-size"><?= $file['file_size'] ?></p>
                                                                <a href="/download/<?= $file['file_name'] ?>"
                                                                   class="download">Download</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
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

<div class="modal fade" id="update_task_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
     aria-hidden="true">
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
                <form action="/users/task/update/" method="post" id="task_update_form" class="forms-sample" enctype="multipart/form-data">
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
                            <img src="<?= base_url() ?>vendors/images/samples/1280x768/12.jpg" alt="sample"
                                 class="rounded mw-100"/>
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
                            <img src="<?= base_url() ?>vendors/images/samples/1280x768/5.jpg" alt="sample"
                                 class="rounded mw-100"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".updateTaskBtn").on("click", function (e) {
            const task_id = $(this).attr("data-id");
            $("#ModalLabel").text($("#task_title_" + task_id).val());
            $("#taskStatus").val($("#task_status_" + task_id).val());
            $("#task_id").val(task_id);
            if ($("#task_related_files" + task_id).attr("count") > 0) {
                $("#attachments").html($("#task_related_files" + task_id).html());
            } else {
                $("#attachments").html("<p>No Attachment found</p>");
            }

            $('#update_task_modal').modal('show');
        });
    });

    let task_files = [];
    if ($("#fileuploader").length) {
        $("#fileuploader").uploadFile({
            url: "/admin/tasks/upload-file",
            dragDrop: true,
            fileName: "taskFile",
            returnType: "json",
            showDelete: true,
            showDownload: false,
            statusBarWidth: 600,
            dragdropWidth: 600,
            onSuccess: function (files, data, xhr, pd) {
                task_files.push(data.data.id)
                $("#task_files").val(task_files);
            },
            deleteCallback: function (response, pd) {
                if (response.status == 'success') {
                    let file_id = response.data['id'];
                    $.post("/admin/tasks/delete-file",
                        {
                            file_id: response.data['id']
                        },
                        function (resp, textStatus, jqXHR) {
                            if (resp.status == 'success') {
                                task_files = jQuery.grep(task_files, function (value) {
                                    return value != file_id;
                                })
                                $("#task_files").val(task_files);
                                $.toast({
                                    heading: 'Danger',
                                    text: resp.message,
                                    showHideTransition: 'slide',
                                    icon: 'warning',
                                    loaderBg: '#f2a654',
                                    position: 'top-right'
                                })
                            }
                        }
                    );
                }
                // pd.statusbar.hide(); //You choice.
            },
        });
    }
    $(document).on('submit', '#task_update_form', function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: '/user/task/update/' + $("#task_id").val(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Include CSRF token if necessary
            },
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data : new FormData(this),
            success: function(response){
                console.log(response)
            }
        });
    });


        //     success: function(response) {
        //         var message = response.success ? response.success : response.error;
        //         $.toast({
        //             heading: 'Success',
        //             text: message,
        //             showHideTransition: 'slide',
        //             icon: 'success',
        //             loaderBg: '#f96868',
        //             position: 'top-right'
        //         })
        //         setTimeout(function() {
        //             location.reload();
        //         }, 2000); // Adjust the delay as needed
        //     },
        //     error: function(xhr, status, error) {
        //         $.toast({
        //             heading: 'Danger',
        //             text: message,
        //             showHideTransition: 'slide',
        //             icon: 'error',
        //             loaderBg: '#f2a654',
        //             position: 'top-right'
        //         })
        //     }

</script>
<?= $this->endSection() ?>
