<?php
require_once('./../../config.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT p.*, c.name as `category` 
                          FROM `resources` p 
                          INNER JOIN category c ON p.category_id = c.id 
                          WHERE p.id = '{$_GET['id']}' AND p.delete_flag = 0");

    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    } else {
        // If no product found
        ?>
        <center>Unknown Resources</center>
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
    #prod-img-view {
        width: 100%; /* Adjusted for responsiveness */
        max-height: 20em;
        object-fit: scale-down;
        object-position: center center;
    }
    .outer-box {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
    }
</style>

<div class="container-fluid">
    <!-- Outer Box for Product Information -->
    <div class="outer-box text-center">
        <img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" 
             alt="Resources Image" 
             class="img-thumbnail p-0 bg-gradient-gray" 
             id="prod-img-view">
    </div>

    <!-- Outer Box for Product Details -->
    <div class="outer-box">
        <h5>Resources Details</h5>
        <dl>
            <dt class="text-muted">Resources</dt>
            <dd class="pl-3"><?= isset($name) ? $name : "" ?></dd>
            <dt class="text-muted">Category</dt>
            <dd class="pl-3"><?= isset($category) ? $category : "" ?></dd>
            <dt class="text-muted">Price</dt>
            <dd class="pl-3"><?= isset($price) ? format_num($price) : "" ?></dd>
            <dt class="text-muted">Description</dt>
            <dd class="pl-3"><?= isset($description) ? html_entity_decode($description) : "" ?></dd>
            <dt class="text-muted">Status</dt>
            <dd class="pl-3">
                <?php if ($status == 1): ?>
                    <span class="badge badge-success bg-gradient-success px-3 rounded-pill">Active</span>
                <?php else: ?>
                    <span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Inactive</span>
                <?php endif; ?>
            </dd>
        </dl>
    </div>

    <div class="clear-fix mb-3"></div>
    
    <div class="text-right">
        <button class="btn btn-default bg-gradient-dark btn-sm btn-flat" type="button" data-dismiss="modal">
            <i class="fa fa-times"></i> Close
        </button>
    </div>
</div>
