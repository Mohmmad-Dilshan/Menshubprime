<?php
include 'config/db.php';
$q = mysqli_query($conn, "DESCRIBE videos");
while($row = mysqli_fetch_assoc($q)) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}
?>
