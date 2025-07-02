<?php
//1. sertakan koneksi database
require 'dbkoneksi.php';
include_once 'header.php';
include_once 'sidebar.php';

// Cek apakah parameter id ada
if (!isset($_GET['id'])) {
    header("Location: data_pesanan.php");
    exit();
}

$id = $_GET['id'];

// Ambil data pesanan
$queryPesanan = $dbh->prepare("
    SELECT p.*, a.id as anggota_id, pg.nama as pegawai_nama 
    FROM pesanan p 
    JOIN anggota a ON p.anggota_id = a.id 
    LEFT JOIN pegawai pg ON a.pegawai_id = pg.id 
    WHERE p.id = ?
");
$queryPesanan->execute([$id]);
$pesanan = $queryPesanan->fetch(PDO::FETCH_ASSOC);

// Jika pesanan tidak ditemukan
if (!$pesanan) {
    header("Location: data_pesanan.php");
    exit();
}

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
                            ORDER BY p.nama');

// Ambil detail pesanan (produk yang sudah dipilih)
$queryDetail = $dbh->prepare("
    SELECT dp.*, p.nama as produk_nama, p.kode as produk_kode, p.harga, p.stok, jp.nama as jenis_nama 
    FROM detail_pesanan dp 
    JOIN produk p ON dp.produk_id = p.id 
    JOIN jenis_produk jp ON p.jenis_produk_id = jp.id 
    WHERE dp.pesanan_id = ?
");
$queryDetail->execute([$id]);
$detailPesanan = $queryDetail->fetchAll(PDO::FETCH_ASSOC);

// Buat array untuk menyimpan jumlah produk yang sudah dipilih
$produkTerpilih = [];
foreach ($detailPesanan as $detail) {
    $produkTerpilih[$detail['produk_id']] = $detail['jumlah'];
}

// Cek apakah pesanan sudah memiliki pembayaran
$queryPembayaran = $dbh->prepare("
    SELECT id FROM pembayaran WHERE pesanan_id = ? LIMIT 1
");
$queryPembayaran->execute([$id]);
$hasPembayaran = $queryPembayaran->rowCount() > 0;

// Jika pesanan sudah dibayar, hanya boleh edit tanggal dan diskon
$editablePesanan = !$hasPembayaran;
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Edit Pesanan</title>
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
                        <h1>Edit Pesanan #<?php echo $id; ?></h1>
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
                                <?php if ($pesanan['status_bayar'] == 1): ?>
                                <div class="alert alert-warning">
                                    <strong>Perhatian!</strong> Pesanan ini sudah dibayar. Anda hanya dapat mengubah tanggal dan diskon.
                                </div>
                                <?php endif; ?>
                            
                                <form action="update_pesanan.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    
                                    <div class="form-group row">
                                        <label for="tanggal" class="col-3 col-form-label">Tanggal Pesanan</label>
                                        <div class="col-9">
                                            <input required id="tanggal" name="tanggal" type="date" class="form-control" value="<?php echo $pesanan['tanggal']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="anggota_id" class="col-3 col-form-label">Anggota</label>
                                        <div class="col-9">
                                            <select required id="anggota_id" name="anggota_id" class="form-control" <?php echo !$editablePesanan ? 'disabled' : ''; ?>>
                                                <option value="">-- Pilih Anggota --</option>
                                                <?php
                                                foreach ($queryAnggota as $anggota) {
                                                    $selected = ($anggota['id'] == $pesanan['anggota_id']) ? 'selected' : '';
                                                    echo "<option value='" . $anggota['id'] . "' $selected>" . $anggota['pegawai_nama'] . " (ID: " . $anggota['id'] . ")</option>";
                                                }
                                                ?>
                                            </select>
                                            <?php if (!$editablePesanan): ?>
                                            <input type="hidden" name="anggota_id" value="<?php echo $pesanan['anggota_id']; ?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="diskon" class="col-3 col-form-label">Diskon (%)</label>
                                        <div class="col-9">
                                            <input required id="diskon" name="diskon" type="number" class="form-control" min="0" max="100" value="<?php echo $pesanan['diskon']; ?>">
                                        </div>
                                    </div>
                                    
                                    <?php if ($editablePesanan): ?>
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
                                                            $maxStok = $produk['stok'];
                                                            if (isset($produkTerpilih[$produk['id']])) {
                                                                $maxStok += $produkTerpilih[$produk['id']];
                                                            }
                                                            
                                                            $jumlahTerpilih = $produkTerpilih[$produk['id']] ?? 0;
                                                            
                                                            echo "<tr>";
                                                            echo "<td>" . $produk['nama'] . " (" . $produk['kode'] . ")<br><small>" . $produk['jenis_nama'] . "</small></td>";
                                                            echo "<td>Rp " . number_format($produk['harga'], 0, ',', '.') . "</td>";
                                                            echo "<td>" . $maxStok . "</td>";
                                                            echo "<td>
                                                                    <input type='number' name='produk[" . $produk['id'] . "]' class='form-control' min='0' max='" . $maxStok . "' value='" . $jumlahTerpilih . "'>
                                                                  </td>";
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <h4 class="mt-4 mb-3">Produk Terpilih</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Produk</th>
                                                            <th>Harga</th>
                                                            <th>Jumlah</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total = 0;
                                                        foreach ($detailPesanan as $detail) {
                                                            $subtotal = $detail['harga'] * $detail['jumlah'];
                                                            $total += $subtotal;
                                                            
                                                            echo "<tr>";
                                                            echo "<td>" . $detail['produk_nama'] . " (" . $detail['produk_kode'] . ")<br><small>" . $detail['jenis_nama'] . "</small></td>";
                                                            echo "<td>Rp " . number_format($detail['harga'], 0, ',', '.') . "</td>";
                                                            echo "<td>" . $detail['jumlah'] . "</td>";
                                                            echo "<td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>";
                                                            echo "</tr>";
                                                            
                                                            // Tambahkan input hidden untuk menyimpan jumlah produk
                                                            echo "<input type='hidden' name='produk[" . $detail['produk_id'] . "]' value='" . $detail['jumlah'] . "'>";
                                                        }
                                                        
                                                        // Tampilkan total dan total setelah diskon
                                                        $totalAfterDiskon = $total - ($total * $pesanan['diskon'] / 100);
                                                        echo "<tr class='table-light'>";
                                                        echo "<td colspan='3' class='text-right'><strong>Total</strong></td>";
                                                        echo "<td>Rp " . number_format($total, 0, ',', '.') . "</td>";
                                                        echo "</tr>";
                                                        echo "<tr class='table-primary'>";
                                                        echo "<td colspan='3' class='text-right'><strong>Total Setelah Diskon (" . $pesanan['diskon'] . "%)</strong></td>";
                                                        echo "<td>Rp " . number_format($totalAfterDiskon, 0, ',', '.') . "</td>";
                                                        echo "</tr>";
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="form-group row mt-4">
                                        <div class="col-12">
                                            <button name="submit" type="submit" class="btn btn-primary">Update Pesanan</button>
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