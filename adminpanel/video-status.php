<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header("Location: login.php");
  exit();
}
include '../config/db.php';

$id = $_GET['id'];

$q = mysqli_query($conn,"SELECT status FROM videos WHERE id='$id'");
$row = mysqli_fetch_assoc($q);

if($row['status']=="active"){
  mysqli_query($conn,"UPDATE videos SET status='inactive' WHERE id='$id'");
}else{
  mysqli_query($conn,"UPDATE videos SET status='active' WHERE id='$id'");
}

header("Location: manage-videos.php");
?>