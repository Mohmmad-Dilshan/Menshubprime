<?php
include 'config/db.php';
$result = mysqli_query($conn, "SHOW TABLES LIKE 'pod%'");
while($row = mysqli_fetch_array($result)) {
    echo $row[0] . "\n";
}
?>
