<?php
include 'config/db.php';
$tables = ['blogs', 'sponsors'];
foreach($tables as $t){
    echo "\nTable: $t\n";
    $q = mysqli_query($conn, "DESCRIBE $t");
    while($row = mysqli_fetch_assoc($q)) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
}
?>
