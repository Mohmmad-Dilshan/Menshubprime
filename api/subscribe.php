<?php

// Professional Subscriber Handler
require_once __DIR__ . '/../src/bootstrap.php';

if(isset($_POST['email'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // check duplicate
    $check = mysqli_query($conn, "SELECT id FROM subscribers WHERE email='$email'");

    if(mysqli_num_rows($check) == 0){
        mysqli_query($conn, "INSERT INTO subscribers(email) VALUES('$email')");
    }

}

// Redirect back to home via clean URL
header("Location: ../home");
exit();
