<!--/*This is Admin(Left side - Product List) --> 
<style>
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

    .product-img {
        width: calc(100%);
        height: auto;
        max-width: 5em;
        object-fit: scale-down;
        object-position: center center;
    }
</style>

<?php if ($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<div class="card card-outline teal-top card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Resources</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-striped">
                <colgroup>
                    <col width="3%">
                    <col width="15%">
                    <col width="20%">
                    <col width="20%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead style="background-color: #C1E1C1; color: black;">
                    <tr>
                        <th class="center">No.</th>
                        <th class="center">Date Upload</th>
                        <th class="center">Image</th>
                        <th class="center">Seller</th>
                        <th class="center">Resources</th>
                        <th class="center">Cost</th>
                        <th class="center">Status</th>
                        <th class="center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $qry = $conn->query("SELECT p.*, v.code, v.shop_name as `seller` FROM `Resources` p INNER JOIN seller v ON p.seller_id = v.id WHERE p.delete_flag = 0 ORDER BY p.`name` ASC");
                    while ($row = $qry->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td class="text-center"><?php echo date("Y-m-d H:i", strtotime($row['date_created'])); ?></td>
                            <td class="text-center"><img src="<?= validate_image($row['image_path']); ?>" alt="Product Image" class="border border-gray img-thumbnail product-img"></td>
                            <td class="text-center"><?= $row['code'] . ' - ' . ucwords($row['seller']); ?></td>
                            <td class="text-center"><?= ucwords($row['name']); ?></td>
                            <td class="text-center"><?php echo format_num($row['price']); ?></td>
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
                                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-eye text-dark"></span> View</a>
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
            uni_modal('Add New Resources', "products/manage_product.php", 'large');
        });
        $('.view_data').click(function() {
            uni_modal('View Resources Details', "products/view_product.php?id=" + $(this).attr('data-id'), 'large');
        });
        $('.edit_data').click(function() {
            uni_modal('Update Resources', "products/manage_product.php?id=" + $(this).attr('data-id'), 'large');
        });
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this Resources permanently?", "delete_product", [$(this).attr('data-id')]);
        });
        $('table th,table td').addClass('align-middle px-2 py-1');
        $('.table').dataTable();
    });

    function delete_product($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_product",
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
