<?php
session_start();
include 'config/koneksi.php';
include 'template/navbar_user.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Destinasi Wisata - Sistem Pariwisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="mb-4 text-center">Daftar Destinasi Wisata</h3>
    <div class="row">
        <?php
        $query = mysqli_query($conn, "SELECT * FROM habibi_destinations");
        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) :
        ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="images/paket/<?php echo htmlspecialchars($row['gambar']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nama_tempat']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['nama_tempat']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($row['deskripsi'], 0, 100)); ?>...</p>
                            <p class="text-muted"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['lokasi']); ?></p>
                            <div class="btn-group">
                                <a href="paket.php?id_destinasi=<?php echo htmlspecialchars($row['id_destination']); ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-card-list"></i> Lihat Paket
                                </a>
                                <a href="review_list.php?id_destination=<?php echo htmlspecialchars($row['id_destination']); ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-star-half"></i> Beri Rating
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php 
            endwhile; 
        } else {
            echo "<p class='text-danger'>Tidak ada data destinasi wisata.</p>";
        }
        ?>
    </div>
</div>

<?php include 'template/footer.php'; ?>
</body>
</html>
