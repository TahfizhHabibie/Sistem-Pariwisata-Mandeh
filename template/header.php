<?php
// Pastikan session sudah aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Atur default judul jika belum diset
if (!isset($title)) {
    $title = "Sistem Pariwisata";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS jika perlu -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Navigasi -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/index.php">Pariwisata</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="/admin/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/data_users.php">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/data_destinasi.php">Destinasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/data_paket.php">Paket</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/data_booking.php">Booking</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/data_review.php">Review</a></li>
                    <li class="nav-item"><a class="nav-link" href="/auth/logout.php">Logout</a></li>
                <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                    <li class="nav-item"><a class="nav-link" href="/user/index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="/user/paket.php">Paket</a></li>
                    <li class="nav-item"><a class="nav-link" href="/user/destinasi.php">Destinasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="/auth/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/auth/login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/auth/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
