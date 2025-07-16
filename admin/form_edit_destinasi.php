<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/koneksi.php';

// Ambil ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.location='data_destinasi.php';</script>";
    exit();
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM habibi_destinations WHERE id_destination = $id");

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='data_destinasi.php';</script>";
    exit();
}

$data = mysqli_fetch_assoc($result);

// Proses Update
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_tempat']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Proses gambar
    $gambarBaru = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if (!empty($gambarBaru)) {
        move_uploaded_file($tmp, "../images/$gambarBaru");
        $gambar = $gambarBaru;
    } else {
        $gambar = $data['gambar']; // Tetap pakai gambar lama
    }

    $update = mysqli_query($conn, "UPDATE habibi_destinations SET 
        nama_tempat = '$nama',
        lokasi = '$lokasi',
        deskripsi = '$deskripsi',
        gambar = '$gambar'
        WHERE id_destination = $id");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='data_destinasi.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Destinasi Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        <div class="ms-auto">
            <a href="data_destinasi.php" class="btn btn-outline-light btn-sm me-2">Kembali</a>
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h4>Edit Destinasi Wisata</h4>
    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Nama Tempat</label>
                    <input type="text" name="nama_tempat" class="form-control" value="<?= htmlspecialchars($data['nama_tempat']); ?>" required>
                </div>
                <div class="mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="<?= htmlspecialchars($data['lokasi']); ?>" required>
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label>Gambar Saat Ini</label><br>
                    <?php if (!empty($data['gambar'])): ?>
                        <img src="../images/<?= $data['gambar']; ?>" width="200" class="mb-2">
                    <?php else: ?>
                        <p><i>Tidak ada gambar</i></p>
                    <?php endif; ?>
                    <input type="file" name="gambar" class="form-control mt-2" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update Destinasi</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
