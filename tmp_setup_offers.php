<?php
include 'config/db.php';

// 1. Create table
$sql1 = "CREATE TABLE IF NOT EXISTS promotional_offers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  subtitle VARCHAR(255) NOT NULL,
  button_text VARCHAR(255) NOT NULL,
  button_link VARCHAR(255) NOT NULL,
  banner_image VARCHAR(255) NOT NULL,
  status INT DEFAULT 1
)";
mysqli_query($conn, $sql1);

// 2. Update settings table
$sql2 = "SHOW COLUMNS FROM settings LIKE 'show_promotional_offers'";
$res = mysqli_query($conn, $sql2);
if(mysqli_num_rows($res) == 0){
    mysqli_query($conn, "ALTER TABLE settings ADD COLUMN show_promotional_offers INT DEFAULT 1");
}

echo "Database updated successfully.";
?>
