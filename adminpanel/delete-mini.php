<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header("Location: login.php");
  exit();
}
include '../config/db.php';

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM mini_products WHERE id='$id'");

header("location:mini-products.php");
?>
