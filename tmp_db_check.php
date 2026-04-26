<?php
$conn = mysqli_connect("localhost", "root", "", "menshubprime");
$res = mysqli_query($conn, "SHOW TABLES");
while($row = mysqli_fetch_array($res)) {
  echo $row[0] . "\n";
}
unlink(__FILE__);
?>
