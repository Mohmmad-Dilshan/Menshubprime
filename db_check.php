<?php
include 'config/db.php';
$res = mysqli_query($conn, "DESCRIBE products");
while($r = mysqli_fetch_assoc($res)) {
    echo $r['Field'] . " (" . $r['Type'] . ")\n";
}
?>
