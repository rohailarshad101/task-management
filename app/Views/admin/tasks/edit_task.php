<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<?php
$middle_url = session()->get('middle_url');
?>
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
                                <?php foreach ($task_statuses_array as $key => $val): ?>
                                    <option value="<?= $key ?>" <?= $task['status'] == $key ? 'selected' : '' ?>><?= $val ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Re Assign</label>
                            <select class="form-control" id="repetition_frequency" name="repetition_frequency" required>
                                <?php foreach ($task_repetition_frequency_array as $key => $val): ?>
                                    <option value="<?= $key ?>" <?= $task['repetition_frequency'] == $key ? 'selected' : '' ?>><?= $val ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>File upload</label>
                            <input type="hidden" id="task_files" name="task_files" class="file-upload-default" value="">
                            <div class="col-xs-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Jquery file upload</h4>
                                        <div class="file-upload-wrapper">
                                            <div id="fileuploader">Upload</div>
                                            <div id="existing_files"></div>
                                        </div>
                                    </div>
                                </div>
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
<script>
    $(function()
    {
        'use strict';
        // $('.file-upload-default').on('change', function() {
        //     $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        // });
        let task_files = [];
        getTaskRelatedFiles(task_files, <?= $task['id'] ?>)

        if ($("#fileuploader").length) {
            $("#fileuploader").uploadFile({url: "/admin/tasks/upload-file",
                dragDrop: true,
                fileName: "taskFile",
                returnType: "json",
                showDelete: true,
                showDownload:false,
                statusBarWidth:600,
                dragdropWidth:600,
                onSuccess:function(files,data,xhr,pd)
                {
                    task_files.push(data.data.id)
                    $("#task_files").val(task_files);
                },
                deleteCallback: function (response, pd) {
                    if(response.status == 'success'){
                        let file_id = response.data['id'];
                        $.post("/admin/tasks/delete-file",
                            {
                                file_id: response.data['id']
                            },
                            function (resp, textStatus, jqXHR) {
                                if(resp.status == 'success')
                                {
                                    task_files = jQuery.grep(task_files, function(value) {
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

            // Handle file deletion
            $(document).on('click', '.delete_file', function() {
                var fileId = $(this).data('id');
                $.post("/admin/tasks/delete-file", { file_id: fileId }, function(resp) {
                    if(resp.status === 'success') {
                        task_files = jQuery.grep(task_files, function(value) {
                            return value !== fileId;
                        });
                        $("#task_files").val(task_files);
                        $(this).parent().remove(); // Remove file from display

                        $.toast({
                            heading: 'Danger',
                            text: resp.message,
                            showHideTransition: 'slide',
                            icon: 'warning',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                    }
                }.bind(this));
            });
        }
    });


    function getTaskRelatedFiles(task_files, task_id) {
        $.ajax({
            url: '/<?= $middle_url; ?>/tasks/task-related-files/'+task_id,
            type: 'GET',
            success: function(response) {
                var files = response.data;
                task_files = files.map(file => file.id); // Update task_files with existing file IDs
                // Display existing files
                files.forEach(file => {
                    $('#existing_files').append(`
                        <div class="file-item">
                            <a href="/download/${file.file_name}" class="download" target="_blank">${file.file_name}</a>
                            <button class="btn btn-danger delete_file" data-id="${file.id}" type="button">Delete</button>
                        </div>
                    `);
                });
            }
        });
    }

</script>
<?= $this->endSection() ?>
