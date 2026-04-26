<?php
require_once __DIR__ . '/src/bootstrap.php';
$res = mysqli_query($conn, "SHOW COLUMNS FROM blogs");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " | ";
}
echo "\n--- PRODUCTS ---\n";
$res2 = mysqli_query($conn, "SHOW COLUMNS FROM blog_products");
while($row2 = mysqli_fetch_assoc($res2)) {
    echo $row2['Field'] . " | ";
}
?>
