<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM comparison_tables WHERE id=$id");
}

header("Location: comparisons.php");
exit();
?>
