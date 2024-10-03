<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Create Task
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/tasks">Tasks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Task</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="/admin/tasks/store" method="post" class="forms-sample" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Choose</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="responsible_persons">Responsible Persons</label>
                            <label for="category">Category</label>
<!--                            <select class="form-control" id="responsible_persons" name="responsible_persons" required>-->
                            <select class="js-example-basic-multiple w-100" multiple="multiple" id="responsible_persons" name="responsible_persons[]" required>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>"><?= $user['first_name'].''.$user['last_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
<!--                            <input type="date" class="form-control" id="start_date" name="start_date" required>-->
                            <div id="datepicker-start_date" class="input-group date datepicker">
                                <input type="text" id="start_date" name="start_date" class="form-control" required>
                                <span class="input-group-addon input-group-append border-left">
                                  <span class="far fa-calendar input-group-text"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
<!--                            <input type="date" class="form-control" id="due_date" name="due_date" required>-->
                            <div id="datepicker-due_date" class="input-group date datepicker">
                                <input type="text" id="due_date" name="due_date" class="form-control" required>
                                <span class="input-group-addon input-group-append border-left">
                                  <span class="far fa-calendar input-group-text"></span>
                                </span>
                            </div>
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
                                <?php foreach ($task_statuses_array as $key => $val): ?>
                                    <option value="<?= $key ?>"><?= $val ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Re Assign</label>
                            <select class="form-control" id="repetition_frequency" name="repetition_frequency" required>
                                <?php foreach ($task_repetition_frequency_array as $key => $val): ?>
                                    <option value="<?= $key ?>"><?= $val ?></option>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-flat form-check-primary">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" id="is_recurring" name="is_recurring" value="false">
                                    Is Recurring
                                    <i class="input-helper"></i></label>
                            </div>
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

<script>
    $(function()
    {
        'use strict';
        // $('.file-upload-default').on('change', function() {
        //     $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        // });

        $('#is_recurring').on('click', function() {
            if($(this).is(':checked')){
                $('#is_recurring').val(1);
            }else{
                $('#is_recurring').val(0);
            }
        });

        let task_files = [];
        if ($("#fileuploader").length) {
            $("#fileuploader").uploadFile({url: "/admin/tasks/upload-file",
                dragDrop: true,
                fileName: "taskFile",
                returnType: "json",
                showDelete: true,
                showDownload:false,
                statusBarWidth:600,
                dragdropWidth:600,
                onLoad:function () {

                },
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
        }
    });

</script>
<?= $this->endSection() ?>
