<?php
include 'config/db.php';

$q1 = "ALTER TABLE digital_products ADD COLUMN old_price VARCHAR(50) DEFAULT NULL AFTER price;";

if (mysqli_query($conn, $q1)) {
    echo "SUCCESS: Column old_price added successfully.\\n";
} else {
    echo "ERROR: " . mysqli_error($conn) . "\\n";
}
?>
