<?php
session_start();
include './Connection.php';
include_once './navebar/topnavbar.php';
include_once './navebar/leftnavbar.php';

$pdo = Database::connect();
$id = $_SESSION['id'];
$sql = "SELECT * FROM order_p where customer_id=$id and rowstatus=1 ";
$q = $pdo->prepare($sql);
$q->execute();
$s = 0;
?>
<div  style=" padding-top: 5%;padding-right: 5%;margin-left: 14%;"> 
    <a class="btn btn-hover btn-lg btn-default" href="leftnavbar.php"  data-toggle="modal" data-target="#basicModal">Add Order</a>
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Order</h4>
                </div>
                <div class="modal-body">
                    <h3>You are sure to generate an order.</h3>
                </div>
                <div class="modal-footer">
                    <a href="generateorder.php" type="button"  class="btn btn-primary" name="ordergenerate">Yes</a>
                    <a href="dashboard.php" type="button" class="btn btn-default" data-dismiss="modal">No</a>

                </div>
            </div>
        </div>
    </div>


    <div id="wrapper">

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>Order Date</th>
                                        <th>Required Date</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($pdo->query($sql) as $row) {
                                        echo '<tr >';
                                        echo '<td>' . ++$s . PHP_EOL . '</td>';
                                        echo '<td>' . $row['orderdate'] . '</td>';
                                        echo '<td>' . $row['requiredDate'] . '</td>';
                                        echo '<td>Panding</td>';
                                        echo '<td>'
                                        . '<a href="DeleteOrder.php?orderNo=' . $row['orderNo'] . '" name="DeleteOrder"  class="btn btn-primary a-btn-slide-text" aria-label="Close"> '
                                        . '<span aria-hidden="true">Delete</span>'
                                        . '</a>   '
                                        . '<a href="additems.php?orderNo=' . $row['orderNo'] . '" name="OrderItems"  class="btn btn-primary a-btn-slide-text" aria-label="Close"> '
                                        . '<span aria-hidden="true">Add Items</span>'
                                        . '</a>'
                                        . '</td>';
                                        echo '</tr>';
                                    }
                                    Database::disconnect();
                                    ?>				'		
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>NO.</th>
                                        <th>Order Date</th>
                                        <th>Required Date</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php
    include './navebar/footnavbar.php';
    ?>

</div>
</body>

</html>
