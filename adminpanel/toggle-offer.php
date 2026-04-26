<?php
session_start();
include '../config/db.php';
if(!isset($_SESSION['admin_id'])){ header("Location: login.php"); exit(); }

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status FROM promotional_offers WHERE id='$id'"));
$new_status = ($data['status'] == 1) ? 0 : 1;

mysqli_query($conn, "UPDATE promotional_offers SET status='$new_status' WHERE id='$id'");
echo "<script>window.location='promotional-offers.php';</script>";
?>
