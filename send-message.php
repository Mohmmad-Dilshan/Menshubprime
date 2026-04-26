<?php
include 'config/db.php';
include 'includes/seo-head.php';

if(isset($_POST['send'])){

$name = mysqli_real_escape_string($conn,$_POST['name']);
$email = mysqli_real_escape_string($conn,$_POST['email']);
$msg = mysqli_real_escape_string($conn,$_POST['message']);

mysqli_query($conn,"INSERT INTO messages(name,email,message) VALUES('$name','$email','$msg')");

// AUTO-ACKNOWLEDGMENT SYSTEM
$to = $email;
$subject = "Message Received – MensHub Prime Intelligence Hub";
$headers = "From: MensHub Prime Support <support@menshubprime.com>\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$body = "
<html>
<body style='font-family: Arial, sans-serif; background: #f4f7f6; padding: 20px;'>
    <div style='max-width: 600px; margin: auto; background: #ffffff; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);'>
        <div style='background: #0f172a; padding: 25px; text-align: center; color: #fff;'>
            <h1 style='margin: 0; color: #3b82f6;'>MensHub <span style='color: #fff;'>Prime</span></h1>
        </div>
        <div style='padding: 30px; color: #333;'>
            <h2 style='color: #0f172a;'>Hi $name,</h2>
            <p>Thank you for reaching out to us! We've received your inquiry and our **Neural Intelligence Nodes** are already processing it.</p>
            <div style='background: #f1f5f9; padding: 15px; border-left: 4px solid #3b82f6; font-style: italic;'>
                \"$msg\"
            </div>
            <p style='margin-top: 20px;'>One of our lifestyle consultants will get back to you within 24 hours.</p>
            <p>Stay Classy,<br><strong>Team MensHub Prime</strong></p>
        </div>
    </div>
</body>
</html>";

@mail($to, $subject, $body, $headers);

echo "<script>alert('Intelligence Node Secured. Your message is on our radar!');window.location='index.php'</script>";
}
?>
