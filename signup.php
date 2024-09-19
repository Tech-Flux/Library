<?php
session_start(); 

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('conn.php');

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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($table_creation_sql) === FALSE) {
    $_SESSION['error_message'] = "Error creating table: " . $conn->error;
    header('Location: signup.php');
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
        header('Location: signup.php');
        exit();
    }

    // Validate profile photo size
    if ($profile_photo_size > 0 && $profile_photo_size > $max_file_size) {
        $_SESSION['error_message'] = "Profile photo size should not exceed 100 KB.";
        header('Location: signup.php');
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
            header('Location: signup.php');
            exit();
        }
    } else {
        $random_file_name = NULL;
    }
    $sql = "INSERT INTO users (first_name, last_name, email, phone_number, password, age, profile_photo) 
            VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$hashed_password', $age, '$random_file_name')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Registration successful!";
        header('Location: signup.php');
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $conn->error;
        header('Location: signup.php');
        exit();
    }
}

$conn->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Registration</title>
    <link rel="icon" type="image/x-icon" href="/assets/fav.ico">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        .navbar-custom {
            background-color: #0d47a1;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .form-control {
            color: #ffffff;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .navbar-brand:hover {
            color: #ffeb3b;
        }

        .navbar-custom .form-control {
            background-color: #ffffff;
        }

        .navbar-custom .btn-secondary {
            background-color: #ffeb3b;
            color: #000000;
        }

        .navbar-custom .btn-secondary:hover {
            background-color: #ffc107;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-center {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            text-align: center;
            font-size: 40px;
            margin-bottom: 20px;
            color: #0d47a1;
        }

        .logo i {
            margin-right: 10px;
        }

        .input-group-text {
            background-color: #0d47a1;
            color: #ffffff;
            border: 1px solid #0d47a1;
        }

        .form-control {
            border-left: 0;
        }

        .alert-success, .alert-danger {
            display: none;
        }
    </style>
</head>
<body>

<div class="container form-center">
    <div class="col-md-8">
        <div class="form-container">
            
            <div class="logo">
                <i class="bi bi-book"></i> Library
            </div>

            <?php
            if (isset($_SESSION['success_message'])) {
                echo "<div class='alert alert-success' role='alert'>" . $_SESSION['success_message'] . "</div>";
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['error_message'])) {
                echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['error_message'] . "</div>";
                unset($_SESSION['error_message']);
            }
            ?>

            <form class="row g-3 needs-validation" novalidate action="signup.php" method="POST" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="validationFirstName" class="form-label">First Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="validationFirstName" name="first_name" required>
                    </div>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter your first name.</div>
                </div>

                <div class="col-md-6">
                    <label for="validationLastName" class="form-label">Last Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="validationLastName" name="last_name" required>
                    </div>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter your last name.</div>
                </div>

                <div class="col-md-6">
                    <label for="validationEmail" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="validationEmail" name="email" required>
                    </div>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>

                <div class="col-md-6">
                    <label for="validationPhoneNumber" class="form-label">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="tel" class="form-control" id="validationPhoneNumber" name="phone_number" required>
                    </div>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                </div>

                <div class="col-md-6">
                    <label for="validationPassword" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="validationPassword" name="password" required>
                    </div>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please provide a password.</div>
                </div>

                <div class="col-md-6">
                    <label for="validationRepeatPassword" class="form-label">Repeat Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="validationRepeatPassword" name="repeat_password" required>
                    </div>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please repeat your password.</div>
                </div>

                <div class="col-md-6">
                    <label for="validationAge" class="form-label">Age</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        <input type="number" class="form-control" id="validationAge" name="age" min="12" required>
                    </div>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter your age.</div>
                </div>

                <div class="col-md-6">
                    <label for="validationProfilePhoto" class="form-label">Profile Photo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-camera"></i></span>
                        <input type="file" class="form-control" id="validationProfilePhoto" name="profile_photo" accept="image/*" required>
                    </div>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please upload a profile photo.</div>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                        <label class="form-check-label" for="invalidCheck">
                            Agree to terms and conditions
                        </label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Register</button>
                </div>

                <div class="col-12 text-center">
                    <p class="mt-3">Already have an account? <a href="login.php">Log in here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })

        const successAlert = document.querySelector('.alert-success');
        const errorAlert = document.querySelector('.alert-danger');
        if (successAlert && successAlert.textContent.trim()) {
            successAlert.style.display = 'block';
        }
        if (errorAlert && errorAlert.textContent.trim()) {
            errorAlert.style.display = 'block';
        }
    })()
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
