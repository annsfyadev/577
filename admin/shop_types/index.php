<style>
      .card-outline.teal-top {
        border-top: 3px solid teal; /* Outline */
        border-left: none;
        border-right: none;
        border-bottom: none;
        border-radius: 8px;
    }
</style>

<?php if ($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<div class="card card-outline teal-top card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Shop Types</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" class="btn btn-flat btn-primary" id="create_new"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="25%">
                    <col width="25%">
                    <col width="25%">
                    <col width="20%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient-secondary">
                        <th class="text-center">No.</th>
                        <th class="text-center">Date Created</th>
                        <th class="text-center">Shop Type</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $qry = $conn->query("SELECT * FROM `shop_type_list` WHERE delete_flag = 0 ORDER BY `name` ASC");
                    while ($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?></td>
                        <td class="text-center"><?= date("Y-m-d H:i", strtotime($row['date_created'])); ?></td>
                        <td class="text-center"><?= $row['name']; ?></td>
                        <td class="text-center">
                            <?php if ($row['status'] == 1): ?>
                                <span class="badge badge-success bg-gradient-success px-3 rounded-pill">Active</span>
                            <?php else: ?>
                                <span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                Action
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                                    <span class="fa fa-edit text-primary"></span> Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                                    <span class="fa fa-trash text-danger"></span> Delete
                                </a>
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
        $('#create_new').click(function() {
            uni_modal('Add New Shop Type', "shop_types/manage_shop_type.php");
        });
        $('.edit_data').click(function() {
            uni_modal('Update Shop Type', "shop_types/manage_shop_type.php?id=" + $(this).attr('data-id'));
        });
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this Shop Type permanently?", "delete_shop_type", [$(this).attr('data-id')]);
        });
        $('.table').dataTable();
    });

    function delete_shop_type($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_shop_type",
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
