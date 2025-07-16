<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login_admin.php");
    exit();
}

include '../config/koneksi.php';

// Proses Hapus
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM habibi_destinations WHERE id_destination = $id");
    echo "<script>alert('Destinasi berhasil dihapus!'); window.location='data_destinasi.php';</script>";
    exit();
}

$destinasi = mysqli_query($conn, "SELECT * FROM habibi_destinations ORDER BY id_destination DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Destinasi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f3f6;
        }

        .navbar {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .table thead {
            background: linear-gradient(90deg, #0d6efd, #3b8beb);
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: #f0f8ff;
        }

        .img-thumbnail {
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }

        .btn-success {
            box-shadow: 0 4px 8px rgba(25,135,84,0.3);
        }

        .card {
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        .deskripsi-ringkas {
            max-width: 300px;
        }

        .aksi-btn {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-arrow-left-circle"></i> Dashboard Admin</a>
        <span class="navbar-text text-white"><i class="bi bi-map-fill me-1"></i> Data Destinasi</span>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-primary mb-0"><i class="bi bi-geo-alt-fill"></i> Daftar Destinasi Wisata</h4>
            <a href="form_tambah_destinasi.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Tambah Destinasi Wisata
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tempat</th>
                        <th>Lokasi</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($d = mysqli_fetch_assoc($destinasi)) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="text-start"><?= htmlspecialchars($d['nama_tempat']); ?></td>
                            <td><span class="badge text-bg-info"><?= htmlspecialchars($d['lokasi']); ?></span></td>
                            <td class="text-start deskripsi-ringkas"><?= substr(strip_tags($d['deskripsi']), 0, 100); ?>...</td>
                            <td>
                                <?php if ($d['gambar']) : ?>
                                    <img src="../images/paket/<?= $d['gambar']; ?>" width="100" alt="Gambar" class="img-thumbnail">
                                <?php else : ?>
                                    <em class="text-muted">Tidak ada</em>
                                <?php endif; ?>
                            </td>
                            <td class="aksi-btn">
                                <a href="form_edit_destinasi.php?id=<?= $d['id_destination']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="data_destinasi.php?hapus=<?= $d['id_destination']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus destinasi ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="dashboard.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

</body>
</html>
