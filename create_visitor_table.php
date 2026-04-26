<?php
include 'config/db.php';
$sql = "CREATE TABLE IF NOT EXISTS visitor_stats (
    visit_date DATE PRIMARY KEY,
    hit_count INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if(mysqli_query($conn, $sql)){
    echo "Table visitor_stats created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?>
