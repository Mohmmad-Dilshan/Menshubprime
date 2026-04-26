<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header("Location: login.php");
  exit();
}
include '../config/db.php';
$id=$_GET['id'];

$row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT status FROM sponsors WHERE id='$id'"));

$new = ($row['status']=="active") ? "inactive" : "active";

mysqli_query($conn,"UPDATE sponsors SET status='$new' WHERE id='$id'");

header("location:sponsors.php");