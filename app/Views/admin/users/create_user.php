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
                            <label class="switch">
                                <input type="checkbox" id="toggle-switch">
                                <span class="slider"></span>
                                
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
