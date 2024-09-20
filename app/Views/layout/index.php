<?php
$role_id = session()->get('role_id');
$first_name = session()->get('first_name');
$last_name = session()->get('last_name');
$email = session()->get('email');
$mobile = session()->get('mobile');
$role_name = session()->get('role_name');
$middle_url = session()->get('middle_url');
$profile_picture = session()->get('profile_picture');
if(empty($profile_picture)){
    $profile_picture = 'vendors/images/faces/default.png';
}
$notification_count = 0;
$notifications = session()->get('notifications');
if(!is_null($notifications)){
    $notification_count = count($notifications);
}

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
    <link rel="stylesheet" href="<?= base_url() ?>vendors/css/custom.css">
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
                <?php if ($role_id !== 1 && ($role_id == 2 || $role_id == 3)) {?>
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator" id="notificationDropdown" href="javascript:void(0)" data-toggle="modal" <?php if(count($notifications) > 0){?> data-target="#notificationModal" <?php }?> data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
                        <i class="fas fa-bell mx-0"></i>
                        <span class="count"><?= $notification_count ?></span>
                    </a>
                </li>
                <?php } ?>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="<?= base_url().$profile_picture ?>" alt="profile"/>
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
                            <img src="<?= base_url().$profile_picture ?>" alt="image"/>
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
                    <a class="nav-link" href="/admin/departments">
                        <i class="fa fa-cubes menu-icon"></i>
                        <span class="menu-title">Departments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/users">
                        <i class="fa fa-users menu-icon"></i>
                        <span class="menu-title">Users</span>
                    </a>
                </li>
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="/admin/roles">-->
<!--                        <i class="fa fa-users menu-icon"></i>-->
<!--                        <span class="menu-title">Roles</span>-->
<!--                    </a>-->
<!--                </li>-->
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
</div>
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">You have <?= $notification_count ?> new notifications</h5>
            </div>
            <div class="modal-body">
                <div class="preview-list">
                    <?php if($notification_count > 0) { ?>
                    <?php foreach ($notifications as $notification): ?>
                    <div class="preview-item px-0">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-info">
                                <i class="far fa-envelope mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-
                         flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-medium" data-id="<?= $notification['id'] ?>"><?= $notification['title'] ?>
                                <span class="float-right font-weight-light small-text"><?= $notification['time_difference'] ?></span>
                            </h6>
                            <p class="font-weight-light small-text">
                                <?= insertLineBreakAfterLength($notification['message'], 40) ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php } ?>

                </div>
            </div>
            <div class="modal-footer">
                <?php if($notification_count > 0){?>
                <button type="button" class="btn btn-success" id="mark_as_read">Mark All as read</button>
                <?php }?>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Loader Element -->
<div id="loader" style="display: none;">
    <div class="pixel-loader"></div>
</div>
<div class="loader-backdrop fade show" id="loader_div"  style="display: none;"></div>
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
<script src="<?= base_url() ?>vendors/js/tooltips.js"></script>
<!--<script src="--><?php //= base_url() ?><!--vendors/js/alerts.js"></script>-->
<!--<script src="--><?php //= base_url() ?><!--vendors/js/file-upload.js"></script>-->

<!-- endinject -->
<script type="text/javascript">
    $(function () {
        // Show loader before AJAX request starts
        $(document).ajaxStart(function() {
            $('#loader_div').show();
            $('#loader').show();
        });

        // Hide loader after AJAX request completes
        $(document).ajaxStop(function() {
            setTimeout(function () {
                $('#loader_div').hide();
                $('#loader').hide();
            }, 200)
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

        $(document).on('click', "#mark_as_read", function () {
            // Get the notification ID from the parent element
            let notificationId = $(this).closest('.notification').data('id');

            // AJAX request to mark the notification as read
            $.ajax({
                url: '/notifications/mark-as-read',
                type: 'POST',
                success: function(response) {
                    $.toast({
                        heading: 'Success',
                        text: response.message,
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#04B76B',
                        position: 'top-right'
                    });
                    setTimeout(function () {
                        location.reload();
                    },1500)
                },
                error: function(xhr, status, error) {
                    $.toast({
                        heading: 'Danger',
                        text: error.message,
                        showHideTransition: 'slide',
                        icon: 'warning',
                        loaderBg: '#f2a654',
                        position: 'top-right'
                    });
                }
            });
        });
    });

</script>
<!-- End custom js for this page-->
</body>

</html>
