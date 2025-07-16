<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/koneksi.php';

// Ambil data user (kecuali admin)
$query = mysqli_query($conn, "SELECT * FROM habibi_users WHERE role = 'user'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Users - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f3f6;
        }

        .table-hover tbody tr:hover {
            background-color: #eef2ff;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.08);
        }

        .table thead {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
        }

        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-speedometer2"></i> Admin Panel</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="card p-4">
        <h4 class="mb-4"><i class="bi bi-people-fill text-primary"></i> Data Pengguna</h4>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <i class="bi bi-person-circle me-1 text-primary"></i>
                                <?= htmlspecialchars($row['nama']); ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark"><?= htmlspecialchars($row['email']); ?></span>
                            </td>
                            <td><?= $row['created_at'] ?? '<span class="text-muted">—</span>'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
