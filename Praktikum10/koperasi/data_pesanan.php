<?php
//1. sertakan koneksi database
require 'dbkoneksi.php';
include_once 'header.php';
include_once 'sidebar.php';

//2 Query untuk mendapatkan data pesanan dengan join ke anggota dan pegawai
$query = $dbh->query('SELECT p.*, a.id as anggota_id, 
                      pg.nama as pegawai_nama 
                      FROM pesanan p 
                      JOIN anggota a ON p.anggota_id = a.id 
                      LEFT JOIN pegawai pg ON a.pegawai_id = pg.id 
                      ORDER BY p.tanggal DESC');
$nomor = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Pesanan</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <a href="form_pesanan.php"><button class="btn btn-primary mb-1">Tambah Pesanan</button></a>
                                <div class="table-responsive">
                                    <table class="table table-head-fixed table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Tanggal</th>
                                            <th>Anggota</th>
                                            <th>Diskon (%)</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($query as $row) {
                                            $queryTotal = $dbh->prepare("
                                                SELECT SUM(p.harga * dp.jumlah) as total 
                                                FROM detail_pesanan dp 
                                                JOIN produk p ON dp.produk_id = p.id 
                                                WHERE dp.pesanan_id = ?
                                            ");
                                            $queryTotal->execute([$row['id']]);
                                            $totalData = $queryTotal->fetch();
                                            $total = $totalData['total'] ?? 0;

                                            $totalAfterDiskon = $total - ($total * $row['diskon'] / 100);
                                            
                                            echo "<tr>";
                                            echo "<td>" . $nomor++ . "</td>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>";
                                            echo "<td>" . $row['pegawai_nama'] . "</td>";
                                            echo "<td>" . $row['diskon'] . "</td>";
                                            echo "<td>" . ($row['status_bayar'] ? '<span class="badge badge-success">Lunas</span>' : '<span class="badge badge-warning">Belum Lunas</span>') . "</td>";
                                            echo "<td>Rp " . number_format($totalAfterDiskon, 0, ',', '.') . "</td>";
                                            echo "<td>
                                                    <a href='view_pesanan.php?id=" . $row['id'] . "' class='btn btn-info btn-sm mb-1' title='Lihat Detail'><i class='fas fa-eye'></i> Detail</a>
                                                    <a href='edit_pesanan.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm mb-1' title='Edit'><i class='fas fa-edit'></i> Edit</a>
                                                    <a href='delete_pesanan.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm mb-1' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pesanan ini?\")' title='Hapus'><i class='fas fa-trash'></i> Hapus</a>
                                                    " . (!$row['status_bayar'] ? "<a href='form_pembayaran.php?id=" . $row['id'] . "' class='btn btn-success btn-sm mb-1' title='Bayar'><i class='fas fa-money-bill'></i> Bayar</a>" : "") . "
                                                  </td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <?php
    include_once 'footer.php';
    ?>
</body>

</html>