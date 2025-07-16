<?php
session_start();
include '../config/koneksi.php';

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // Enkripsi input user dengan MD5

    $query = mysqli_query($conn, "SELECT * FROM habibi_users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        // Cocokkan password MD5 dan role admin
        if ($password === $user['password'] && $user['role'] === 'admin') {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            $error = "Password salah atau Anda bukan admin.";
        }
    } else {
        $error = "Email tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Sistem Pariwisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #a8edea, #fed6e3);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 1.5rem 1rem;
        }
        .card-body {
            padding: 2rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="fw-bold mb-0">Login Admin</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)) : ?>
                        <div class="alert alert-danger"><?= $error; ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="../index.php" class="text-decoration-none">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
