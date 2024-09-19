<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../conn.php');
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create the 'users' table if it doesn't exist
$table_creation_sql = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    profile_photo VARCHAR(255),
    otp VARCHAR(8),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($table_creation_sql) === FALSE) {
    $_SESSION['error_message'] = "Error creating table: " . $conn->error;
    header("Location: ../signup.php?status=failed&reason=Error Creating table");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $age = (int)$_POST['age'];

    // Handle profile photo upload
    $profile_photo = $_FILES['profile_photo']['name'];
    $profile_photo_tmp = $_FILES['profile_photo']['tmp_name'];
    $profile_photo_size = $_FILES['profile_photo']['size'];

    // Maximum file size (100 KB)
    $max_file_size = 100 * 1024; // 100 KB in bytes

    // Validate password match
    if ($password !== $repeat_password) {
        $_SESSION['error_message'] = "Passwords do not match.";
        header('Location: ../signup.php');
        exit();
    }

    // Validate profile photo size
    if ($profile_photo_size > 0 && $profile_photo_size > $max_file_size) {
        $_SESSION['error_message'] = "Profile photo size should not exceed 100 KB.";
        header('Location: ../signup.php');
        exit();
    }

    // Check if email already exists
    $check_email_sql = "SELECT email FROM users WHERE email = '$email'";
    $result = $conn->query($check_email_sql);
    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Email already exists.";
        header('Location: ../signup.php');
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate and store OTP
    $otp = mt_rand(10000000, 99999999);

    // Handle file upload
    if (!empty($profile_photo)) {
        $upload_dir = "../assets/uploads/";
        $file_extension = pathinfo($profile_photo, PATHINFO_EXTENSION);
        $random_file_name = uniqid() . "." . $file_extension;
        $profile_photo_path = $upload_dir . $random_file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (!move_uploaded_file($profile_photo_tmp, $profile_photo_path)) {
            $_SESSION['error_message'] = "Failed to upload profile photo.";
            header('Location: ../signup.php');
            exit();
        }
    } else {
        $random_file_name = NULL; // No profile photo uploaded
    }

    // Insert user into the database
    $sql = "INSERT INTO users (first_name, last_name, email, phone_number, password, age, profile_photo, otp) 
            VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$hashed_password', $age, '$random_file_name', '$otp')";

    if ($conn->query($sql) === TRUE) {
        // Send OTP email
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'kevinlucasotieno@gmail.com';
            $mail->Password   = 'utactlkefafflpra';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Sender and recipient settings
            $mail->setFrom('kevinlucasotieno@gmail.com', 'Library Admin');
            $mail->addAddress($email);    // Add recipient

            // Content
            $mail->isHTML(true); 
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = 'Your OTP code is: <b>' . $otp . '</b>'; // Send the OTP in bold
            $mail->AltBody = 'Your OTP code is: ' . $otp;             // Plain text for non-HTML email clients

            $mail->send();
            $_SESSION['success_message'] = "Registration successful! Check your email for the OTP.";
            header("Location: ../signup.php?status=success");
            exit();
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error sending OTP: " . $mail->ErrorInfo;
            header('Location: ../signup.php');
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Error: " . $conn->error;
        header('Location: ../signup.php');
        exit();
    }
}

$conn->close();
?>
