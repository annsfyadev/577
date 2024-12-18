<?php if ($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<style>
    .img-avatar {
        width: 45px;
        height: 45px;
        object-fit: cover;
        object-position: center center;
        border-radius: 100%;
    }

    th.center {
        text-align: center; /* Centers text horizontally */
        vertical-align: middle; /* Centers text vertically */
        padding: 10px; /* Adds spacing inside the cells */
    }

    .badge-primary {
        background-color: #28a745; /* Green color */
        color: white; /* Text color */
    }

    .card-outline.teal-top {
        border-top: 3px solid teal; /* Outline */
        border-left: none;
        border-right: none;
        border-bottom: none;
        border-radius: 8px;
    }
</style>

<div class="card card-outline teal-top card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Customers</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-striped">
                <colgroup>
                    <col width="3%">
                    <col width="15%">
                    <col width="15%">
                    <col width="20%">
                    <col width="20%">
                    <col width="15%">
                    <col width="10%">
                </colgroup>
                <thead style="background-color: #C1E1C1; color: black;">
                    <tr>
                        <th class="center">No.</th>
                        <th class="center">Profile</th>
                        <th class="center">Code</th>
                        <th class="center">Name</th>
                        <th class="center">Email</th>
                        <th class="center">Status</th>
                        <th class="center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $qry = $conn->query("SELECT *, CONCAT(lastname, ', ', firstname, ' ', COALESCE(middlename)) AS `name` FROM `customer` WHERE delete_flag = 0 ORDER BY CONCAT(lastname, ', ', firstname, ' ', COALESCE(middlename)) ASC");
                    while ($row = $qry->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td class="text-center"><img src="<?php echo validate_image($row['avatar']); ?>" class="img-avatar img-thumbnail p-0 border-2" alt="customer_avatar"></td>
                            <td class="text-center"><?php echo ($row['code']); ?></td>
                            <td class="text-center"><?php echo ucwords($row['name']); ?></td>
                            <td class="text-center"><?php echo ucwords($row['email']); ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 1): ?>
                                    <span class="badge badge-primary px-3 rounded-pill">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="?page=clients/manage_client&id=<?php echo $row['id']; ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this client permanently?", "delete_client", [$(this).attr('data-id')]);
        });
        $('.table').dataTable();
    });

    function delete_client($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Users.php?f=delete_client",
            method: "POST",
            data: { id: $id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
