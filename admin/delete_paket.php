<?php
session_start();
include '../config/koneksi.php';

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Periksa apakah parameter ID tersedia
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID tidak valid.";
    exit();
}

$id = intval($_GET['id']);

// Hapus data paket berdasarkan ID
$query = mysqli_query($conn, "DELETE FROM habibi_packages WHERE id_package = $id");

if ($query) {
    // Berhasil dihapus, kembali ke halaman daftar paket
    header("Location: ../paket.php?status=deleted");
    exit();
} else {
    echo "Gagal menghapus data.";
}
?>
