<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Dashboard - Manajemen Koperasi Pegawai</title>
  <link
    href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
    rel="stylesheet" />
  <link href="assets/css/styles.css" rel="stylesheet" />
  <script
    src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
    crossorigin="anonymous"></script>
</head>

<?php
require_once 'dbkoneksi.php';

$countPegawai = $pdo->query("SELECT COUNT(*) FROM pegawai")->fetchColumn();
$countAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
$countProduk = $pdo->query("SELECT COUNT(*) FROM produk")->fetchColumn();
$countPesanan = $pdo->query("SELECT COUNT(*) FROM pesanan")->fetchColumn();
?>

<body class="sb-nav-fixed">
  <?php include_once "layout/header.php" ?>

  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <?php include_once "layout/sidebar.php" ?>

    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Dashboard</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
          <div class="row">
            <!-- Pegawai -->
            <div class="col-xl-3 col-md-6">
              <div class="card bg-primary text-white mb-4">
                <div class="card-body">Pegawai: <?= $countPegawai ?></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="pegawai/index.php">Lihat Detail</a>
                  <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
              </div>
            </div>

            <!-- Anggota -->
            <div class="col-xl-3 col-md-6">
              <div class="card bg-warning text-white mb-4">
                <div class="card-body">Anggota: <?= $countAnggota ?></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="anggota/index.php">Lihat Detail</a>
                  <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
              </div>
            </div>

            <!-- Produk -->
            <div class="col-xl-3 col-md-6">
              <div class="card bg-success text-white mb-4">
                <div class="card-body">Produk: <?= $countProduk ?></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="produk/index.php">Lihat Detail</a>
                  <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
              </div>
            </div>

            <!-- Pesanan -->
            <div class="col-xl-3 col-md-6">
              <div class="card bg-danger text-white mb-4">
                <div class="card-body">Pesanan: <?= $countPesanan ?></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="pesanan/index.php">Lihat Detail</a>
                  <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </main>
      <?php include_once "layout/footer.php" ?>
    </div>
  </div>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  <script src="assets/js/scripts.js"></script>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
    crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
  <script src="assets/js/datatables-simple-demo.js"></script>
</body>

</html>