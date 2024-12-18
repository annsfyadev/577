<?php
require_once('./../../config.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * FROM `category` WHERE id = '{$_GET['id']}' AND delete_flag = 0");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    } else {
        // If no category found
        ?>
        <center>Unknown Category</center>
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
</style>

<div class="container-fluid">
    <!-- Outer Box for Category Information -->
    <div class="outer-box">
        <div class="row">
            <div class="col-3"><strong>Category:</strong></div>
            <div class="col-9"><?= isset($name) ? $name : "N/A" ?></div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Description:</strong></div>
            <div class="col-9"><?= isset($description) ? $description : "N/A" ?></div>
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

    <div class="text-right">
        <button class="btn btn-default bg-gradient-dark btn-sm btn-flat" type="button" data-dismiss="modal">
            <i class="fa fa-times"></i> Close
        </button>
    </div>
</div>
