<?php
include 'config/db.php';

if(isset($_POST['email'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // check duplicate
    $check = mysqli_query($conn, "SELECT id FROM subscribers WHERE email='$email'");

    if(mysqli_num_rows($check) == 0){
        mysqli_query($conn, "INSERT INTO subscribers(email) VALUES('$email')");

        // AUTO-WELCOME SYSTEM
        $to = $email;
        $subject = "Welcome to the MensHub Prime Club! 🔥";
        $headers = "From: MensHub Prime Newsletter <newsletter@menshubprime.com>\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $body = "
        <html>
        <body style='font-family: Arial, sans-serif; background: #0f172a; padding: 40px;'>
            <div style='max-width: 600px; margin: auto; background: #ffffff; border-radius: 25px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.3);'>
                <div style='background: linear-gradient(135deg, #3b82f6, #2563eb); padding: 40px; text-align: center;'>
                    <h1 style='color: #fff; margin: 0; font-size: 28px;'>Welcome to the <br>Prime Club!</h1>
                </div>
                <div style='padding: 40px; color: #1e293b; text-align: center;'>
                    <p style='font-size: 16px; line-height: 1.6;'>You've just unlocked access to elite men's style, tech deals, and grooming secrets.</p>
                    <div style='margin: 30px 0;'>
                        <a href='http://localhost/Menshubprime/' style='background: #3b82f6; color: #fff; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: bold;'>Start Exploring</a>
                    </div>
                    <p style='font-size: 12px; color: #94a3b8;'>Wait for our weekly intelligence report on your inbox.</p>
                </div>
            </div>
        </body>
        </html>";

        @mail($to, $subject, $body, $headers);
    }
}

header("Location: index.php");
exit();
?>