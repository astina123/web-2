<?php
//1. sertakan koneksi database
require 'dbkoneksi.php';
include_once 'header.php';
include_once 'sidebar.php';

// Query untuk mendapatkan daftar anggota untuk dropdown
$queryAnggota = $dbh->query('SELECT a.id, p.nama as pegawai_nama 
                            FROM anggota a 
                            JOIN pegawai p ON a.pegawai_id = p.id 
                            WHERE a.status_aktif = 1 
                            ORDER BY p.nama');

// Query untuk mendapatkan daftar produk untuk pilihan
$queryProduk = $dbh->query('SELECT p.*, jp.nama as jenis_nama 
                            FROM produk p 
                            JOIN jenis_produk jp ON p.jenis_produk_id = jp.id 
                            WHERE p.stok > 0 
                            ORDER BY p.nama');
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Form Pesanan</title>
    <style>
        .product-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .product-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Buat Pesanan Baru</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="proses_pesanan.php" method="POST">
                                    <div class="form-group row">
                                        <label for="tanggal" class="col-3 col-form-label">Tanggal Pesanan</label>
                                        <div class="col-9">
                                            <input required id="tanggal" name="tanggal" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="anggota_id" class="col-3 col-form-label">Anggota</label>
                                        <div class="col-9">
                                            <select required id="anggota_id" name="anggota_id" class="form-control">
                                                <option value="">-- Pilih Anggota --</option>
                                                <?php
                                                foreach ($queryAnggota as $anggota) {
                                                    echo "<option value='" . $anggota['id'] . "'>" . $anggota['pegawai_nama'] . " (ID: " . $anggota['id'] . ")</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="diskon" class="col-3 col-form-label">Diskon (%)</label>
                                        <div class="col-9">
                                            <input required id="diskon" name="diskon" type="number" class="form-control" min="0" max="100" value="0">
                                        </div>
                                    </div>
                                    
                                    <h4 class="mt-4 mb-3">Pilih Produk</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Produk</th>
                                                            <th>Harga</th>
                                                            <th>Stok</th>
                                                            <th style="width: 150px;">Jumlah</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($queryProduk as $produk) {
                                                            echo "<tr>";
                                                            echo "<td>" . $produk['nama'] . " (" . $produk['kode'] . ")<br><small>" . $produk['jenis_nama'] . "</small></td>";
                                                            echo "<td>Rp " . number_format($produk['harga'], 0, ',', '.') . "</td>";
                                                            echo "<td>" . $produk['stok'] . "</td>";
                                                            echo "<td>
                                                                    <input type='number' name='produk[" . $produk['id'] . "]' class='form-control' min='0' max='" . $produk['stok'] . "' value='0'>
                                                                  </td>";
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mt-4">
                                        <div class="col-12">
                                            <button name="submit" type="submit" class="btn btn-primary">Simpan Pesanan</button>
                                            <a href="data_pesanan.php" class="btn btn-secondary">Kembali</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <?php
    include_once 'footer.php';
    ?>
</body>

</html>