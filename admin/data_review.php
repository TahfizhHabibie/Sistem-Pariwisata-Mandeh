<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/koneksi.php';

$query = mysqli_query($conn, "
    SELECT r.*, u.nama AS nama_user, d.nama_tempat 
    FROM habibi_reviews r
    JOIN habibi_users u ON r.id_user = u.id_user
    JOIN habibi_destinations d ON r.id_destination = d.id_destination
    ORDER BY r.tanggal_review DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Review - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .shadow-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }
        .table thead {
            background: linear-gradient(90deg, #343a40, #212529);
            color: #fff;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .text-wrap {
            white-space: normal;
        }
        .badge-destinasi {
            background-color: #0d6efd;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i> Admin Panel</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container mt-4">
    <div class="shadow-card">
        <h4 class="mb-4 text-primary"><i class="bi bi-chat-left-text-fill me-2"></i>Data Ulasan Pengguna</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Destinasi</th>
                        <th>Isi Ulasan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_user']); ?></td>
                        <td><span class="badge text-white badge-destinasi"><?= htmlspecialchars($row['nama_tempat']); ?></span></td>
                        <td class="text-wrap"><?= nl2br(htmlspecialchars($row['komentar'])); ?></td>
                        <td class="text-center"><?= $row['tanggal_review']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
