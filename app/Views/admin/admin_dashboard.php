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
                        <?php foreach ($taskCount as $task): ?>
                        <div class="statistics-item">
                            <p>
                                <i class="icon-sm fa fa-tasks mr-2"></i>
                                <?= $task['status'] ?>
                            </p>
                            <h2><?= $task['count'] ?></h2>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="fas fa-table"></i>
                        Sales Data
                    </h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Item code</th>
                                <th>Orders</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="font-weight-bold">
                                    Clifford Wilson
                                </td>
                                <td class="text-muted">
                                    PT613
                                </td>
                                <td>
                                    350
                                </td>
                                <td>
                                    <label class="badge badge-success badge-pill">Dispatched</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    Mary Payne
                                </td>
                                <td class="text-muted">
                                    ST456
                                </td>
                                <td>
                                    520
                                </td>
                                <td>
                                    <label class="badge badge-warning badge-pill">Processing</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    Adelaide Blake
                                </td>
                                <td class="text-muted">
                                    CS789
                                </td>
                                <td>
                                    830
                                </td>
                                <td>
                                    <label class="badge badge-danger badge-pill">Failed</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    Adeline King
                                </td>
                                <td class="text-muted">
                                    LP908
                                </td>
                                <td>
                                    579
                                </td>
                                <td>
                                    <label class="badge badge-primary badge-pill">Delivered</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">
                                    Bertie Robbins
                                </td>
                                <td class="text-muted">
                                    HF675
                                </td>
                                <td>
                                    790
                                </td>
                                <td>
                                    <label class="badge badge-info badge-pill">On Hold</label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
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
<?= $this->endSection() ?>
