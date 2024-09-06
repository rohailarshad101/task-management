<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Departments List
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/departments">Departments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Departments List</li>
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
                            <a href="/admin/departments/create" class="btn btn-primary">New Department</a>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="order-listing"  class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($departments as $department): ?>
                                <tr>
                                    <td><?= $department['name'] ?></td>
                                    <td class="text-center">
                                        <a href="/admin/departments/edit/<?= $department['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/admin/departments/delete/<?= $department['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
<?= $this->endSection() ?>
