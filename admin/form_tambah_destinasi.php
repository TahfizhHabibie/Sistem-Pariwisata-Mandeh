<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Destinasi Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.25);
        }

        label {
            font-weight: 500;
        }

        h4 {
            color: #198754;
        }

        .btn-success {
            box-shadow: 0 4px 10px rgba(25, 135, 84, 0.4);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i> Admin Panel</a>
        <div class="ms-auto">
            <a href="data_destinasi.php" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container mt-5">
    <h4 class="mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Tambah Destinasi Wisata</h4>

    <div class="card p-4">
        <div class="card-body">
            <form method="POST" action="proses_tambah_destinasi.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_tempat">Nama Tempat</label>
                    <input type="text" id="nama_tempat" name="nama_tempat" class="form-control" placeholder="Contoh: Pantai Mandeh" required>
                </div>
                <div class="mb-3">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Contoh: Pesisir Selatan, Sumbar" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Tuliskan deskripsi destinasi wisata..." required></textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar">Upload Gambar</label>
                    <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-success">
                    <i class="bi bi-save2 me-1"></i> Simpan Destinasi
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
