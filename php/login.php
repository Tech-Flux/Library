<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "../conn.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user data including profile image and ID
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['username'] = $user['first_name'];
            $_SESSION['profile_photo'] = !empty($user['profile_photo']) ? '../assets/uploads/' . $user['profile_photo'] : '../assets/user.png'; // Ensure the image path is correct

            // Redirect to admin panel
            header("Location: ../admin/index.php");
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>
