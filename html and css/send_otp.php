<?php 
    if(isset($_POST['email']) && isset($_POST['otp'])) {
        require 'PHPMailerAutoload.php';
        require 'credential.php';

        $mail = new PHPMailer;

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'mail.dramran.com';
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL;
        $mail->Password = PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email settings
        $mail->setFrom(EMAIL, 'Web Group 23');
        $mail->addAddress($_POST['email']); // Retrieve email address from POST data
        $mail->addReplyTo(EMAIL);
        $mail->isHTML(true);

        // Email content
        $otp = $_POST['otp']; // Retrieve OTP from POST data
        $mail->Subject = 'Your OTP for Verification';
        $mail->Body = '<div style="border:2px solid red;">Your OTP for email verification is: <strong>' . $otp . '</strong>. Please use this OTP to proceed with your verification. This OTP only valid for 2 minutes!</div>';
        $mail->AltBody = 'Your OTP for email verification is: ' . $otp . '. Please use this OTP to proceed with your verification.';

        // Send email
        if(!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
?>