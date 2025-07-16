<?php
session_start();
include 'template/navbar_user.php';
include 'config/koneksi.php';
$role = $_SESSION['role'] ?? 'guest'; 

// Jika ada filter berdasarkan destinasi
$filter = "";
if (isset($_GET['id_destinasi'])) {
    $id_destinasi = intval($_GET['id_destinasi']);
    $filter = "WHERE p.id_destination = $id_destinasi";
}

// Query data paket dan destinasi
$query = mysqli_query($conn, "SELECT p.*, d.nama_tempat, d.gambar AS gambar_destinasi 
                              FROM habibi_packages p 
                              JOIN habibi_destinations d ON p.id_destination = d.id_destination 
                              $filter
                              ORDER BY p.id_package DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Paket Wisata - Sistem Pariwisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="mb-4 text-center">Daftar Paket Wisata</h3>

    <?php if ($role === 'admin') : ?>
        <!-- Tampilan untuk ADMIN: Tabel Paket -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Destinasi</th>
                        <th>Durasi</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_paket']); ?></td>
                            <td><?= htmlspecialchars($row['nama_tempat']); ?></td>
                            <td class="text-center"><?= $row['durasi_hari']; ?> hari</td>
                            <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <a href="admin/edit_paket.php?id=<?= $row['id_package']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="admin/delete_paket.php?id=<?= $row['id_package']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus paket ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Tambahan Tabel Destinasi Wisata -->
        <hr class="my-5">
        <h4 class="mb-3 text-center">Data Destinasi Wisata</h4>
        <?php
        $wisata = mysqli_query($conn, "SELECT * FROM habibi_destinations ORDER BY id_destination DESC");
        ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-success text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Tempat</th>
                        <th>Lokasi</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($w = mysqli_fetch_assoc($wisata)) : ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($w['nama_tempat']); ?></td>
                            <td><?= htmlspecialchars($w['lokasi']); ?></td>
                            <td><?= substr(strip_tags($w['deskripsi']), 0, 100) . '...'; ?></td>
                            <td class="text-center">
                                <?php if (!empty($w['gambar'])) : ?>
                                    <img src="images/paket/<?= $w['gambar']; ?>" alt="<?= $w['nama_tempat']; ?>" width="100">
                                <?php else : ?>
                                    <em>Tidak ada gambar</em>
                                <?php endif; ?>
                            
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    <?php else : ?>
        <!-- Tampilan untuk USER: Kartu Paket -->
        <div class="row">
            <?php
            // Reset ulang pointer query karena sudah dibaca oleh admin
            mysqli_data_seek($query, 0);
            if (mysqli_num_rows($query) === 0) {
                echo '<p class="text-center text-muted">Tidak ada paket ditemukan.</p>';
            }
            while ($row = mysqli_fetch_assoc($query)) :
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="images/paket/<?= $row['gambar_destinasi']; ?>" class="card-img-top" alt="<?= $row['nama_paket']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['nama_paket']); ?></h5>
                            <p class="card-text">Tujuan: <?= htmlspecialchars($row['nama_tempat']); ?></p>
                            <p class="text-muted">Durasi: <?= $row['durasi_hari']; ?> hari</p>
                            <p><strong>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></strong></p>
                            <a href="detail_paket.php?id=<?= $row['id_package']; ?>" class="btn btn-primary btn-sm">Lihat Detail</a>
                            <a href="booking.php?id_paket=<?= $row['id_package']; ?>" class="btn btn-success btn-sm">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>
</body>
</html>
