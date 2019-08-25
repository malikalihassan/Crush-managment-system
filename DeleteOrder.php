<?php

require 'Connection.php';

//session_start();

if (!empty($_GET['orderNo'])) {
    $orderid = $_GET['orderNo'];
    echo $orderid;
    
    // delete data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE order_p SET rowstatus=0 WHERE orderNo=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($orderid));
    Database::disconnect();
     header("Location: customerorder.php");
} else
    {
    echo 'Not Delete';
    }
?>
