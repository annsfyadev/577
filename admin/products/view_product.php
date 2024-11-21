<!--/* This is Admin (Left side - Button view Action Product List) */-->

<?php
require_once('./../../config.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    // Fetch product details
    $qry = $conn->query("
        SELECT p.*, c.name AS `category`, v.code, v.shop_name AS `vendor`
        FROM `product_list` p
        INNER JOIN category_list c ON p.category_id = c.id
        INNER JOIN vendor_list v ON p.vendor_id = v.id
        WHERE p.id = '{$_GET['id']}' AND p.delete_flag = 0
    ");

    if ($qry->num_rows > 0) {
        // Extract product details
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    } else {
        // If no product found
        ?>
        <center>Unknown Product</center>
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
        margin-bottom: 15px;
        background-color: #f9f9f9;
        padding: 15px;
    }
    .prod-img-view {
        width: 100%; /* Adjust to fit the box */
        max-height: 20em;
        object-fit: scale-down;
        object-position: center center;
    }
</style>

<div class="container-fluid">
    <!-- Outer Box for Product -->
    <div class="outer-box text-center">
        <h5>Product Image</h5>
        <img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" 
             alt="Product Image" 
             class="img-thumbnail prod-img-view">
    </div>

    <!-- Product Details -->
    <div class="outer-box">
        <h5>Product Information</h5>
        <div class="row">
            <div class="col-3"><strong>Seller:</strong></div>
            <div class="col-9"><?= isset($name) ? $code . " - " . $name : "N/A" ?></div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Item:</strong></div>
            <div class="col-9"><?= isset($name) ? $name : "N/A" ?></div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Category:</strong></div>
            <div class="col-9"><?= isset($category) ? $category : "N/A" ?></div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Price:</strong></div>
            <div class="col-9"><?= isset($price) ? format_num($price) : "N/A" ?></div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Description:</strong></div>
            <div class="col-9"><?= isset($description) ? html_entity_decode($description) : "N/A" ?></div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Status:</strong></div>
            <div class="col-9">
                <?php if ($status == 1): ?>
                    <span class="badge badge-success bg-gradient-success px-3 rounded-pill">Active</span>
                <?php else: ?>
                    <span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Inactive</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="text-right mt-3">
        <button class="btn btn-default bg-gradient-dark btn-sm btn-flat" type="button" data-dismiss="modal">
            <i class="fa fa-times"></i> Close
        </button>
    </div>
</div>
