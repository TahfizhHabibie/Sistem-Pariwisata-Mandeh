<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login_admin.php");
    exit();
}

include '../config/koneksi.php';

// Pastikan id_package ada di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID paket tidak valid.";
    exit();
}

$id_package = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM habibi_packages WHERE id_package = $id_package");
$paket = mysqli_fetch_assoc($query);

if (!$paket) {
    echo "Paket tidak ditemukan.";
    exit();
}

// Handle update data
if (isset($_POST['update'])) {
    $nama_paket = mysqli_real_escape_string($conn, $_POST['nama_paket']);
    $harga = floatval($_POST['harga']);
    $durasi_hari = intval($_POST['durasi_hari']);
    $fasilitas = mysqli_real_escape_string($conn, $_POST['fasilitas']);

    // Cek apakah ada file baru diunggah
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../images/paket/" . $gambar);

        // Update dengan gambar baru
        $update = mysqli_query($conn, "UPDATE habibi_packages SET 
            nama_paket = '$nama_paket',
            harga = '$harga',
            durasi_hari = '$durasi_hari',
            fasilitas = '$fasilitas',
            gambar = '$gambar'
            WHERE id_package = $id_package");
    } else {
        // Update tanpa gambar
        $update = mysqli_query($conn, "UPDATE habibi_packages SET 
            nama_paket = '$nama_paket',
            harga = '$harga',
            durasi_hari = '$durasi_hari',
            fasilitas = '$fasilitas'
            WHERE id_package = $id_package");
    }

    if ($update) {
        header("Location: data_paket.php?success=updated");
        exit();
    } else {
        echo "Gagal memperbarui data paket.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Paket Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h3>Edit Paket Wisata</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Paket</label>
            <input type="text" name="nama_paket" class="form-control" value="<?= htmlspecialchars($paket['nama_paket']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($paket['harga']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Durasi (hari)</label>
            <input type="number" name="durasi_hari" class="form-control" value="<?= htmlspecialchars($paket['durasi_hari']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Fasilitas</label>
            <textarea name="fasilitas" class="form-control" rows="4" required><?= htmlspecialchars($paket['fasilitas']); ?></textarea>
        </div>
        <div class="mb-3">
            <label>Gambar Saat Ini</label><br>
            <?php if (!empty($paket['gambar'])) : ?>
                <img src="../images/paket/<?= $paket['gambar']; ?>" width="150" alt="Gambar Saat Ini">
            <?php else : ?>
                <em>Tidak ada gambar</em>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Upload Gambar Baru (opsional)</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update Paket</button>
        <a href="data_paket.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

</body>
</html>
