<?php
$role_id = session()->get('role_id');
$first_name = session()->get('first_name');
$last_name = session()->get('last_name');
$email = session()->get('email');
$mobile = session()->get('mobile');
$role_name = session()->get('role_name');
$middle_url = session()->get('middle_url');
?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.urbanui.com/melody/template/pages/forms/basic_elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Sep 2018 06:07:32 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
<!--    <meta name="referrer" content="no-referrer">-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title>Task Management</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= base_url() ?>vendors/iconfonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= base_url() ?>vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= base_url() ?>vendors/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= base_url() ?>vendors/images/favicon.png"/>
    <script src="<?= base_url() ?>vendors/js/jquery.min.js"></script>
</head>

<body>
<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="<?= base_url().$middle_url.'/dashboard' ?>"><img src="<?= base_url() ?>vendors/images/logo.svg" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="<?= base_url().$middle_url.'/dashboard' ?>">
                <img src="<?= base_url() ?>vendors/images/logo-mini.svg" alt="logo"/></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="fas fa-bars"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
                <?php if ($role_id !== 1 && ($role_id == 2 || $role_id == 3)){?>
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="fas fa-bell mx-0"></i>
                        <?php
                        $notifications = session()->get('notifications');
                        $notification_count = count($notifications);?>
                        <span class="count"><?= $notification_count ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                        <a class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">You have <?= $notification_count ?> new notifications
                            </p>
                            <span class="badge badge-pill badge-warning float-right">View all</span>
                        </a>
                    <?php foreach ($notifications as $notification): ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-info">
                                    <i class="far fa-envelope mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-medium notification" data-id="<?= $notification['id'] ?>"><?= $notification['title'] ?></h6>
                                <p class="font-weight-light small-text">
                                    <?= insertLineBreakAfterLength($notification['message'], 40) ?>
                                </p>
                                <p class="font-weight-light small-text">
                                    <?= $notification['time_difference'] ?>
                                </p>
                                <button class="mark-as-read">Mark as Read</button>
                            </div>
                        </a>
                    <?php endforeach; ?>
                    </div>
                </li>
                <?php } ?>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="<?= base_url() ?>vendors/images/faces/face5.jpg" alt="profile"/>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <?php
                            if($role_id == 1){
                                $profile_url = "/admin/profile";
                            } else if($role_id == 2 || $role_id == 3){
                                $profile_url = "/user/profile";
                            }
                        ?>
                        <a class="dropdown-item"  href="<?= $profile_url ?>">
                            <i class="fas fa-user text-primary"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">
                            <i class="fas fa-power-off text-primary"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                <span class="fas fa-bars"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <div class="nav-link">
                        <div class="profile-image">
                            <img src="<?= base_url() ?>vendors/images/faces/face5.jpg" alt="image"/>
                        </div>
                        <div class="profile-name">
                            <p class="name">
                                <?= $first_name.' '.$last_name ?>
                            </p>
                            <p class="designation">
                                <?= $role_name; ?>
                            </p>
                        </div>
                    </div>
                </li>
                <?php if($role_id == 1){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/tasks">
                        <i class="fa fa-home menu-icon"></i>
                        <span class="menu-title">Tasks</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/categories">
                        <i class="fa fa-cubes menu-icon"></i>
                        <span class="menu-title">Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/users">
                        <i class="fa fa-users menu-icon"></i>
                        <span class="menu-title">Users</span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <?= $this->renderSection('content') ?>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<div id="content" class="swal-overlay swal-overlay--show-modal" style="opacity: 0.3;">
    <!-- Content will be updated here -->
</div>
<!-- Loader Element -->
<div id="loader" style="display: none;">
    <div class="pixel-loader"></div>
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="<?= base_url() ?>vendors/js/vendor.bundle.base.js"></script>
<script src="<?= base_url() ?>vendors/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="<?= base_url() ?>vendors/js/misc.js"></script>
<script src="<?= base_url() ?>vendors/js/dashboard.js"></script>
<script src="<?= base_url() ?>vendors/js/data-table.js"></script>
<script src="<?= base_url() ?>vendors/js/select2.js"></script>
<!--<script src="--><?php //= base_url() ?><!--vendors/js/file-upload.js"></script>-->

<!-- endinject -->
<script type="text/javascript">
    $(document).ready(function () {
        // Show loader before AJAX request starts
        $(document).ajaxStart(function() {
            $('#content').show();
            $('#loader').show();
        });

        // Hide loader after AJAX request completes
        $(document).ajaxStop(function() {
            $('#content').hide();
            $('#loader').hide();
        });

        if ($(".datepicker").length) {
            $('#datepicker-start_date').datepicker({
                startDate: new Date(),
                enableOnReadonly: true,
                autoclose: true,
                todayHighlight: true,
                format: 'dd-mm-yyyy',
            }).on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#datepicker-due_date').datepicker('setStartDate', minDate);
            });

            $('#datepicker-due_date').datepicker({
                // startDate: new Date(),
                enableOnReadonly: true,
                autoclose: true,
                todayHighlight: true,
                format: 'dd-mm-yyyy'
            });
        }

        // Click event for the "Mark as Read" button
        $('.mark-as-read').on('click', function() {
            // Get the notification ID from the parent element
            var notificationId = $(this).closest('.notification').data('id');

            // AJAX request to mark the notification as read
            $.ajax({
                url: '/user/notifications/mark-as-read',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    notification_ids: [notificationId]
                }),
                success: function(response) {
                    alert(response.message);

                    // Optionally, you can remove or hide the notification
                    $(this).closest('.notification').remove();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Failed to mark notification as read.');
                }
            });
        });
    });

</script>
<!-- End custom js for this page-->
</body>


<!-- Mirrored from www.urbanui.com/melody/template/pages/forms/basic_elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Sep 2018 06:07:34 GMT -->
</html>
