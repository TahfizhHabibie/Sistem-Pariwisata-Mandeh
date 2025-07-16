<?php
// Pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hanya tampilkan jika admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!-- Sidebar Admin -->
<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 250px; height: 100vh; position: fixed;">
    <a href="dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link text-white">🏠 Dashboard</a>
        </li>
        <li>
            <a href="data_users.php" class="nav-link text-white">👤 Data Users</a>
        </li>
        <li>
            <a href="data_destinasi.php" class="nav-link text-white">📍 Data Destinasi</a>
        </li>
        <li>
            <a href="data_paket.php" class="nav-link text-white">🧳 Data Paket</a>
        </li>
        <li>
            <a href="data_booking.php" class="nav-link text-white">📅 Data Booking</a>
        </li>
        <li>
            <a href="data_review.php" class="nav-link text-white">📝 Data Review</a>
        </li>
        <li>
            <a href="../auth/logout.php" class="nav-link text-white">🚪 Logout</a>
        </li>
    </ul>
    <hr>
    <div class="text-white">
        <small>Admin: <?= $_SESSION['nama']; ?></small>
    </div>
</div>
