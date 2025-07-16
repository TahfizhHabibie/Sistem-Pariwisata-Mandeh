<?php
session_start();
$title = "Tentang Wisata Mandeh";
include 'template/navbar_user.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Tentang Wisata Mandeh</h1>
        <p class="lead">Surga tersembunyi di pesisir Sumatera Barat</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm p-4">
                <p>
                    Kawasan Wisata Mandeh terletak di Kabupaten Pesisir Selatan, Sumatera Barat. 
                    Dikenal sebagai "Raja Ampat-nya Sumatera", Mandeh menawarkan keindahan laut yang luar biasa, 
                    gugusan pulau kecil yang eksotis, air laut yang jernih, serta hutan mangrove yang rimbun.
                </p>
                <p>
                    Aktivitas wisata yang bisa dilakukan di antaranya adalah snorkeling, diving, island hopping, 
                    mendaki bukit untuk menikmati panorama laut, dan mencicipi kuliner khas daerah.
                </p>
                <p>
                    Akses ke Mandeh sangat mudah dari Kota Padang, hanya membutuhkan waktu sekitar 2 jam perjalanan darat.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>
</body>
</html>
