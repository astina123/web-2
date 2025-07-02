<?php
ob_start(); // Start output buffering at the very beginning

require_once 'dbkoneksi.php';
include_once 'header.php';
include_once 'sidebar.php';

// Cek apakah ada parameter id
if (!isset($_GET['id'])) {
    header("Location: data_jenis_produk.php");
    exit();
}

// Ambil id dari parameter URL
$id = $_GET['id'];

// Query untuk mendapatkan data jenis produk berdasarkan id
$stmt = $dbh->prepare("SELECT * FROM jenis_produk WHERE id = ?");
$stmt->execute([$id]);
$jenis = $stmt->fetch();

// Jika jenis produk tidak ditemukan, redirect ke halaman data jenis produk
if (!$jenis) {
    header("Location: data_jenis_produk.php");
    exit();
}

// Proses update data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $deskripsi = !empty($_POST['deskripsi']) ? $_POST['deskripsi'] : null;

    // Validasi input
    if (empty($nama)) {
        echo "<script>
            alert('Nama jenis produk tidak boleh kosong.');
            window.history.back();
            </script>";
        exit();
    }

    $sql = "UPDATE jenis_produk SET nama=?, deskripsi=? WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$nama, $deskripsi, $id]);

    header("Location: data_jenis_produk.php");
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

    <title>Edit Jenis Produk</title>
</head>

<body>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Jenis Produk</h1>
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
                                        <label for="nama" class="col-4 col-form-label">Nama Jenis</label>
                                        <div class="col-8">
                                            <input required id="nama" name="nama" type="text" class="form-control" 
                                                value="<?php echo htmlspecialchars($jenis['nama']); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-4 col-form-label">Deskripsi</label>
                                        <div class="col-8">
                                            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"><?php echo htmlspecialchars($jenis['deskripsi'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-4 col-8">
                                            <button name="submit" type="submit" class="btn btn-primary">Update</button>
                                            <a href="data_jenis_produk.php" class="btn btn-secondary">Kembali</a>
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