const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');
const profilePhoto = document.getElementById('profilePhoto');
const profileDropdownMenu = document.getElementById('profileDropdownMenu');
const closeProfileDialog = document.getElementById('closeProfileDialog');

// Toggle Sidebar
sidebarToggle.addEventListener('click', function () {
    sidebar.classList.toggle('hidden');
    if (sidebar.classList.contains('hidden')) {
        sidebarToggleIcon.classList.replace('bi-arrow-left-circle', 'bi-arrow-right-circle');
    } else {
        sidebarToggleIcon.classList.replace('bi-arrow-right-circle', 'bi-arrow-left-circle');
    }
});

// Show profile dropdown menu on profile image click
profilePhoto.addEventListener('click', function () {
    profileDropdownMenu.style.display = 'block';
});

// Close dropdown when clicking outside or pressing X
document.addEventListener('click', function (event) {
    if (!profilePhoto.contains(event.target) && !profileDropdownMenu.contains(event.target)) {
        profileDropdownMenu.style.display = 'none';
    }
});

// Close dropdown when pressing X
closeProfileDialog.addEventListener('click', function () {
    profileDropdownMenu.style.display = 'none';
});