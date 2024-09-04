<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Roles List
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/roles">Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page">Roles List</li>
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
                            <a href="/admin/roles/create" class="btn btn-primary">New Role</a>
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
                            <?php foreach ($roles as $role): ?>
                                <tr>
                                    <td><?= $role['name'] ?></td>
                                    <td class="text-center">
                                        <a href="/admin/roles/edit/<?= $role['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/admin/roles/delete/<?= $role['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
