<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/koneksi.php';

// Hapus paket jika diminta
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    // Hapus dulu semua booking yang berkaitan dengan paket ini
    mysqli_query($conn, "DELETE FROM habibi_bookings WHERE id_package = $id");

    // Baru hapus data paket
    $delete = mysqli_query($conn, "DELETE FROM habibi_packages WHERE id_package = $id");

    if ($delete) {
        echo "<script>alert('Paket berhasil dihapus!'); window.location='data_paket.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus paket!'); window.location='data_paket.php';</script>";
    }
    exit();
}

// Ambil data paket beserta destinasi-nya
$query = mysqli_query($conn, "SELECT p.*, d.nama_tempat 
                              FROM habibi_packages p 
                              JOIN habibi_destinations d ON p.id_destination = d.id_destination");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Paket Wisata - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background: linear-gradient(45deg, #0d6efd, #3a86ff);
            border: none;
        }

        .btn-warning, .btn-danger {
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .btn-warning:hover {
            background-color: #ffcd39;
        }

        .btn-danger:hover {
            background-color: #dc3545;
        }

        .table thead {
            background: linear-gradient(90deg, #343a40, #495057);
            color: #fff;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .text-small {
            font-size: 0.9em;
        }

        .shadow-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
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
            <h4 class="text-primary"><i class="bi bi-box-seam"></i> Data Paket Wisata</h4>
            <a href="form_tambah_paket.php" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Paket
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Destinasi</th>
                        <th>Durasi</th>
                        <th>Harga</th>
                        <th>Fasilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="text-start"><?= htmlspecialchars($row['nama_paket']); ?></td>
                        <td><?= htmlspecialchars($row['nama_tempat']); ?></td>
                        <td><span class="badge bg-info text-dark"><?= $row['durasi_hari']; ?> hari</span></td>
                        <td><strong>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></strong></td>
                        <td class="text-small text-start"><?= htmlspecialchars(substr($row['fasilitas'], 0, 60)); ?>...</td>
                        <td>
                            <a href="form_edit_paket.php?id=<?= $row['id_package']; ?>" class="btn btn-warning btn-sm me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="data_paket.php?hapus=<?= $row['id_package']; ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus paket ini?')">
                               <i class="bi bi-trash"></i> Hapus
                            </a>
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
