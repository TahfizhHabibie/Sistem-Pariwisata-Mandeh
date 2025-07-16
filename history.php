<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

$query = "
    SELECT b.*, p.nama_paket, p.harga, p.durasi_hari 
    FROM habibi_bookings b
    JOIN habibi_packages p ON b.id_package = p.id_package
    WHERE b.id_user = ?
    ORDER BY b.tanggal_booking DESC
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include 'template/navbar_user.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Booking - Kawasan Wisata Mandeh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Riwayat Booking Anda</h2>

    <?php if (mysqli_num_rows($result) === 0): ?>
        <div class="alert alert-info">Anda belum memiliki riwayat pemesanan.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Nama Paket</th>
                        <th>Tanggal</th>
                        <th>Jumlah Orang</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_paket']) ?></td>
                        <td><?= date('d M Y', strtotime($row['tanggal_booking'])) ?></td>
                        <td><?= $row['jumlah_orang'] ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($row['status']) ?></span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
