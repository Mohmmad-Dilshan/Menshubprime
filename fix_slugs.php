<?php
include 'config/db.php';
$q = mysqli_query($conn, "SELECT id, title FROM products WHERE slug = '' OR slug IS NULL");
$count = 0;
while($row = mysqli_fetch_assoc($q)) {
    $id = $row['id'];
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['title']), '-'));
    mysqli_query($conn, "UPDATE products SET slug = '$slug' WHERE id = $id");
    $count++;
}
echo "Fixed $count products with missing slugs.";
?>
