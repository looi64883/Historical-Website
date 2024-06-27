<?php 
    if(isset($_POST['email'])) {
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
        $mail->addAddress($_POST['email']); // Email address passed from the game
        $mail->addReplyTo(EMAIL);
        $mail->isHTML(true);
        $mail->addAttachment('prize/1.jpg');

        // Email content
        $mail->Subject = 'Congratulations on Winning the Game!'; // Or use $_POST['subject'] if passed
        $mail->Body = '<div style="border:2px solid red;">You successfully completed our game! To thank you for using our website, this is a little reward we give you!</div>';
        $mail->AltBody = 'You successfully completed our game! To thank you for using our website, this is a little reward we give you!';


        // Send email
        if(!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
?>