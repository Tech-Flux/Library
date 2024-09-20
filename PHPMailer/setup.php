<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Generate 8-digit OTP
    $otp = mt_rand(10000000, 99999999); // Generate a random 8-digit number

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                 
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'kevinlucasotieno@gmail.com';                    
    $mail->Password   = 'utactlkefafflpra';                            
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
    $mail->Port       = 587;  

    // Sender and recipient settings
    $mail->setFrom('kevinlucasotieno@gmail.com', 'Mailer');
    $mail->addAddress('otienok234@gmail.com', 'Kevin');    // Add recipient

    // Content
    $mail->isHTML(true); 
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = 'Your OTP code is: <b>' . $otp . '</b>'; // Send the OTP in bold
    $mail->AltBody = 'Your OTP code is: ' . $otp;             // Plain text for non-HTML email clients

    $mail->send();
    echo 'OTP has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
