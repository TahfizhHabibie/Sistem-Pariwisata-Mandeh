<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/koneksi.php';

$jumlah_users = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM habibi_users WHERE role = 'user'"))[0];
$jumlah_destinasi = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM habibi_destinations"))[0];
$jumlah_paket = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM habibi_packages"))[0];
$jumlah_booking = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM habibi_bookings"))[0];
$jumlah_review = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM habibi_reviews"))[0];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Sistem Pariwisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
        }
        .card {
            border-radius: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }
        .icon-box {
            font-size: 40px;
            animation: pulse 2s infinite;
        }
        .card-title {
            font-weight: bold;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .greeting-box {
            padding: 20px;
            border-radius: 12px;
            background: linear-gradient(to right, #007bff, #00c6ff);
            color: white;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
        <div class="ms-auto">
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <!-- Greeting Box -->
    <div class="greeting-box text-center">
        <h4>Halo, <strong><?= $_SESSION['nama']; ?></strong> 👋</h4>
        <p id="waktu">Memuat waktu...</p>
    </div>

    <!-- Cards -->
    <div class="row g-4">
        <div class="col-md-4">
            <a href="data_users.php" class="text-decoration-none text-dark">
                <div class="card bg-gradient-primary text-white bg-primary">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-people-fill icon-box me-4"></i>
                        <div>
                            <h5 class="card-title">Total User</h5>
                            <span class="badge bg-light text-dark fs-5"><?= $jumlah_users; ?> Pengguna</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="data_destinasi.php" class="text-decoration-none text-dark">
                <div class="card bg-success text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-geo-alt-fill icon-box me-4"></i>
                        <div>
                            <h5 class="card-title">Total Destinasi</h5>
                            <span class="badge bg-light text-dark fs-5"><?= $jumlah_destinasi; ?> Tempat</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="data_paket.php" class="text-decoration-none text-dark">
                <div class="card bg-warning text-dark">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-box-fill icon-box me-4"></i>
                        <div>
                            <h5 class="card-title">Total Paket</h5>
                            <span class="badge bg-dark text-white fs-5"><?= $jumlah_paket; ?> Paket</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="data_booking.php" class="text-decoration-none text-dark">
                <div class="card bg-danger text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-bag-check-fill icon-box me-4"></i>
                        <div>
                            <h5 class="card-title">Total Booking</h5>
                            <span class="badge bg-light text-dark fs-5"><?= $jumlah_booking; ?> Pesanan</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="data_review.php" class="text-decoration-none text-dark">
                <div class="card bg-secondary text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-chat-dots-fill icon-box me-4"></i>
                        <div>
                            <h5 class="card-title">Total Review</h5>
                            <span class="badge bg-light text-dark fs-5"><?= $jumlah_review; ?> Ulasan</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Script Jam -->
<script>
    function updateTime() {
        const now = new Date();
        const options = {
            weekday: 'long', year: 'numeric', month: 'long',
            day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit'
        };
        document.getElementById('waktu').textContent = now.toLocaleDateString('id-ID', options);
    }

    setInterval(updateTime, 1000);
    updateTime();
</script>

</body>
</html>
