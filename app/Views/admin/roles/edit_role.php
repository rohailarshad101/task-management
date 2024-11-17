<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Edit Role
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/roles">Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="/admin/roles/update/<?= $role['id'] ?>" method="post" class="forms-sample">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $role['name'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Role Access Matrix</h4>
                    <form method="POST" action='<?php echo base_url() ?>admin/roles/storeAccessMatrix'>
                        <input type="hidden" value="<?php echo $role['id']; ?>" name="roleIdForMatrix" id="roleIdForMatrix" />
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Modules</th>
<!--                                    <th>All</th>-->
                                    <th>List</th>
                                    <th>Create</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($moduleList))
                                {
                                    foreach($moduleList as $record)
                                    {
                                        $key = array_search($record['module'], array_column($roleAccessMatrix, 'module'));
                                        $matrix = (array) $roleAccessMatrix[$key];
                                        ?>
                                        <tr>
                                            <td><b><?php echo $record['module'] ?></b> <input type="hidden" name="access[<?= $record['module'] ?>][module]" value="<?php echo $record['module'] ?>"  /> </td>
<!--                                            <td><input type='checkbox' name='access[--><?php //= $record['module'] ?><!--][all_access]' --><?php //= ($matrix['all_access'] == 1) ? 'checked':''; ?><!-- /></td>-->
                                            <td><input type='checkbox' name='access[<?= $record['module'] ?>][list]' <?= ($matrix['list'] == 1) ? 'checked':''; ?> /></td>
                                            <td><input type='checkbox' name='access[<?= $record['module'] ?>][create_records]' <?= ($matrix['create_records'] == 1) ? 'checked':''; ?> /></td>
                                            <td><input type='checkbox' name='access[<?= $record['module'] ?>][edit_records]' <?= ($matrix['edit_records'] == 1) ? 'checked':''; ?> /></td>
                                            <td><input type='checkbox' name='access[<?= $record['module'] ?>][delete_records]' <?= ($matrix['delete_records'] == 1) ? 'checked':''; ?> /></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <input type="submit" class="btn btn-primary" value="Save" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function()
    {
    <?php if (session()->getFlashdata('success')): ?>
        $.toast({
            heading: 'Success',
            text: "<?= session()->getFlashdata('success') ?>",
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#ffffff',
            position: 'top-right'
        })
    <?php
    endif;
    if (session()->getFlashdata('error')): ?>
        $.toast({
            heading: 'Danger',
            text: "<?= session()->getFlashdata('error') ?>",
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        });
    <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>
