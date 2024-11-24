<!--/*This is Admin(Left side - Order List) -->
<style>
    th.center {
        text-align: center; /* Centers text horizontally */
        vertical-align: middle; /* Centers text vertically */
        padding: 10px; /* Adds spacing inside the cells */
    }

    td {
        text-align: center; /* Centers text in data cells */
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

<div class="content py-3">
    <div class="card card-outline teal-top card-primary rounded-0 shadow">
        <div class="card-header">
            <h5 class="card-title"><b>Order List</b></h5>
        </div>
        <div class="card-body">
            <div class="w-100 overflow-auto">
                <table class="table table-bordered table-striped">
                    <colgroup>
                        <col width="3%">
                        <col width="20%">
                        <col width="20%">
                        <col width="15%">
                        <col width="10%">
                        <col width="10%">
                    </colgroup>
                    <thead style="background-color: #C1E1C1; color: black;">
                        <tr>
                            <th class="center">No.</th>
                            <th class="center">Date Ordered</th>
                            <th class="center">Ref. Code</th>
                            <th class="center">Total Amount</th>
                            <th class="center">Status</th>
                            <th class="center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $orders = $conn->query("SELECT * FROM `order_list` ORDER BY `status` ASC, UNIX_TIMESTAMP(date_created) DESC");
                        while ($row = $orders->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= date("Y-m-d H:i", strtotime($row['date_created'])); ?></td>
                            <td><?= $row['code']; ?></td>
                            <td><?= format_num($row['total_amount']); ?></td>
                            <td>
                                <?php 
                                switch ($row['status']) {
                                    case 0:
                                        echo '<span class="badge badge-secondary bg-gradient-secondary px-3 rounded-pill">Pending</span>';
                                        break;
                                    case 1:
                                        echo '<span class="badge badge-primary bg-gradient-primary px-3 rounded-pill">Confirmed</span>';
                                        break;
                                    case 2:
                                        echo '<span class="badge badge-info bg-gradient-info px-3 rounded-pill">Packed</span>';
                                        break;
                                    case 3:
                                        echo '<span class="badge badge-warning bg-gradient-warning px-3 rounded-pill">Out for Delivery</span>';
                                        break;
                                    case 4:
                                        echo '<span class="badge badge-success bg-gradient-success px-3 rounded-pill">Delivered</span>';
                                        break;
                                    case 5:
                                        echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Cancelled</span>';
                                        break;
                                    default:
                                        echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">N/A</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-flat border btn-light btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>" data-code="<?= $row['code'] ?>">
                                        <span class="fa fa-eye text-dark"></span> View
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
</div>

<script>
    $(function() {
        $('.view_data').click(function() {
            uni_modal("View Order Details - <b>" + ($(this).attr('data-code')) + "</b>", "orders/view_order.php?id=" + $(this).attr('data-id'), 'mid-large');
        });
        $('table').dataTable();
    });
</script>
