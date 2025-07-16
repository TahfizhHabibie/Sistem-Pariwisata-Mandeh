<?php
session_start();
include '../config/koneksi.php';

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil ID paket dari parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID tidak valid.";
    exit();
}

$id = intval($_GET['id']);

// Ambil data paket berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM habibi_packages WHERE id_package = $id");
$paket = mysqli_fetch_assoc($query);

if (!$paket) {
    echo "Paket tidak ditemukan.";
    exit();
}

// Jika form disubmit
if (isset($_POST['update'])) {
    $nama_paket   = mysqli_real_escape_string($conn, $_POST['nama_paket']);
    $durasi       = intval($_POST['durasi_hari']);
    $harga        = intval($_POST['harga']);
    $id_destinasi = intval($_POST['id_destination']);

    $update = mysqli_query($conn, "UPDATE habibi_packages 
        SET nama_paket = '$nama_paket', durasi_hari = $durasi, harga = $harga, id_destination = $id_destinasi 
        WHERE id_package = $id");

    if ($update) {
        header("Location: ../paket.php");
        exit();
    } else {
        $error = "Gagal mengupdate data.";
    }
}

// Ambil semua destinasi untuk dropdown
$destinasi = mysqli_query($conn, "SELECT * FROM habibi_destinations");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Paket Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="mb-4">Edit Paket Wisata</h3>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nama_paket" class="form-label">Nama Paket</label>
            <input type="text" class="form-control" name="nama_paket" id="nama_paket" value="<?= htmlspecialchars($paket['nama_paket']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="durasi_hari" class="form-label">Durasi (hari)</label>
            <input type="number" class="form-control" name="durasi_hari" id="durasi_hari" value="<?= $paket['durasi_hari']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input type="number" class="form-control" name="harga" id="harga" value="<?= $paket['harga']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="id_destination" class="form-label">Destinasi</label>
            <select class="form-select" name="id_destination" id="id_destination" required>
                <option value="">-- Pilih Destinasi --</option>
                <?php while ($d = mysqli_fetch_assoc($destinasi)) : ?>
                    <option value="<?= $d['id_destination']; ?>" <?= $d['id_destination'] == $paket['id_destination'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($d['nama_tempat']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
        <a href="../paket.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>
