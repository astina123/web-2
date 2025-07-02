<?php
ob_start(); // Start output buffering at the very beginning

require_once 'dbkoneksi.php';
include_once 'header.php';
include_once 'sidebar.php';

// Cek apakah ada parameter id
if (!isset($_GET['id'])) {
    header("Location: data_produk.php");
    exit();
}

// Ambil id dari parameter URL
$id = $_GET['id'];

// Query untuk mendapatkan data produk berdasarkan id
$stmt = $dbh->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

// Jika produk tidak ditemukan, redirect ke halaman data produk
if (!$produk) {
    header("Location: data_produk.php");
    exit();
}

// Query untuk mendapatkan daftar jenis produk untuk dropdown
$queryJenis = $dbh->query('SELECT * FROM jenis_produk ORDER BY nama');

// Proses update data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $jenis_produk_id = $_POST['jenis_produk_id'];

    $sql = "UPDATE produk SET kode=?, nama=?, deskripsi=?, harga=?, stok=?, jenis_produk_id=? WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$kode, $nama, $deskripsi, $harga, $stok, $jenis_produk_id, $id]);

    header("Location: data_produk.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Edit Produk</title>
</head>

<body>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Produk</h1>
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
                                <form action="" method="POST">
                                    <div class="form-group row">
                                        <label for="kode" class="col-4 col-form-label">Kode Produk</label>
                                        <div class="col-8">
                                            <input required id="kode" name="kode" type="text" class="form-control" value="<?php echo $produk['kode']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama" class="col-4 col-form-label">Nama Produk</label>
                                        <div class="col-8">
                                            <input required id="nama" name="nama" type="text" class="form-control" value="<?php echo $produk['nama']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-4 col-form-label">Deskripsi</label>
                                        <div class="col-8">
                                            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"><?php echo $produk['deskripsi']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="harga" class="col-4 col-form-label">Harga (Rp)</label>
                                        <div class="col-8">
                                            <input required id="harga" name="harga" type="number" class="form-control" min="0" value="<?php echo $produk['harga']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="stok" class="col-4 col-form-label">Stok</label>
                                        <div class="col-8">
                                            <input required id="stok" name="stok" type="number" class="form-control" min="0" value="<?php echo $produk['stok']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jenis_produk_id" class="col-4 col-form-label">Jenis Produk</label>
                                        <div class="col-8">
                                            <select required id="jenis_produk_id" name="jenis_produk_id" class="form-control">
                                                <?php
                                                foreach ($queryJenis as $jenis) {
                                                    $selected = ($jenis['id'] == $produk['jenis_produk_id']) ? 'selected' : '';
                                                    echo "<option value='" . $jenis['id'] . "' " . $selected . ">" . $jenis['nama'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-4 col-8">
                                            <button name="submit" type="submit" class="btn btn-primary">Update</button>
                                            <a href="data_produk.php" class="btn btn-secondary">Kembali</a>
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
<?php
ob_end_flush(); // Flush the output buffer and turn off output buffering
?>