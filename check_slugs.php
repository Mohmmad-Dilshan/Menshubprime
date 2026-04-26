<?php
include 'config/db.php';
$q = mysqli_query($conn, "SELECT id, title, slug FROM products ORDER BY id DESC LIMIT 5");
while($row = mysqli_fetch_assoc($q)) {
    echo "ID: " . $row['id'] . " | Title: " . $row['title'] . " | Slug: [" . $row['slug'] . "]\n";
}
?>
