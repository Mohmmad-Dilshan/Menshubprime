<?php
include 'config/db.php';
$q = mysqli_query($conn, 'DESCRIBE products');
while($row = mysqli_fetch_assoc($q)) {
    echo $row['Field'] . ' - ' . $row['Type'] . PHP_EOL;
}
?>
