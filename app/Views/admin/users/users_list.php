<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Users List
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/users">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users List</li>
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
                            <a href="/admin/users/create" class="btn btn-primary">New User</a>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="order-listing"  class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Role</th>
                                <th>Department</th>
                                <th>Active</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['first_name'].' '.$user['last_name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['mobile'] ?></td>
                                    <td><?= $user['user_role']['name'] ?></td>
                                    <td><?= $user['user_dept']['name'] ?></td>
                                    <td>
                                        <?php
                                            if(($user['is_active'])) {
                                                $checked = "checked";
                                                $value = "1";
                                            }else{
                                                $checked = "";
                                                $value = "0";
                                            }
                                        ?>
                                        <div class="form-check form-switch user_status_toggle">
                                            <input type="checkbox" class="form-check-input" id="user_active" name="user_active" data-id="<?= $user['id'] ?>" value="<?= $value ?>" <?= $checked?>>
                                            <label class="form-check-label" for="user_active">Active</label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/admin/users/delete/<?= $user['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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

<script>
    $(function ()
    {
        $(document).on('click', "#user_active", function () {
            // 'this' refers to the checkbox that was clicked
            let checkbox = $(this);

            // Set the value based on the checked state
            let isActive = checkbox.prop('checked') ? 1 : 0; // 1 for active, 0 for inactive
            checkbox.val(isActive);

            // Capture the user ID (assuming it's stored as a data attribute)
            let userId = checkbox.attr('data-id');

            // Make an API call to update the user's status
            $.ajax({
                url: '/admin/users/active-inactive',  // Update this to your actual API endpoint
                method: 'POST',
                data: {
                    user_id: userId,
                    status: isActive  // Send the new status (1 for active, 0 for inactive)
                },
                success: function(response) {
                    console.log('User status updated successfully:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error updating user status:', error);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
