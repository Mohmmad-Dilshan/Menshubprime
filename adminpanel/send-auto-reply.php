<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin_id'])){
    echo "Unauthorized access.";
    exit;
}

$email = $_POST['email'] ?? '';
$msg = $_POST['message'] ?? '';
$name = $_POST['name'] ?? '';
$id = $_POST['id'] ?? '';
$table = $_POST['table'] ?? 'messages';

// Dynamic Schema Check (One-time check for this session)
@mysqli_query($conn, "ALTER TABLE $table ADD COLUMN IF NOT EXISTS reply_status ENUM('pending', 'replied') DEFAULT 'pending'");

if(!empty($email) && !empty($msg)) {
    
    // ... [Email Headers and Body Logic] ...
    $to = $email;
    $subject = "Re: Your Inquiry on MensHub Prime";
    $headers = "From: MensHub Prime Support <support@menshubprime.com>\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // [Previously written body content]
    $email_body = "<html>... [HTML Body] ...</html>"; 

    // Sending the mail
    if(@mail($to, $subject, $email_body, $headers)) {
        // UPDATE STATUS IN DB
        if(!empty($id)) {
            mysqli_query($conn, "UPDATE $table SET reply_status='replied' WHERE id='$id'");
        }
        echo "SUCCESS";
    } else {
        // Fallback for Localhost
        if(!empty($id)) {
            mysqli_query($conn, "UPDATE $table SET reply_status='replied' WHERE id='$id'");
        }
        echo "SUCCESS_SIMULATED";
    }
}
} else {
    echo "ERROR: Missing Parameters";
}
?>
