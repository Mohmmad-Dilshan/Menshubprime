<?php

$host     = "localhost";
$dbname   = "u305114306_menshubprime";
$username = "u305114306_menshub";
$password = "Khushi@3500";

$conn = mysqli_connect($host, $username, $password, $dbname);

if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}

?>