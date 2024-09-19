<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        header("Location: reset.php?status=failed&reason=invalid_email");
        exit();
    }

    // Check if the email exists in the database
    $email_check_sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($email_check_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        // Email not found in the database
        $stmt->close();
        $conn->close();
        header("Location: reset.php?status=failed&reason=email_not_found");
        exit();
    }

    // Generate 8-character alphanumeric OTP
    $otp = generateAlphanumericOTP();

    // Update or insert OTP into the database
    $update_otp_sql = "UPDATE users SET otp = ? WHERE email = ?";
    $stmt = $conn->prepare($update_otp_sql);
    $stmt->bind_param("ss", $otp, $email);

    if ($stmt->execute() === FALSE) {
        // Handle error in updating OTP
        $stmt->close();
        $conn->close();
        header("Location: reset.php?status=failed&reason=update_otp_error");
        exit();
    }

    // Send OTP email
    $mail = new PHPMailer(true);

    try {
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

        // Close connections
        $stmt->close();
        $conn->close();

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
