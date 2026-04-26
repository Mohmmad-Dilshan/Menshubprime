<?php
session_start();
include '../config/db.php';
if(!isset($_SESSION['admin_id'])){ header("Location: login.php"); exit(); }

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT banner_image FROM promotional_offers WHERE id='$id'"));
if(!empty($data['banner_image']) && file_exists("../uploads/".$data['banner_image'])){
    unlink("../uploads/".$data['banner_image']);
}

mysqli_query($conn, "DELETE FROM promotional_offers WHERE id='$id'");
echo "<script>alert('Offer deleted'); window.location='promotional-offers.php';</script>";
?>
