<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header("Location: login.php");
  exit();
}
include '../config/db.php';

$id = $_GET['id'];

$q = mysqli_query($conn,"SELECT status FROM digital_products WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if($data['status'] == "active"){
    mysqli_query($conn,"UPDATE digital_products SET status='inactive' WHERE id='$id'");
}else{
    mysqli_query($conn,"UPDATE digital_products SET status='active' WHERE id='$id'");
}

header("Location: manage-digital-products.php");
exit;
?>