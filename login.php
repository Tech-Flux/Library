<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library</title>
    <link rel="icon" type="image/x-icon" href="/assets/fav.ico">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        /* Custom styling for the navbar */
        .navbar-custom {
            background-color: #0d47a1; /* Dark blue background */
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .form-control {
            color: #ffffff; /* White text */
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .navbar-brand:hover {
            color: #ffeb3b; /* Yellow hover effect */
        }

        .navbar-custom .form-control {
            background-color: #ffffff; /* White search input */
        }

        .navbar-custom .btn-secondary {
            background-color: #ffeb3b; /* Yellow search button */
            color: #000000; /* Black text for button */
        }

        .navbar-custom .btn-secondary:hover {
            background-color: #ffc107; /* Darker yellow on hover */
        }

        /* Center form on the page and add shadow */
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow effect */
        }

        /* Center form */
        .form-center {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Logo styling */
        .logo {
            text-align: center;
            font-size: 40px;
            margin-bottom: 20px;
            color: #0d47a1;
        }

        .logo i {
            margin-right: 10px;
        }

        /* Input with icon styling */
        .input-group-text {
            background-color: #0d47a1;
            color: #ffffff;
            border: 1px solid #0d47a1;
        }

        .form-control {
            border-left: 0;
        }
    </style>
</head>
<body>

<div class="container form-center">
    <div class="col-md-6">
        <div class="form-container"> <!-- Add container with box shadow -->
            
            <!-- Logo with glyphicon -->
            <div class="logo">
                <i class="bi bi-book"></i> Library
            </div>

            <form class="row g-3 needs-validation" novalidate>
                <div class="col-12">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="validationEmail" placeholder="Email" required>
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="validationPassword" placeholder="Password" required>
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please provide your password.
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Log In</button>
                </div>

                <div class="col-12 text-center">
                    <p class="mt-3">Don't have an account? <a href="signup.php">Register here</a></p>
                </div>

                <div class="col-12 text-center">
                    <a href="reset.php">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
