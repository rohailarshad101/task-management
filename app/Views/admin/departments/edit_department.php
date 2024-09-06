<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Edit Department
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/departments">Departments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Department</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="/admin/departments/update/<?= $department['id'] ?>" method="post" class="forms-sample">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $department['name'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
