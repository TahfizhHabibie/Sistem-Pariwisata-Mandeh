<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login_admin.php");
    exit();
}

include '../config/koneksi.php';

// Ambil data destinasi untuk dropdown
$destinasi = mysqli_query($conn, "SELECT * FROM habibi_destinations");

$message = "";
if (isset($_POST['tambah'])) {
    $id_destination = intval($_POST['id_destination']);
    $nama_paket = mysqli_real_escape_string($conn, $_POST['nama_paket']);
    $harga = floatval($_POST['harga']);
    $durasi_hari = intval($_POST['durasi_hari']);
    $fasilitas = mysqli_real_escape_string($conn, $_POST['fasilitas']);

    // Upload gambar
    $gambar = '';
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../images/paket/" . $gambar);
    }

    $insert = mysqli_query($conn, "INSERT INTO habibi_packages (id_destination, nama_paket, harga, durasi_hari, fasilitas) 
        VALUES ('$id_destination', '$nama_paket', '$harga', '$durasi_hari', '$fasilitas')");

    if ($insert) {
        header("Location: data_paket.php?success=added");
        exit();
    } else {
        $message = "Gagal menambahkan paket.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>
    <meta charset="UTF-8">
    <title>Tambah Paket Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Tambah Paket Wisata</h3>
    <?php if ($message): ?>
        <div class="alert alert-danger"><?= $message; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Destinasi</label>
            <select name="id_destination" class="form-select" required>
                <option value="">-- Pilih Destinasi --</option>
                <?php while ($row = mysqli_fetch_assoc($destinasi)) : ?>
                    <option value="<?= $row['id_destination']; ?>"><?= htmlspecialchars($row['nama_tempat']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Nama Paket</label>
            <input type="text" name="nama_paket" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Durasi (hari)</label>
            <input type="number" name="durasi_hari" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fasilitas</label>
            <textarea name="fasilitas" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>

        <button type="submit" name="tambah" class="btn btn-primary">Simpan Paket</button>
        <a href="data_paket.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
