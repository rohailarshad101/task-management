<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Create User
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/users">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create User</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="/admin/users/store" method="post" class="forms-sample">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="email" class="form-control" id="user_email" name="user_email" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Mobile</label>
                            <input type="text" class="form-control" id="user_mobile" name="user_mobile" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Role</label>
                            <select class="form-control" id="role_id" name="role_id" required>
                                <option value="">Choose</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category">Departments</label>
                            <select class="form-control" id="dept_id" name="dept_id" required>
                                <option value="">Choose</option>
                                <?php foreach ($departments as $department): ?>
                                    <option value="<?= $department['id'] ?>"><?= $department['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch user_status_toggle">
                                <input class="form-check-input" type="checkbox" value="" id="user_active" name="user_active">
                                <label class="form-check-label" for="user_active">Active</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(document).on('click', "#user_active", function () {
            // 'this' refers to the checkbox that was clicked
            let checkbox = $(this);

            // Set the value based on the checked state
            if (checkbox.prop('checked')) {
                checkbox.val('1');  // Checked state, set value to 1
            } else {
                checkbox.val('0');  // Unchecked state, set value to 0
            }
        });
    })
</script>

<?= $this->endSection() ?>
