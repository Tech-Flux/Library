<!DOCTYPE html>
<?php ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" type="image/x-icon" href="/assets/fav.ico">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/reset.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container">
    <div class="form-container">
        <!-- Logo -->
        <div class="logo">
            <i class="bi bi-book"></i> Library
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'OTP Sent!',
            text: 'OTP has been sent successfully to your email address.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    </script>
<?php elseif (isset($_GET['status']) && $_GET['status'] == 'failed'): ?>
    <?php
    $reason = isset($_GET['reason']) ? $_GET['reason'] : '';
    $errorMessage = 'Failed to send OTP. Please try again.';
    if ($reason == 'invalid_email') {
        $errorMessage = 'Invalid email address. Please provide a valid one.';
    } elseif ($reason == 'mailer_error') {
        $errorMessage = 'There was an issue sending the email. Please try again later.';
    }
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Failed!',
            text: '<?php echo $errorMessage; ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
        });
    </script>
<?php endif; ?>

        <!-- Forgot Password Form -->
        <h2 class="text-center mb-4">Forgot Your Password?</h2>
        <p class="text-center mb-4">Enter your email address to receive a password reset OTP.</p>
        <form class="needs-validation" action="sendOtp.php" method="POST" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email" required>
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>
            <button class="btn btn-primary w-100" type="submit">Send OTP</button>
        </form>

        <!-- Social Media Links -->
        <div class="social-links">
            <p class="mt-4">Need help? Contact us:</p>
            <a href="https://wa.me/yourphonenumber" target="_blank">
                <i class="bi bi-whatsapp"></i> WhatsApp
            </a>
            <a href="https://t.me/yourusername" target="_blank">
                <i class="bi bi-telegram"></i> Telegram
            </a>
        </div>
    </div>
</div>

<script>
    (() => {
        'use strict'

        const form = document.querySelector('.needs-validation')

        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })()
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</body>
</html>
