<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Profile Information
        </h3>
    </div>
    <div class="row">
        <!--        <div class="col-md-4 grid-margin stretch-card">-->
        <!--            <div class="card">-->
        <!--                <div class="card-body d-flex flex-column">-->
        <!--                    <h4 class="card-title">-->
        <!--                        <i class="fas fa-chart-pie"></i>-->
        <!--                        Sales status-->
        <!--                    </h4>-->
        <!--                    <div class="flex-grow-1 d-flex flex-column justify-content-between">-->
        <!--                        <canvas id="sales-status-chart" class="mt-3"></canvas>-->
        <!--                        <div class="pt-4">-->
        <!--                            <ol  class="custom-list list-group">-->
        <!--                                <li  class="list-group-item d-flex justify-content-between align-items-start flex-wrap">-->
        <!--                                    <div  class="ms-2 me-auto">Mobile</div><span >+971 50 550 0355</span></li>-->
        <!--                                <li  class="list-group-item d-flex justify-content-between align-items-start flex-wrap">-->
        <!--                                    <div  class="ms-2 me-auto">Email</div><span >rohail@aqari.com</span></li>-->
        <!--                            </ol>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card text-center">
                <div class="card-body">
                    <img src="<?= base_url() ?>vendors/images/faces/face5.jpg" class="img-lg rounded-circle mb-2" alt="profile image"/>
                    <h4><?= $first_name.' '.$last_name; ?></h4>
                    <p class="text-muted">Developer</p>
                    <p class="mt-4 card-text">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                        Aenean commodo ligula eget dolor. Lorem
                    </p>
                    <!--                    <button class="btn btn-info btn-sm mt-3 mb-4">Follow</button>-->
                    <div class="border-top pt-4">
                        <ol  class="custom-list list-group">
                            <li  class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                                <div class="ms-2 me-auto">Email</div><span ><?= $email; ?></span></li>
                            <li  class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                                <div class="ms-2 me-auto">Mobile</div><span ><?= $mobile; ?></span></li>
                        </ol>
                        <!--                        <div class="row">-->
                        <!--                            <div class="col-4">-->
                        <!--                                <h6>5896</h6>-->
                        <!--                                <p>Post</p>-->
                        <!--                            </div>-->
                        <!--                            <div class="col-4">-->
                        <!--                                <h6>1596</h6>-->
                        <!--                                <p>Followers</p>-->
                        <!--                            </div>-->
                        <!--                            <div class="col-4">-->
                        <!--                                <h6>7896</h6>-->
                        <!--                                <p>Likes</p>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="first-name">First Name</label>
                                <input type="text" id="first-name" class="form-control" value="<?= $first_name; ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="last-name">Last Name</label>
                                <input type="text" id="last-name" class="form-control" value="<?= $last_name; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="edit-email">Email</label>
                                <input type="email" id="edit-email" class="form-control" value="<?= $email; ?>" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="edit-phone">Mobile</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img src="https://via.placeholder.com/20x13" alt="AE Flag">
                                    </span>
                                    </div>
                                    <input type="text" id="edit-phone" class="form-control" value="<?= $mobile; ?>">
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary float-right">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
