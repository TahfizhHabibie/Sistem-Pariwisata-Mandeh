<?php
session_start();
include 'config/koneksi.php';
$title = "Beranda - Sistem Pariwisata";
include 'template/navbar_user.php';

// Ambil data destinasi dan paket terbatas
$destinasi = mysqli_query($conn, "SELECT * FROM habibi_destinations LIMIT 3");
$paket = mysqli_query($conn, "SELECT p.*, d.nama_tempat 
          FROM habibi_packages p
          JOIN habibi_destinations d ON p.id_destination = d.id_destination
          LIMIT 3");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('images/banner/mandeh11.jpg') center center / cover no-repeat;
            height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;    
            color: white; 
            text-shadow: 0 2px 4px rgba(0,0,0,0.6);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .section-title {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>

<!-- Hero Banner -->
<div class="hero">
    <div class="text-center">
        <h1 class="display-4 fw-bold">Selamat Datang di Wisata Mandeh</h1>
        <p class="lead">Surga tersembunyi di pesisir Sumatera Barat</p>
        <a href="/Sistem_pariwisata_mandeh/paket.php" class="btn btn-light btn-lg mt-3">Lihat Paket Wisata</a>
    </div>
</div>

<div class="container mt-5">

    <!-- Galeri Foto Otomatis -->
    <h3 class="section-title mb-4">Galeri Wisata Mandeh</h3>
    <div class="row">
        <?php
        $galeri_dir = __DIR__ . '/images';
        $files = scandir($galeri_dir);
        $image_files = array_filter($files, function($file) {
            return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
        });

        foreach ($image_files as $image) :
        ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <img src="images/<?= $image ?>" class="img-fluid rounded" style="height:250px; object-fit:cover;" alt="Foto Mandeh">
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Destinasi Populer -->
    <h3 class="section-title mt-5 mb-4">Destinasi Populer</h3>
    <div class="row">
        <?php while($d = mysqli_fetch_assoc($destinasi)) : ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <?php if (!empty($d['gambar'])) : ?>
                        <img src="images/paket/<?= $d['gambar']; ?>" class="card-img-top" alt="<?= $d['nama_tempat']; ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($d['nama_tempat']); ?></h5>
                        <p class="card-text"><?= substr(strip_tags($d['deskripsi']), 0, 80); ?>...</p>
                        <a href="destinasi.php?id=<?= $d['id_destination']; ?>" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Gambar Statis Tambahan -->
    <h3 class="section-title mb-4 mt-5">Galeri Eksklusif Mandeh</h3>
    <div class="row">
        <div class="col-md-4 mb-3">
            <img src="images/galeri/Mandeh.jpg" class="img-fluid rounded shadow-sm" alt="Lagoon Mandeh">
        </div>
        <div class="col-md-4 mb-3">
            <img src="images/galeri/PuncakPaku.jpg" class="img-fluid rounded shadow-sm" alt="Puncak Paku">
        </div>
        <div class="col-md-4 mb-3">
            <img src="images/galeri/snorkling.jpg" class="img-fluid rounded shadow-sm" alt="Snorkeling Mandeh">
        </div>
    </div>

    <!-- Paket Rekomendasi -->
    <h3 class="section-title mt-5 mb-4">Paket Wisata Rekomendasi</h3>
    <div class="row">
        <?php while($p = mysqli_fetch_assoc($paket)) : ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($p['nama_paket']); ?></h5>
                        <p class="card-text"><strong>Destinasi:</strong> <?= $p['nama_tempat']; ?></p>
                        <p class="card-text"><strong>Durasi:</strong> <?= $p['durasi_hari']; ?> hari</p>
                        <p class="card-text"><strong>Harga:</strong> Rp<?= number_format($p['harga'], 0, ',', '.'); ?></p>
                        <a href="detail_paket.php?id=<?= $p['id_package']; ?>" class="btn btn-primary btn-sm">Detail Paket</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

</div>

<?php include 'template/footer.php'; ?>
</body>
</html>
