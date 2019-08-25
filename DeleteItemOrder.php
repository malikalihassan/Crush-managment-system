<?php

require 'Connection.php';

//session_start();

if (!empty($_GET['orderId'])&&$_GET['productID']) {
    $orderid = $_GET['orderId'];
    echo $orderid;
    $productid = $_GET['productID'];
    echo $productid;
    
    // delete data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE orderdetail SET rowstatus=0 WHERE orderNo=? AND product_id=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($orderid,$productid));
    Database::disconnect();
     header("Location: additems.php?orderNo=$orderid");
} else {
    echo 'Not Delete';
}
?>
