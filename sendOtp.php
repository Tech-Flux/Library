<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function generateAlphanumericOTP($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $otp;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect with failed status due to invalid email
        header("Location: forgotPassword.php?status=failed&reason=invalid_email");
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        // Generate 8-character alphanumeric OTP
        $otp = generateAlphanumericOTP();

        // Server settings
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'kevinlucasotieno@gmail.com';  // Your email                   
        $mail->Password   = 'utactlkefafflpra';   // Your app password                     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port       = 587;  

        $mail->setFrom('kevinlucasotieno@gmail.com', 'Library Admin');
        $mail->addAddress($email);  

        // Content
        $mail->isHTML(true); 
        $mail->Subject = 'Your Password Reset OTP';
        $mail->Body    = 'Your OTP for password reset is: <b>' . $otp . '</b>';  // Send the OTP
        $mail->AltBody = 'Your OTP for password reset is: ' . $otp;              // Plain text for non-HTML email clients

        $mail->send();

        header("Location: reset.php?status=success");
        exit();
    } catch (Exception $e) {
        // Log the error message (optional) and redirect with failed status
        error_log("OTP Mailer Error: {$mail->ErrorInfo}");
        header("Location: reset.php?status=failed&reason=mailer_error");
        exit();
    }
}
?>
