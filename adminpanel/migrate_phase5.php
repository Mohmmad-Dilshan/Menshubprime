<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    die("Unauthorized access.");
}
include '../config/db.php';

// 1. Create stores table
$sql_stores = "CREATE TABLE IF NOT EXISTS stores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    icon VARCHAR(100) DEFAULT 'fas fa-store',
    color VARCHAR(20) DEFAULT '#f97316',
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql_stores)) {
    echo "Table 'stores' ready.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// 2. Add store_id to products table
$check_col = mysqli_query($conn, "SHOW COLUMNS FROM products LIKE 'store_id'");
if (mysqli_num_rows($check_col) == 0) {
    if (mysqli_query($conn, "ALTER TABLE products ADD COLUMN store_id INT DEFAULT NULL")) {
        echo "Column 'store_id' added to products.<br>";
    } else {
        echo "Error adding column: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "Column 'store_id' already exists.<br>";
}

// 3. Insert default stores
$default_stores = [
    ['Amazon', 'amazon', 'fab fa-amazon', '#ff9900'],
    ['Flipkart', 'flipkart', 'fas fa-shopping-cart', '#2874f0'],
    ['Myntra', 'myntra', 'fas fa-shopping-bag', '#ff3f6c'],
    ['Ajio', 'ajio', 'fas fa-tshirt', '#0f172a']
];

foreach ($default_stores as $s) {
    $name = $s[0]; $slug = $s[1]; $icon = $s[2]; $color = $s[3];
    $check_exists = mysqli_query($conn, "SELECT id FROM stores WHERE slug = '$slug'");
    if (mysqli_num_rows($check_exists) == 0) {
        mysqli_query($conn, "INSERT INTO stores (name, slug, icon, color) VALUES ('$name', '$slug', '$icon', '$color')");
        echo "Inserted default store: $name <br>";
    }
}

echo "Migration complete!";
?>
