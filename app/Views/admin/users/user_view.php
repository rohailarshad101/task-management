<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<?php
$profile_picture = $user['profile_picture'];
if(empty($profile_picture)){
    $profile_picture = 'vendors/images/faces/default.png';
}
?>
<style>
    /* Tooltip Styling */
    .c3-tooltip {
        width: 150px; /* Increase width for better readability */
        background-color: #fff;
        border: 2px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
        color: #333;
        text-align: left;
        line-height: 18px;  /* Adjust line height for better text spacing */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        white-space: normal; /* Ensure long text wraps inside the tooltip */
        word-wrap: break-word; /* Allow long words to break and wrap to the next line */
        max-height: 200px; /* Maximum height before scrolling */
        overflow-y: auto; /* Enable vertical scrolling if content overflows */
    }

    .c3-tooltip .tooltip-title {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .c3-tooltip .tooltip-value {
        font-size: 14px;
    }

    .c3-tooltip .tooltip-label {
        font-size: 14px;
        line-height: 18px; /* Ensure proper line spacing for readability */
        margin-bottom: 3px; /* Space between labels */
    }
</style>
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
<!--                    <p class="mt-4 card-text">-->
<!--                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.-->
<!--                        Aenean commodo ligula eget dolor. Lorem-->
<!--                    </p>-->
                    <div class="pt-4">
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
        if ($("#tasks-progress-chart").length) {
            var labels = <?php echo json_encode($grouped_tasks_by_statuses); ?>;
            var c3DonutChart = c3.generate({
                bindto: '#tasks-progress-chart',
                data: {
                    type: 'donut',
                    columns: [
                    <?php foreach ($statusCounts as $key => $row) {?>
                        ["<?= $key ?>", <?= $row['count'] ?>],
                    <?php }?>
                    ],
                    // onclick: function(d, i) {
                    //     // console.log("onclick", d, i);
                    // },
                    onmouseover: function(d, i) {
                        $('.c3-chart-arcs-title').text(d.name.toUpperCase()+' : '+d.value+'%');
                    },
                    onmouseout: function(d, i) {
                        $('.c3-chart-arcs-title').text("Assigned Tasks");
                    }
                },
                color: {
                    pattern: ['rgba(4,183,107,1)', 'rgba(255,56,74,1)', 'rgba(245,166,35,1)', 'rgba(11,148,247,1)']
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 30,
                    left: 0,
                },
                donut: {
                    title: "Assigned Tasks",
                    expand: true
                },
                tooltip: {
                    contents: function (d, defaultTitleFormat, defaultValueFormat, color) {
                        var index = d[0].index; // Get the index of the donut slice
                        var tooltipContent = '<div class="c3-tooltip">';
                        // Check if status exists in labels
                        if (labels[d[0].id]) {
                            // Get the task titles under the given status
                            var tasks = labels[d[0].id];

                            // Add task titles to tooltip with line breaks
                            tooltipContent += '<div class="tooltip-label">' + tasks.join('<br>') + '</div>';
                        } else {
                            // If the status is not found, display a fallback message
                            tooltipContent += '<div class="tooltip-label">No tasks available</div>';
                        }

                        tooltipContent += '</div>';
                        return tooltipContent;
                    }
                }
            });
            //Morris.Donut({
            //    element: 'tasks-progress-chart',
            //    // colors: ['#76C1FA', '#63CF72', '#F36368',  '#FABA66'],
            //    data: [
            //        <?php //foreach ($statusCounts as $key => $row) {?>
            //            {
            //                label: "<?php //= $key ?>//",
            //                value: <?php //= $row['count'] ?>//,
            //                color: "<?php //= $row['color'] ?>//",
            //            },
            //        <?php //}?>
            //    ]
            //});
        }
    });
</script>

<?= $this->endSection() ?>
