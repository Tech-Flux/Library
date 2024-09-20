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
$profileImage = isset($_SESSION['profile_photo']) ? $_SESSION['profile_photo'] : '../assets/user.png';

?>

</head>
<body>

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
        <i class="bi bi-backspace-fill close-btn" id="closeProfileDialog"></i> 
        <a href="#"><i class="bi bi-person"></i><span>Account Settings</span></a>
        <a href="#"><i class="bi bi-shield-lock"></i><span>Change Password</span></a>
        <a href="#"><i class="bi bi-envelope"></i><span>Messages</span></a>
        <a href="../php/logout.php"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a>
        <!-- <a href="#"><i class="bi bi-chat-dots"></i><span>Contact Support</span></a> -->
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

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/admin.js"></script>
</body>
</html> 