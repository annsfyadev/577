<?php
require_once('./../../config.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT o.*, c.code as ccode, CONCAT(c.lastname, ', ', c.firstname, ' ', COALESCE(c.middlename, '')) as client 
                          FROM `order_list` o 
                          INNER JOIN client_list c ON o.client_id = c.id 
                          WHERE o.id = '{$_GET['id']}'");

    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    } else {
        // If no order found
        ?>
        <center>Unknown Order</center>
        <style>
            #uni_modal .modal-footer {
                display: none;
            }
        </style>
        <div class="text-right">
            <button class="btn btndefault bg-gradient-dark btn-flat" data-dismiss="modal">
                <i class="fa fa-times"></i> Close
            </button>
        </div>
        <?php
        exit;
    }
}
?>

<style>
    #uni_modal .modal-footer {
        display: none;
    }
    .outer-box {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
    }
    .prod-img {
        width: calc(100%);
        height: auto;
        max-height: 10em;
        object-fit: scale-down;
        object-position: center center;
    }
</style>

<div class="container-fluid">
    <!-- Outer Box for Order Information -->
    <div class="outer-box">
        <h5>Order Information</h5>
        <div class="row">
            <div class="col-3"><strong>Reference Code:</strong></div>
            <div class="col-9"><?= isset($code) ? $code : '' ?></div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Client:</strong></div>
            <div class="col-9"><?= isset($client) ? $ccode . ' - ' . $client : '' ?></div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Delivery Address:</strong></div>
            <div class="col-9"><?= isset($delivery_address) ? $delivery_address : '' ?></div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Status:</strong></div>
            <div class="col-9">
                <?php 
                switch ($status) {
                    case 0: echo '<span class="badge badge-secondary bg-gradient-secondary px-3 rounded-pill">Pending</span>'; break;
                    case 1: echo '<span class="badge badge-primary bg-gradient-primary px-3 rounded-pill">Confirmed</span>'; break;
                    case 2: echo '<span class="badge badge-info bg-gradient-info px-3 rounded-pill">Packed</span>'; break;
                    case 3: echo '<span class="badge badge-warning bg-gradient-warning px-3 rounded-pill">Out for Delivery</span>'; break;
                    case 4: echo '<span class="badge badge-success bg-gradient-success px-3 rounded-pill">Delivered</span>'; break;
                    case 5: echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Cancelled</span>'; break;
                    default: echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">N/A</span>'; break;
                }
                ?>
                <?php if ($status != 5): ?>
                    <span class="pl-2"><a href="javascript:void(0)" id="update_status">Update Status</a></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="clear-fix mb-2"></div>

    <!-- Outer Box for Order Items -->
    <div class="outer-box" id="order-list">
        <h5>Order Items</h5>
        <?php 
        $gtotal = 0;
        $products = $conn->query("SELECT o.*, p.name as `name`, p.price, p.image_path 
                                   FROM `order_items` o 
                                   INNER JOIN product_list p ON o.product_id = p.id 
                                   WHERE o.order_id = '{$id}' 
                                   ORDER BY p.name ASC");

        while ($prow = $products->fetch_assoc()):
            $total = $prow['price'] * $prow['quantity'];
            $gtotal += $total;
        ?>
        <div class="row border mb-2">
            <div class="col-2 text-center">
                <a href="./?page=products/view_product&id=<?= $prow['product_id'] ?>">
                    <img src="<?= validate_image($prow['image_path']) ?>" alt="" class="img-center prod-img border bg-gradient-gray">
                </a>
            </div>
            <div class="col-auto flex-shrink-1 flex-grow-1">
                <h4><b><?= $prow['name'] ?></b></h4>
                <div class="d-flex">
                    <div class="col-auto px-0"><normal class="text-muted">Price:</normal></div>
                    <div class="col-auto px-0 flex-shrink-1 flex-grow-1">
                        <p class="m-0 pl-3"><normal class="text-black"><?= format_num($prow['price']) ?></normal></p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="col-auto px-0"><normal class="text-muted">Qty:</normal></div>
                    <div class="col-auto px-0 flex-shrink-1 flex-grow-1">
                        <p class="m-0 pl-3"><normal class="text-black"><?= format_num($prow['quantity']) ?></normal></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <div class="row border">
            <div class="col-9 h4 font-weight-bold text-right text-muted">Total</div>
            <div class="col-3 h4 font-weight-bold text-right"><?= format_num($gtotal) ?></div>
        </div>
    </div>

    <div class="clear-fix mb-3"></div>

    <div class="text-right">
        <button class="btn btn-default bg-gradient-dark text-light btn-sm btn-flat" type="button" data-dismiss="modal">
            <i class="fa fa-times"></i> Close
        </button>
    </div>
</div>

<script>
    $(function() {
        $('#update_status').click(function() {
            uni_modal_second("Update Order Status - <b><?= isset($code) ? $code : '' ?></b>", "orders/update_status.php?id=<?= isset($id) ? $id : '' ?>");
        });
    });
</script>
