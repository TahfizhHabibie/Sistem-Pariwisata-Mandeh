<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="/Sistem_pariwisata_mandeh/index.php">Pariwisata</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarUser">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/Sistem_pariwisata_mandeh/index.php">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Sistem_pariwisata_mandeh/paket.php">Paket</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Sistem_pariwisata_mandeh/destinasi.php">Destinasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Sistem_pariwisata_mandeh/review_list.php">Review</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Sistem_pariwisata_mandeh/history.php">Riwayat</a>
        </li>

        <?php if (isset($_SESSION['role'])) : ?>
          <?php if ($_SESSION['role'] === 'admin') : ?>
            <li class="nav-item">
              <a class="nav-link" href="/Sistem_pariwisata_mandeh/admin/dashboard.php">Dashboard Admin</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="/Sistem_pariwisata_mandeh/auth/logout.php">Logout</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link" href="/Sistem_pariwisata_mandeh/auth/login.php">Login User</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Sistem_pariwisata_mandeh/auth/login_admin.php">Login Admin</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
