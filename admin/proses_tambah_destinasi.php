<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_tempat']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    // Buat nama unik jika perlu
    $gambarBaru = time() . '-' . basename($gambar);
    $path = "../images/" . $gambarBaru;

    if (move_uploaded_file($tmp, $path)) {
        $query = mysqli_query($conn, "INSERT INTO habibi_destinations (nama_tempat, lokasi, deskripsi, gambar) 
            VALUES ('$nama', '$lokasi', '$deskripsi', '$gambarBaru')");

        if ($query) {
            echo "<script>alert('Destinasi berhasil ditambahkan!'); window.location='data_destinasi.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan destinasi ke database!'); window.location='form_tambah_destinasi.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload gambar!'); window.location='form_tambah_destinasi.php';</script>";
    }
} else {
    header("Location: form_tambah_destinasi.php");
}
?>
