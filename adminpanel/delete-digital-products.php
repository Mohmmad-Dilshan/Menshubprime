<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header("Location: login.php");
  exit();
}
include '../config/db.php';

$id = $_GET['id'];

// Pehle image nikaal lo
$q = mysqli_query($conn,"SELECT image FROM digital_products WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

$image = $data['image'];

// Image delete from folder
if(file_exists("../uploads/digital_products/".$image)){
    unlink("../uploads/digital_products/".$image);
}

// Record delete from DB
mysqli_query($conn,"DELETE FROM digital_products WHERE id='$id'");

header("Location: manage-digital-products.php");
exit;
?>