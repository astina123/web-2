<?php
require_once "../dbkoneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $jenis_produk_id = $_POST['jenis_produk_id'];

    $sql = "INSERT INTO produk (kode, nama, deskripsi, harga, stok, jenis_produk_id)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$kode, $nama, $deskripsi, $harga, $stok, $jenis_produk_id]);

    header("Location: index.php");
    exit;
}

// Ambil data jenis produk untuk dropdown
$jenis_produk = $pdo->query("SELECT * FROM jenis_produk")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tambah Produk - Manajemen Koperasi Pegawai</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include_once "../layout/header.php" ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include_once "../layout/sidebar.php" ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tambah Produk</h1>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Kode</label>
                            <input type="text" name="kode" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Produk</label>
                            <select name="jenis_produk_id" class="form-control" required>
                                <option value="">Pilih Jenis Produk</option>
                                <?php foreach ($jenis_produk as $jp): ?>
                                    <option value="<?= $jp['id'] ?>"><?= $jp['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </main>
            <?php include_once "../layout/footer.php" ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>