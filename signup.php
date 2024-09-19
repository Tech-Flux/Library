
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
    <link rel="stylesheet" href="css/signup.css">

</head>
<body>

<div class="container form-center">
    <div class="col-md-8">
        <div class="form-container">
            
            <div class="logo">
                <i class="bi bi-book"></i> Library
            </div>

            <?php
            session_start(); 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            if (isset($_SESSION['success_message'])) {
                echo "<div class='alert alert-success' role='alert'>" . $_SESSION['success_message'] . "</div>";
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['error_message'])) {
                echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['error_message'] . "</div>";
                unset($_SESSION['error_message']);
            }
            ?>

            <form class="row g-3 needs-validation" novalidate action="php/register.php" method="POST" enctype="multipart/form-data">
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

<script src="js/signup.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
