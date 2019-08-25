<?php

include 'Connection.php';
session_start();
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$rowstatus = 1;
$sql = "INSERT INTO order_p (customer_id,rowstatus) values(?,?)";
$q = $pdo->prepare($sql);
$check = $q->execute(array($_SESSION['id'], $rowstatus));
Database::disconnect();
header("Location: customerorder.php?productID");
?>