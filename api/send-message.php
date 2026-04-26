<?php

// Professional Message Handler
require_once __DIR__ . '/../src/bootstrap.php';

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO messages(name, email, message) VALUES('$name', '$email', '$msg')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Message sent successfully!'); window.location='../contact';</script>";
    } else {
        echo "<script>alert('Error sending message. Please try again.'); window.location='../contact';</script>";
    }
} else {
    header("Location: ../contact");
}
exit();
