<?php
include 'config/db.php';
$result = mysqli_query($conn, "DESCRIBE pod_variants");
while($row = mysqli_fetch_array($result)) {
    print_r($row);
}
?>
