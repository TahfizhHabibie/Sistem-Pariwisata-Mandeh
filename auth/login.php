<?php
session_start();
include '../config/koneksi.php';

$message = "";

if (isset($_GET['register']) && $_GET['register'] === 'success') {
    $message = '<div class="alert alert-success">Registrasi berhasil! Silakan login.</div>';
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM habibi_users WHERE email = '$email'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        if (password_verify($password, $data['password'])) {
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['nama'] = $data['nama'];

            if ($data['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            $message = '<div class="alert alert-danger">Password salah.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Email tidak ditemukan.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Pariwisata Mandeh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .card-footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 1rem;
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
                    <h4 class="fw-bold mb-0">Login Sistem Pariwisata Mandeh</h4>
                </div>
                <div class="card-body">
                    <?= $message ?>
                    <form method="POST" novalidate>
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
                <div class="card-footer">
                    Belum punya akun? <a href="register.php">Daftar di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
