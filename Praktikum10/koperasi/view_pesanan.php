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

// Ambil detail pesanan
$queryDetail = $dbh->prepare("
    SELECT dp.*, p.nama as produk_nama, p.kode as produk_kode, p.harga, jp.nama as jenis_nama 
    FROM detail_pesanan dp 
    JOIN produk p ON dp.produk_id = p.id 
    JOIN jenis_produk jp ON p.jenis_produk_id = jp.id 
    WHERE dp.pesanan_id = ?
");
$queryDetail->execute([$id]);
$detailPesanan = $queryDetail->fetchAll(PDO::FETCH_ASSOC);

// Ambil data pembayaran jika ada
$queryPembayaran = $dbh->prepare("
    SELECT * FROM pembayaran WHERE pesanan_id = ? ORDER BY tanggal
");
$queryPembayaran->execute([$id]);
$pembayaran = $queryPembayaran->fetchAll(PDO::FETCH_ASSOC);

// Hitung total pesanan dan total setelah diskon
$total = 0;
foreach ($detailPesanan as $detail) {
    $total += $detail['harga'] * $detail['jumlah'];
}
$totalAfterDiskon = $total - ($total * $pesanan['diskon'] / 100);

// Hitung total pembayaran
$totalPembayaran = 0;
foreach ($pembayaran as $bayar) {
    $totalPembayaran += $bayar['jumlah_bayar'];
}

// Hitung sisa yang belum dibayar
$sisaPembayaran = $totalAfterDiskon - $totalPembayaran;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #<?php echo $id; ?></title>
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
                        <h1>Detail Pesanan #<?php echo $id; ?></h1>
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
                                <h3 class="card-title">Informasi Pesanan</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 200px;">ID Pesanan</th>
                                                <td><?php echo $pesanan['id']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal</th>
                                                <td><?php echo date('d-m-Y', strtotime($pesanan['tanggal'])); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Anggota</th>
                                                <td><?php echo $pesanan['pegawai_nama']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Diskon</th>
                                                <td><?php echo $pesanan['diskon']; ?>%</td>
                                            </tr>
                                            <tr>
                                                <th>Status Pembayaran</th>
                                                <td>
                                                    <?php if ($pesanan['status_bayar']) : ?>
                                                        <span class="badge badge-success">Lunas</span>
                                                    <?php else : ?>
                                                        <span class="badge badge-warning">Belum Lunas</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-light">
                                            <div class="card-header">
                                                <h3 class="card-title">Ringkasan Pembayaran</h3>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Total Belanja</th>
                                                        <td class="text-right">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Diskon (<?php echo $pesanan['diskon']; ?>%)</th>
                                                        <td class="text-right">- Rp <?php echo number_format($total * $pesanan['diskon'] / 100, 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Setelah Diskon</th>
                                                        <td class="text-right font-weight-bold">Rp <?php echo number_format($totalAfterDiskon, 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Pembayaran</th>
                                                        <td class="text-right text-success">Rp <?php echo number_format($totalPembayaran, 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <?php if ($sisaPembayaran > 0) : ?>
                                                        <tr>
                                                            <th>Sisa Pembayaran</th>
                                                            <td class="text-right text-danger">Rp <?php echo number_format($sisaPembayaran, 0, ',', '.'); ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="mt-4 mb-3">Detail Produk</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Produk</th>
                                                <th>Harga Satuan</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($detailPesanan as $detail) {
                                                $subtotal = $detail['harga'] * $detail['jumlah'];

                                                echo "<tr>";
                                                echo "<td>" . $no++ . "</td>";
                                                echo "<td>" . $detail['produk_nama'] . " (" . $detail['produk_kode'] . ")<br><small>" . $detail['jenis_nama'] . "</small></td>";
                                                echo "<td>Rp " . number_format($detail['harga'], 0, ',', '.') . "</td>";
                                                echo "<td>" . $detail['jumlah'] . "</td>";
                                                echo "<td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            <tr class="table-light">
                                                <td colspan="4" class="text-right"><strong>Total</strong></td>
                                                <td>Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                                            </tr>
                                            <tr class="table-primary">
                                                <td colspan="4" class="text-right"><strong>Total Setelah Diskon (<?php echo $pesanan['diskon']; ?>%)</strong></td>
                                                <td>Rp <?php echo number_format($totalAfterDiskon, 0, ',', '.'); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <?php if (count($pembayaran) > 0) : ?>
                                    <h4 class="mt-4 mb-3">Riwayat Pembayaran</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>ID Pembayaran</th>
                                                    <th>Tanggal</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($pembayaran as $bayar) {
                                                    echo "<tr>";
                                                    echo "<td>" . $no++ . "</td>";
                                                    echo "<td>" . $bayar['id'] . "</td>";
                                                    echo "<td>" . date('d-m-Y', strtotime($bayar['tanggal'])) . "</td>";
                                                    echo "<td>Rp " . number_format($bayar['jumlah_bayar'], 0, ',', '.') . "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                                <tr class="table-success">
                                                    <td colspan="3" class="text-right"><strong>Total Pembayaran</strong></td>
                                                    <td>Rp <?php echo number_format($totalPembayaran, 0, ',', '.'); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>

                                <div class="mt-4">
                                    <a href="data_pesanan.php" class="btn btn-secondary">Kembali</a>
                                    <a href="edit_pesanan.php?id=<?php echo $id; ?>" class="btn btn-warning">Edit Pesanan</a>
                                    <?php if ($sisaPembayaran > 0) : ?>
                                        <a href="form_pembayaran.php?id=<?php echo $id; ?>" class="btn btn-success">Tambah Pembayaran</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
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