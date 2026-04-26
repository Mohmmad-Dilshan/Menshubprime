<?php
include 'config/db.php';

mysqli_query($conn, "DROP TABLE IF EXISTS comparison_tables");

$sql = "
CREATE TABLE comparison_tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    p1_id INT,
    p1_label VARCHAR(50) DEFAULT 'Best Overall',
    p2_id INT,
    p2_label VARCHAR(50) DEFAULT 'Best Budget',
    p3_id INT,
    p3_label VARCHAR(50) DEFAULT 'Premium Pick',
    comparison_data TEXT, 
    status VARCHAR(10) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

if(mysqli_query($conn, $sql)){
    echo "Comparison tables table re-created successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
