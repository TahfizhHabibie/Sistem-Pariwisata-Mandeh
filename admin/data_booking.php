<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/koneksi.php';

// Proses verifikasi (opsional)
if (isset($_GET['verifikasi']) && is_numeric($_GET['verifikasi'])) {
    $id = intval($_GET['verifikasi']);
    mysqli_query($conn, "UPDATE habibi_bookings SET status = 'terverifikasi' WHERE id_booking = $id");
    echo "<script>alert('Pemesanan telah diverifikasi.'); window.location='data_booking.php';</script>";
    exit();
}

// Ambil data booking
$query = mysqli_query($conn, "SELECT b.*, u.nama, p.nama_paket 
                              FROM habibi_bookings b 
                              JOIN habibi_users u ON b.id_user = u.id_user 
                              JOIN habibi_packages p ON b.id_package = p.id_package 
                              ORDER BY b.id_booking DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Booking - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .table thead {
            background: linear-gradient(90deg, #212529, #343a40);
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .badge {
            font-size: 0.9rem;
            padding: 6px 10px;
        }
        .btn-sm {
            font-size: 0.85rem;
        }
        .shadow-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i> Admin Panel</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="shadow-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-primary"><i class="bi bi-card-checklist"></i> Data Pemesanan Paket Wisata</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Nama Paket</th>
                        <th>Tanggal Berangkat</th>
                        <th>Jumlah Orang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['nama_paket']); ?></td>
                        <td><?= $row['tanggal_booking']; ?></td>
                        <td><span class="badge bg-info text-dark"><?= $row['jumlah_orang']; ?> orang</span></td>
                        <td>
                            <?php if ($row['status'] === 'terverifikasi') : ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Terverifikasi</span>
                            <?php else : ?>
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock-fill"></i> Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] !== 'terverifikasi') : ?>
                                <a href="data_booking.php?verifikasi=<?= $row['id_booking']; ?>" class="btn btn-success btn-sm">
                                    <i class="bi bi-check2-square"></i> Verifikasi
                                </a>
                            <?php else : ?>
                                <button class="btn btn-secondary btn-sm" disabled><i class="bi bi-check2-all"></i> Selesai</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
