<?php
session_start();
include './Connection.php';
include_once './navebar/topnavbar.php';
include_once './navebar/leftnavbar.php';
include_once './common.php';

$orderNumber = $_GET['orderNo'];
$pdo = Database::connect();

if (isset($_POST['addItembtn'])) {

    $productid = $_POST['productname'];
    $prodquan = $_POST['quantity'];
    $orderno = $_POST['orderNo'];
    $probuyprice = $_POST['probuyprice'];
    $userId = getUserID();
    $rowstatus = getRowStatus();
    $itemId = $_POST['txtProductId'];
    if ($itemId != "ItemIDValue") {
        // Write the Update Data Code Here....

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE orderdetail SET quantityordered=?, updatedby=? WHERE rowstatus=1 AND orderNo=? AND product_id=?";
                
        $q = $pdo->prepare($sql);
        $check = $q->execute(array($prodquan, $userId, $orderno, $itemId));
        Database::disconnect();
        if($check){
            echo "Data Updated";
        }else{
            echo "Data Not Updated";
        }
        
        header("Location: additems.php?orderNo=$orderNumber");
    } else {

        echo $probuyprice . ":" . $productid . " : " . $prodquan . ":" . $orderno . ":" . $userId . ":" . $rowstatus;

        $sql = "INSERT INTO orderdetail(priceeach, quantityordered, createdby, updatedby, rowstatus, product_id, orderNo) VALUES(?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $check = $q->execute(array($probuyprice, $prodquan, $userId, $userId, $rowstatus, $productid, $orderno));
        if ($check) {
            header("Location: additems.php?orderNo=$orderNumber");
        } else {
            echo "Data Not Inserted";
        }
    }
} else {
    
}



$id = $_SESSION['id'];
$sql = "SELECT product_id, name, buyprice FROM product ";
$q = $pdo->prepare($sql);
$q->execute();
?>

<div  style=" padding-top: 5%;padding-right: 5%;margin-left: 14%;"> 

    <a class="btnAddItem btn btn-hover btn-lg btn-default" href="leftnavbar.php"  data-toggle="modal" data-target="#addItemy">Add Order Item</a>
    <div class="modal fade" id="addItemy" tabindex="-1" role="dialog" aria-labelledby="addItemy" aria-hidden="true">
        <form method="post" action="additems.php?orderNo=<?php echo $orderNumber; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="OrderItemLabel modal-title" id="OrderItemLabel">Order Item</h4>
                    </div>

                    <div class="modal-body" >
                        <div class="form-group">
                            <label >Product</label>
                            <select class="form-control" id="droProductId"  name="productname">
<?php
foreach ($pdo->query($sql) as $row) {
    echo '<br>';
    echo '<option value="' . $row['product_id'] . '" >' . $row['name'] . '</option>';
}
?>			       
                            </select>
                            <label for="sel1">Quantity</label><br>

                            <input class="txtorderQuan form-control" type="text" name="quantity" value="" placeholder="e.g 3000 Cft" >
                            <br>
                        </div>	
                    </div>

                    <input class="hidden form-control" name="orderNo" type="text" value="<?php echo $orderNumber; ?>" name="" placeholder="" >
                    <input class="hidden form-control" name="probuyprice" type="text" value="<?php echo $row['buyprice']; ?>" name="" placeholder="" >
                    <input class="txtProductId hidden form-control" name="txtProductId" id="txtProductId" type="text" value="<?php echo $_GET['productID']; ?>" name="" placeholder="" >

                    <div class="modal-footer">
                        <button type="submit" name="addItembtn" type="button"  class="btn btn-primary" name="ordergenerate">Yes</button>
                        <a href="" type="button" class="btn btn-default" data-dismiss="modal">No</a>
                    </div>
                </div>
        </form>
    </div>
</form>
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
                                    <th class="">
                                        Item Id
                                    </th>
                                    <th>Item Name</th>
                                    <th>Item Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>                                        
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$pdo = Database::connect();
$id = $_SESSION['id'];
$sql = "SELECT "
        . "pro.name as pname, od.priceeach as pprice, pro.product_id as productid, "
        . "od.quantityordered as pquantity, "
        . "(od.priceeach*od.quantityordered) as totalprice "
        . "FROM order_p o "
        . "JOIN orderdetail od ON od.orderNo=o.orderNo "
        . "JOIN product pro ON od.product_id=pro.product_id "
        . "WHERE o.rowstatus=1 AND od.rowstatus=1 "
        . "AND pro.rowstatus=1 AND o.orderNo=" . $_GET['orderNo'];
//echo $sql;
//exit();
$q = $pdo->prepare($sql);
$q->execute();
$s = 0;
foreach ($pdo->query($sql) as $row) {

    echo '<tr >';
    echo '<td>' . ++$s . PHP_EOL . '</td>';
    echo '<td class="ItemCol_ItemID">' . $row['productid'] . '</td>';
    echo '<td>' . $row['pname'] . '</td>';
    echo '<td>' . $row['pprice'] . '</td>';
    echo '<td class="ItemCol_ItemQuan">' . $row['pquantity'] . '</td>';
    echo '<td>' . $row['totalprice'] . '</td>';
    echo '<td>'
    . '<a href="DeleteItemOrder.php?productID=' . $row['productid'] . '&orderId=' . $orderNumber . '" name="DeleteOrder"  class="btn btn-danger a-btn-slide-text"> '
    . '<span aria-hidden="true">Delete</span>'
    . '</a>  '
    . '<button type="button" class="ItemRowEdit btn btn-default" data-toggle="modal" name="ItemRowEditbtn" data-target="#addItemy"> '
    . 'Update'
    . '</button>'
    . '</td>';
    echo '</tr>';
}

Database::disconnect();
?>				'		
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>NO.</th>
                                    <th class="">
                                        Item Id
                                    </th>
                                    <th>Item Name</th>
                                    <th>Item Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>                                        
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
<script src="OrderItem.js" type="text/javascript"></script>
</body>
</html>