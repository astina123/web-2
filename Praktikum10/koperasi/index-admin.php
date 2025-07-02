<?php 

require_once 'header.php'; 
require_once 'sidebar.php';

$host = 'localhost';
$db = 'dbkoperasi';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$dbh = new PDO($dsn, $user, $pass, $opt);
function executeQuery($sql, $params = []) {
    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getSingleValue($sql, $params = []) {
    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_NUM);
    return $result ? $result[0] : 0;
}

$totalProduk = getSingleValue("SELECT COUNT(*) FROM produk");

$totalAnggota = getSingleValue("SELECT COUNT(*) FROM anggota WHERE status_aktif = true");

$totalPesanan = getSingleValue("SELECT COUNT(*) FROM pesanan");

$totalPendapatan = getSingleValue("SELECT SUM(jumlah_bayar) FROM pembayaran");

$belumBayar = getSingleValue("SELECT COUNT(*) FROM pesanan WHERE status_bayar = false");

$produkTerlaris = executeQuery("
    SELECT p.nama, SUM(dp.jumlah) as total_terjual 
    FROM detail_pesanan dp
    JOIN produk p ON dp.produk_id = p.id
    GROUP BY dp.produk_id
    ORDER BY total_terjual DESC
    LIMIT 5
");

$stokRendah = executeQuery("
    SELECT nama, stok 
    FROM produk 
    ORDER BY stok ASC 
    LIMIT 5
");

$pesananTerbaru = executeQuery("
    SELECT ps.id, ps.tanggal, pg.nama as nama_anggota, 
           CASE WHEN ps.status_bayar = 1 THEN 'Lunas' ELSE 'Belum Bayar' END as status
    FROM pesanan ps
    JOIN anggota a ON ps.anggota_id = a.id
    JOIN pegawai pg ON a.pegawai_id = pg.id
    ORDER BY ps.tanggal DESC
    LIMIT 5
");

$produkPerKategori = executeQuery("
    SELECT jp.nama, COUNT(p.id) as jumlah
    FROM produk p
    JOIN jenis_produk jp ON p.jenis_produk_id = jp.id
    GROUP BY p.jenis_produk_id
");

$labelKategori = [];
$dataKategori = [];
foreach ($produkPerKategori as $item) {
    $labelKategori[] = $item['nama'];
    $dataKategori[] = $item['jumlah'];
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard Koperasi</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-bag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Produk</span>
                            <span class="info-box-number"><?= $totalProduk ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Anggota</span>
                            <span class="info-box-number"><?= $totalAnggota ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pesanan</span>
                            <span class="info-box-number"><?= $totalPesanan ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-bill"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pendapatan</span>
                            <span class="info-box-number">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Produk per Kategori Chart -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Produk per Kategori</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="produkPerKategoriChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Pesanan Belum Bayar -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Status Pesanan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box bg-danger">
                                        <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Belum Bayar</span>
                                            <span class="info-box-number"><?= $belumBayar ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box bg-success">
                                        <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Sudah Bayar</span>
                                            <span class="info-box-number"><?= $totalPesanan - $belumBayar ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <span class="progress-text">Persentase Pembayaran</span>
                                <span class="float-right"><b><?= ($totalPesanan > 0) ? round((($totalPesanan - $belumBayar) / $totalPesanan) * 100) : 0 ?>%</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: <?= ($totalPesanan > 0) ? round((($totalPesanan - $belumBayar) / $totalPesanan) * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Produk Terlaris -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Produk Terlaris</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Total Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produkTerlaris as $produk): ?>
                                    <tr>
                                        <td><?= $produk['nama'] ?></td>
                                        <td><?= $produk['total_terjual'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Stok Terendah -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Stok Produk Terendah</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stokRendah as $produk): ?>
                                    <tr>
                                        <td><?= $produk['nama'] ?></td>
                                        <td><?= $produk['stok'] ?></td>
                                        <td>
                                            <?php if ($produk['stok'] <= 5): ?>
                                                <span class="badge bg-danger">Kritis</span>
                                            <?php elseif ($produk['stok'] <= 20): ?>
                                                <span class="badge bg-warning">Perlu Restock</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Cukup</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pesanan Terbaru -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pesanan Terbaru</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Nama Anggota</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pesananTerbaru as $pesanan): ?>
                                    <tr>
                                        <td><?= $pesanan['id'] ?></td>
                                        <td><?= date('d M Y', strtotime($pesanan['tanggal'])) ?></td>
                                        <td><?= $pesanan['nama_anggota'] ?></td>
                                        <td>
                                            <?php if ($pesanan['status'] == 'Lunas'): ?>
                                                <span class="badge bg-success">Lunas</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Belum Bayar</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- Page specific script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Produk per Kategori Chart
    var produkCtx = document.getElementById('produkPerKategoriChart').getContext('2d');
    var produkPerKategoriChart = new Chart(produkCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($labelKategori) ?>,
            datasets: [{
                data: <?= json_encode($dataKategori) ?>,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
        }
    });
});
</script>

<?php require_once 'footer.php'; ?>