<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='auth/login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id_user'];
    $id_destination = intval($_POST['id_destination']);
    $rating = intval($_POST['rating']);
    $tanggal = date('Y-m-d');

    // Cek apakah user sudah pernah review di destinasi tersebut
    $cek = mysqli_query($conn, "SELECT * FROM habibi_reviews WHERE id_user = $id_user AND id_destination = $id_destination");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Anda sudah memberikan rating untuk destinasi ini.'); window.location='review_list.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO habibi_reviews (id_user, id_destination, rating, tanggal_review) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $id_user, $id_destination, $rating, $tanggal);

    if ($stmt->execute()) {
        echo "<script>alert('Rating berhasil ditambahkan!'); window.location='review_list.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan rating!'); window.location='review_list.php';</script>";
    }

    $stmt->close();
}
?>
