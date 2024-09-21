<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: ../login.php");
        exit();
    }

    $userId = $_SESSION['user_id']; 
    $firstName = $_SESSION['username'];
    $profileImage = isset($_SESSION['profile_photo']) ? $_SESSION['profile_photo'] : '../assets/user.png';
    ?>
</head>
<body>

<!-- SweetAlert JS (Added here so it loads after the page content) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: `Welcome <?php echo $firstName; ?>`,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        });
    </script>
<?php endif; ?>


<nav class="navbar bg-body-tertiary">
  <div class="container-fluid justify-content-center nav-bar-bg"> <!-- Centered navbar content -->
    <a class="navbar-brand" href="#">
      <i class="bi bi-book"></i> Library <!-- Added icon -->
    </a>
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-primary" type="submit">Search</button>
    </form>
  </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="profile-section">
        <img src="<?php echo $profileImage; ?>" alt="User Photo" id="profilePhoto">
    </div>

    <!-- Sidebar Links -->
    <a href="#" class="nav-link">
        <i class="bi bi-house-door"></i> <span>Dashboard</span>
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-book"></i> <span>Manage Books</span>
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-people"></i> <span>Manage Users</span>
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-journal"></i> <span>View Reports</span>
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-chat-dots"></i> <span>Messages</span>
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-clock-history"></i> <span>History</span>
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-wallet2"></i> <span>Payments</span>
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-gear"></i> <span>Settings</span>
    </a>
</div>

<!-- Profile Dropdown Menu -->
<div class="profile-dropdown-menu" id="profileDropdownMenu">
    <i class="bi bi-x-square-fill close-btn" id="closeProfileDialog"></i> 
    <a href="#"><i class="bi bi-person"></i><span>Account Settings</span></a>
    <a href="#"><i class="bi bi-shield-lock"></i><span>Change Password</span></a>
    <a href="#"><i class="bi bi-envelope"></i><span>Messages</span></a>
    <a href="../php/logout.php"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a>
</div>

<!-- Sidebar Toggle Button -->
<div class="sidebar-toggle" id="sidebarToggle">
    <i class="bi bi-arrow-left-circle" id="sidebarToggleIcon" style="font-size: 1.5rem; color: blue;"></i>
</div>

<!-- Content -->
<div class="content" id="content">
    <h1>Welcome to the Admin Panel</h1>
    <p>Manage the library system efficiently.</p>
</div>

<!-- JS for sidebar toggling -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var sidebar = document.getElementById('sidebar');
        var sidebarToggle = document.getElementById('sidebarToggle');
        var sidebarToggleIcon = document.getElementById('sidebarToggleIcon');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('hidden');
            if (sidebar.classList.contains('hidden')) {
                sidebarToggleIcon.classList.replace('bi-arrow-left-circle', 'bi-arrow-right-circle');
            } else {
                sidebarToggleIcon.classList.replace('bi-arrow-right-circle', 'bi-arrow-left-circle');
            }
        });
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/admin.js"></script>

</body>
</html>
