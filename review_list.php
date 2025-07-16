<?php
session_start();
include 'config/koneksi.php';
include 'template/navbar_user.php';

$title = "Daftar Review dan Rating";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .star-rating span {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .card-title strong {
            color: #0d6efd;
        }

        .bg-light-blue {
            background-color: #f8faff;
        }
    </style>
</head>
<body class="bg-light-blue">

<div class="container mt-5">
    <h3 class="mb-4 text-primary">🌟 Daftar Rating & Ulasan Pengguna</h3>

    <!-- Form Tambah Rating -->
    <?php if (isset($_SESSION['id_user'])) : ?>
        <div class="card p-4 mb-4 shadow-sm border-0">
            <h5 class="mb-3">📝 Tambahkan Rating Baru</h5>
            <form method="POST" action="review_submit.php">
                <div class="mb-3">
                    <label for="id_destination" class="form-label">Pilih Destinasi</label>
                    <select name="id_destination" id="id_destination" class="form-select" required>
                        <option value="">-- Pilih Destinasi --</option>
                        <?php
                        $destQuery = mysqli_query($conn, "SELECT id_destination, nama_tempat FROM habibi_destinations ORDER BY nama_tempat ASC");
                        while ($dest = mysqli_fetch_assoc($destQuery)) :
                        ?>
                            <option value="<?= $dest['id_destination']; ?>"><?= htmlspecialchars($dest['nama_tempat']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label">Pilih Rating (1–5)</label>
                    <select name="rating" id="rating" class="form-select" required>
                        <option value="">-- Pilih Rating --</option>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <option value="<?= $i; ?>"><?= $i; ?> Bintang</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Kirim Rating
                    </button>
                </div>
            </form>
        </div>
    <?php else : ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-circle"></i> Silakan <a href="auth/login.php" class="alert-link">login</a> untuk menambahkan rating.
        </div>
    <?php endif; ?>

    <!-- Tampilkan Semua Review -->
    <?php
    $query = mysqli_query($conn, "
        SELECT r.*, u.nama AS nama_user, d.nama_tempat 
        FROM habibi_reviews r 
        JOIN habibi_users u ON r.id_user = u.id_user 
        JOIN habibi_destinations d ON r.id_destination = d.id_destination 
        ORDER BY r.tanggal_review DESC
    ");

    if (mysqli_num_rows($query) == 0) {
        echo '<div class="alert alert-info">Belum ada ulasan yang tersedia.</div>';
    } else {
        while ($row = mysqli_fetch_assoc($query)) :
    ?>
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-1">
                    <strong><?= htmlspecialchars($row['nama_user']) ?></strong>
                    <small class="text-muted float-end"><?= date('d M Y', strtotime($row['tanggal_review'])) ?></small>
                </h5>
                <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> Destinasi: <strong><?= htmlspecialchars($row['nama_tempat']) ?></strong></p>
                <div class="star-rating">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <span><?= $i <= $row['rating'] ? '★' : '☆'; ?></span>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    <?php endwhile; } ?>
</div>

<?php include 'template/footer.php'; ?>
</body>
</html>
