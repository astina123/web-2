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
   <link href="../assets/css/styles.css" rel="stylesheet" />
   <script
      src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
      crossorigin="anonymous"></script>
</head>

<?php
require_once '../dbkoneksi.php';

// Ambil data produk beserta jenis produk
$stmt = $pdo->query("SELECT produk.*, jenis_produk.nama as jenis_produk_nama 
                     FROM produk 
                     LEFT JOIN jenis_produk ON produk.jenis_produk_id = jenis_produk.id");
$dataProduk = $stmt->fetchAll();
?>

<body>
   <?php include_once "../layout/header.php" ?>

   <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
         <?php include_once "../layout/sidebar.php" ?>
      </div>
      <div id="layoutSidenav_content">
         <main>
            <div class="container-fluid px-4">
               <h1 class="mt-4">Data Produk</h1>
               <ol class="breadcrumb mb-4">
                  <li class="breadcrumb-item">
                     <a href="index.html">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Data Produk</li>
               </ol>
               <div class="card mb-4">
                  <div class="card-header d-flex align-items-center">
                     <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Produk</a>
                  </div>
                  <div class="card-body">
                     <table id="datatablesSimple" class="table table-hover">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Kode</th>
                              <th>Nama</th>
                              <th>Jenis Produk</th>
                              <th>Harga</th>
                              <th>Stok</th>
                              <th>Aksi</th>
                           </tr>
                        </thead>

                        <tbody>
                           <?php $no = 1;
                           foreach ($dataProduk as $row): ?>
                              <tr>
                                 <td><?= $no++ ?></td>
                                 <td><?= $row['kode'] ?></td>
                                 <td><?= $row['nama'] ?></td>
                                 <td><?= $row['jenis_produk_nama'] ?></td>
                                 <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
                                 <td><?= $row['stok'] ?></td>
                                 <td>
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </main>
         <?php include_once "../layout/footer.php" ?>
      </div>
   </div>
   <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"></script>
   <script src="../assets/js/scripts.js"></script>
   <script src="../assets/js/datatables-simple-demo.js"></script>
</body>

</html>