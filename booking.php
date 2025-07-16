<?php
session_start();
include 'config/koneksi.php';

// Redirect jika user belum login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Anda harus login untuk melakukan pemesanan.'); window.location='auth/login.php';</script>";
    exit();
}

$id_user = $_SESSION['id_user'];
$role = $_SESSION['role'] ?? '';

// Redirect admin ke dashboard
if ($role === 'admin') {
    header("Location: admin/dashboard.php");
    exit();
}

// Validasi parameter id_paket
if (!isset($_GET['id_paket']) || !is_numeric($_GET['id_paket'])) {
    echo "<script>alert('Paket wisata tidak valid.'); window.location='paket.php';</script>";
    exit();
}

$id_paket = intval($_GET['id_paket']);

// Ambil data paket dengan prepared statement
$stmt = mysqli_prepare($conn, "SELECT * FROM habibi_packages WHERE id_package = ?");
mysqli_stmt_bind_param($stmt, "i", $id_paket);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo "<script>alert('Paket wisata tidak ditemukan.'); window.location='paket.php';</script>";
    exit();
}
$paket = mysqli_fetch_assoc($result);

// Proses form booking jika metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $jumlah_orang = intval($_POST['jumlah_orang']);

    if (empty($tanggal) || $jumlah_orang <= 0) {
        echo "<script>alert('Tanggal dan jumlah orang harus diisi dengan benar.');</script>";
    } else {
        $total_harga = $jumlah_orang * $paket['harga'];

        $stmt = mysqli_prepare($conn, 
            "INSERT INTO habibi_bookings 
            (id_user, id_package, tanggal_booking, jumlah_orang, total_harga, status) 
            VALUES (?, ?, ?, ?, ?, 'pending')");
        mysqli_stmt_bind_param($stmt, "iisid", 
            $id_user, $id_paket, $tanggal, $jumlah_orang, $total_harga);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Pesanan berhasil dibuat!'); window.location='history.php';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal membuat pesanan. Silakan coba lagi.');</script>";
        }
    }
}

include 'template/navbar_user.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Paket - Kawasan Wisata Mandeh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0">Booking Paket Wisata</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h3><?= htmlspecialchars($paket['nama_paket']) ?></h3>
                                <p class="text-muted"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($paket['lokasi'] ?? 'Destinasi Mandeh') ?></p>
                                <p><strong>Harga per orang:</strong> Rp <?= number_format($paket['harga'], 0, ',', '.') ?></p>
                                <p><strong>Durasi:</strong> <?= htmlspecialchars($paket['durasi_hari']) ?> hari</p>
                                <p><strong>Fasilitas:</strong> <?= htmlspecialchars($paket['fasilitas']) ?></p>
                            </div>
                        </div>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Berangkat</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required
                                       min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                                <input type="number" class="form-control" id="jumlah_orang" name="jumlah_orang" 
                                       min="1" max="30" value="1" required>
                            </div>
                            <div class="mb-3 bg-light p-3 rounded">
                                <h5>Total Harga: <span id="total_harga">Rp <?= number_format($paket['harga'], 0, ',', '.') ?></span></h5>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Pesan Sekarang</button>
                                <a href="detail_paket.php?id_paket=<?= $id_paket ?>" class="btn btn-outline-secondary">
                                    Kembali ke Detail Paket
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hitung ulang total harga saat jumlah orang berubah
        document.getElementById('jumlah_orang').addEventListener('input', function() {
            const jumlahOrang = parseInt(this.value) || 1;
            const hargaPerOrang = <?= (int) $paket['harga'] ?>;
            const totalHarga = jumlahOrang * hargaPerOrang;
            document.getElementById('total_harga').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
        });
    </script>
</body>
</html>
