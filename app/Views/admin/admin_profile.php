<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<?php
$middle_url = session()->get('middle_url');
$profile_picture = session()->get('profile_picture');
if(empty($profile_picture)){
    $profile_picture = 'vendors/images/faces/default.png';
}
?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Profile Information
        </h3>
    </div>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card text-center">
                <div class="card-body">
                    <img src="<?= base_url().$user['profile_picture'] ?>" class="img-lg rounded-circle mb-2" alt="profile image"/>
                    <h4><?= $user['first_name'].' '.$user['last_name']; ?></h4>
                    <p class="text-muted">Developer</p>
                    <p class="mt-4 card-text">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                        Aenean commodo ligula eget dolor. Lorem
                    </p>
                    <!--                    <button class="btn btn-info btn-sm mt-3 mb-4">Follow</button>-->
                    <div class="border-top pt-4">
                        <ol  class="custom-list list-group">
                            <li  class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                                <div class="ms-2 me-auto">Email</div><span ><?= $user['email']; ?></span></li>
                            <li  class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                                <div class="ms-2 me-auto">Mobile</div><span ><?= $user['mobile']; ?></span></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="/<?= $middle_url; ?>/update-profile" method="POST" id="update_user_profile" class="forms-sample" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="first-name">First Name</label>
                                <input type="text" id="first_name" class="form-control" name="first_name" value="<?= $user['first_name']; ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="last-name">Last Name</label>
                                <input type="text" id="last_name" class="form-control" name="last_name" value="<?= $user['last_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="edit-email">Email</label>
                                <input type="email" id="user_email" class="form-control" name="user_email" value="<?= $user['email']; ?>" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="edit-phone">Mobile</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img src="https://via.placeholder.com/20x13" alt="AE Flag">
                                    </span>
                                    </div>
                                    <input type="text" id="user_mobile" class="form-control" name="user_mobile" value="<?= $user['mobile']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="formFileMultiple" class="col-form-label">Profile Picture:</label>
                                <input class="form-control" type="file" id="profile_picture" name="profile_picture">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#update_user_profile").on("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Use AJAX for form submission, if necessary, or allow the form to submit as normal:
            this.submit(); // Explicitly submit the form with the POST method
        });
    });
</script>
<?= $this->endSection() ?>
