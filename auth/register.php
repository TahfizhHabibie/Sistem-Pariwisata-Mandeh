<?php
session_start();
include '../config/koneksi.php';

$message = "";

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Enkripsi password

    // Cek apakah email sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM habibi_users WHERE email = '$email'");
    if (mysqli_num_rows($cek) > 0) {
        $message = "Email sudah terdaftar. Silakan gunakan email lain.";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO habibi_users (nama, email, password, role) VALUES ('$nama', '$email', '$password', 'user')");

        if ($insert) {
            $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM habibi_users WHERE email = '$email'"));

            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['nama']    = $user['nama'];

            header("Location: ../index.php");
            exit();
        } else {
            $message = "Registrasi gagal. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Sistem Pariwisata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #fff3e0);
        }
        .card {
            border-radius: 15px;
        }
        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0 fw-bold">Daftar Akun Baru</h4>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-warning"><?= $message; ?></div>
                    <?php endif; ?>
                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required minlength="6">
                        </div>
                        <button type="submit" name="register" class="btn btn-success w-100">Daftar</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    Sudah punya akun? <a href="login.php">Login di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
