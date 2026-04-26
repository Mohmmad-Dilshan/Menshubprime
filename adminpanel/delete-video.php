<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header("Location: login.php");
  exit();
}
include '../config/db.php';

$id = $_GET['id'];

$q = mysqli_query($conn,"SELECT * FROM videos WHERE id='$id'");
$row = mysqli_fetch_assoc($q);

unlink("../uploads/videos/".$row['video']);
unlink("../uploads/thumbs/".$row['thumb']);

mysqli_query($conn,"DELETE FROM videos WHERE id='$id'");

header("Location: manage-videos.php");
?>