<?php
include 'config/db.php';

$queries = [
    "ALTER TABLE products ADD COLUMN status VARCHAR(10) DEFAULT 'active' AFTER video_url",
    "ALTER TABLE mini_products ADD COLUMN status VARCHAR(10) DEFAULT 'active' AFTER link",
    "ALTER TABLE categories ADD COLUMN status VARCHAR(10) DEFAULT 'active' AFTER image"
];

foreach($queries as $q){
    if(mysqli_query($conn, $q)){
        echo "Query successful: $q\n";
    } else {
        echo "Error: " . mysqli_error($conn) . "\n";
    }
}
?>
