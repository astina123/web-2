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

// Jika pesanan tidak ditemukan atau sudah lunas
if (!$pesanan || $pesanan['status_bayar'] == 1) {
    header("Location: data_pesanan.php");
    exit();
}

// Hitung total pesanan
$queryTotal = $dbh->prepare("
    SELECT SUM(p.harga * dp.jumlah) as total 
    FROM detail_pesanan dp 
    JOIN produk p ON dp.produk_id = p.id 
    WHERE dp.pesanan_id = ?
");
$queryTotal->execute([$id]);
$totalData = $queryTotal->fetch();
$total = $totalData['total'] ?? 0;

// Hitung total setelah diskon
$totalAfterDiskon = $total - ($total * $pesanan['diskon'] / 100);

// Cek total pembayaran yang sudah dilakukan
$queryPembayaran = $dbh->prepare("
    SELECT SUM(jumlah_bayar) as total_bayar FROM pembayaran WHERE pesanan_id = ?
");
$queryPembayaran->execute([$id]);
$pembayaranData = $queryPembayaran->fetch();
$totalPembayaran = $pembayaranData['total_bayar'] ?? 0;

// Hitung sisa yang harus dibayar
$sisaPembayaran = $totalAfterDiskon - $totalPembayaran;
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Form Pembayaran</title>
</head>

<body>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Form Pembayaran Pesanan #<?php echo $id; ?></h1>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Informasi Pesanan</h4>
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
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Ringkasan Tagihan</h4>
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
                                                <th>Sudah Dibayar</th>
                                                <td class="text-right text-success">Rp <?php echo number_format($totalPembayaran, 0, ',', '.'); ?></td>
                                            </tr>
                                            <tr class="table-info">
                                                <th>Sisa Pembayaran</th>
                                                <td class="text-right text-danger">Rp <?php echo number_format($sisaPembayaran, 0, ',', '.'); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <form action="proses_pembayaran.php" method="POST">
                                    <input type="hidden" name="pesanan_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="total_tagihan" value="<?php echo $totalAfterDiskon; ?>">
                                    <input type="hidden" name="total_pembayaran" value="<?php echo $totalPembayaran; ?>">
                                    <input type="hidden" name="sisa_pembayaran" value="<?php echo $sisaPembayaran; ?>">
                                    
                                    <div class="form-group row mt-4">
                                        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal Pembayaran</label>
                                        <div class="col-sm-9">
                                            <input required id="tanggal" name="tanggal" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="jumlah_bayar" class="col-sm-3 col-form-label">Jumlah Pembayaran</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input required id="jumlah_bayar" name="jumlah_bayar" type="number" class="form-control" min="1" max="<?php echo $sisaPembayaran; ?>" value="<?php echo $sisaPembayaran; ?>">
                                            </div>
                                            <small class="form-text text-muted">Maksimal pembayaran: Rp <?php echo number_format($sisaPembayaran, 0, ',', '.'); ?></small>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="bayar_lunas" class="col-sm-3 col-form-label">Status Pembayaran</label>
                                        <div class="col-sm-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="bayar_lunas" name="bayar_lunas" value="1" checked>
                                                <label class="form-check-label" for="bayar_lunas">
                                                    Tandai sebagai Lunas jika pembayaran mencukupi
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button name="submit" type="submit" class="btn btn-primary">Proses Pembayaran</button>
                                            <a href="view_pesanan.php?id=<?php echo $id; ?>" class="btn btn-secondary">Kembali</a>
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

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <?php
    include_once 'footer.php';
    ?>
</body>
</html>