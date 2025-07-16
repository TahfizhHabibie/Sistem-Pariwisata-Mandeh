<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

include 'config/koneksi.php';

// Validasi id paket dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID Paket tidak valid.'); window.location='paket.php';</script>";
    exit();
}

$id_paket = intval($_GET['id']);

// Ambil data paket dan destinasi
$query = mysqli_query($conn, "SELECT p.*, d.nama_tempat, d.lokasi, d.gambar AS gambar_destinasi 
                              FROM habibi_packages p 
                              JOIN habibi_destinations d ON p.id_destination = d.id_destination 
                              WHERE p.id_package = $id_paket");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Paket tidak ditemukan.'); window.location='paket.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Paket - <?= htmlspecialchars($data['nama_paket']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-img {
            height: 300px;
            object-fit: cover;
            width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Pariwisata</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="paket.php" class="nav-link">Paket</a></li>
                <li class="nav-item"><a href="destinasi.php" class="nav-link">Destinasi</a></li>
                <li class="nav-item"><a href="../auth/logout.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Konten -->
<div class="container mt-4">
    <div class="card shadow p-4">
        <div class="row">
            <div class="col-md-6">
                <img src="images/paket/<?= htmlspecialchars($data['gambar_destinasi']); ?>" class="header-img" alt="<?= htmlspecialchars($data['nama_paket']); ?>" onerror="this.src='https://placehold.co/600x300?text=No+Image'">
            </div>
            <div class="col-md-6">
                <h3><?= htmlspecialchars($data['nama_paket']); ?></h3>
                <p><strong>Destinasi:</strong> <?= htmlspecialchars($data['nama_tempat']); ?> - <?= htmlspecialchars($data['lokasi']); ?></p>
                <p><strong>Durasi:</strong> <?= $data['durasi_hari']; ?> hari</p>
                <p><strong>Harga:</strong> Rp<?= number_format($data['harga'], 0, ',', '.'); ?></p>
                <p><strong>Fasilitas:</strong></p>
                <ul>
                    <?php
                    $fasilitas = explode(',', $data['fasilitas']);
                    foreach ($fasilitas as $item) {
                        echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
                    }
                    ?>
                </ul>
                <a href="booking.php?id_paket=<?= $data['id_package']; ?>" class="btn btn-success mt-3">Pesan Sekarang</a>
            </div>
        </div>
        <hr>
        <div>
            <h5>Deskripsi Paket</h5>
             <p><?= !empty($data['deskripsi']) ? nl2br(htmlspecialchars($data['deskripsi'])) : 'Deskripsi belum tersedia.'; ?></p>
        </div>
    </div>
</div>

</body>
</html>
