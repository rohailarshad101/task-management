<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<?php
$profile_picture = $user['profile_picture'];
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
                    <img src="<?= base_url().$profile_picture ?>" class="img-lg rounded-circle mb-2" alt="profile image"/>
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
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tasks Progress</h4>
                    <div id="tasks-progress-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function()
    {
        //var c3DonutChart = c3.generate({
        //    bindto: '#tasks-progress-chart',
        //    data: {
        //        columns: [
        //        <?php //foreach ($statusCounts as $key => $row) {
        //            echo "<pre>";
        //            print_r($row['count']);
        //            die();
        //            ?>
        //                ["<?php //= $key ?>//", <?php //= $row['count'] ?>//],
        //        <?php //}?>
        //        ],
        //        type: 'donut',
        //        onclick: function(d, i) {
        //            console.log("onclick", d, i);
        //        },
        //        onmouseover: function(d, i) {
        //            console.log("onmouseover", d, i);
        //        },
        //        onmouseout: function(d, i) {
        //            console.log("onmouseout", d, i);
        //        }
        //    },
        //    color: {
        //        pattern: ['rgba(4,183,107,1)', 'rgba(255,56,74,1)', 'rgba(245,166,35,1)', 'rgba(11,148,247,1)']
        //    },
        //    padding: {
        //        top: 0,
        //        right: 0,
        //        bottom: 30,
        //        left: 0,
        //    },
        //    donut: {
        //        title: "Assigned Tasks"
        //    }
        //});
        if ($("#tasks-progress-chart").length) {
            Morris.Donut({
                element: 'tasks-progress-chart',
                // colors: ['#76C1FA', '#63CF72', '#F36368',  '#FABA66'],
                data: [
                    <?php foreach ($statusCounts as $key => $row) {?>
                        {
                            label: "<?= $key ?>",
                            value: <?= $row['count'] ?>,
                            color: "<?= $row['color'] ?>",
                        },
                    <?php }?>
                ]
            });
        }
    });
</script>

<?= $this->endSection() ?>
