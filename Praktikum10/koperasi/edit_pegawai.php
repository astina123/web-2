<?php
ob_start(); // Start output buffering at the very beginning

require_once 'dbkoneksi.php';
include_once 'header.php';
include_once 'sidebar.php';
?>

<?php
require 'dbkoneksi.php';

if (!isset($_GET['id'])) {
    header("Location: data_pegawai.php");
    exit();
    ob_end_flush();
}

$id = $_GET['id'];

$stmt = $dbh->prepare("SELECT * FROM pegawai WHERE id=?");
$stmt->execute([$id]);
$pegawai = $stmt->fetch();

if (!$pegawai) {
    header("Location: data_pegawai.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jabatan = $_POST['jabatan'];

    $sql = "UPDATE pegawai SET nip=?, nama=?, jenis_kelamin=?, jabatan=? WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$nip, $nama, $jenis_kelamin, $jabatan, $id]);

    header("Location: data_pegawai.php");
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

    <title>Edit Pegawai</title>
</head>

<body>
    <div class="container mt-2">
        <h2 class="text-center">Edit Pegawai</h2>
        <form action="" method="POST">
            <div class="form-group row mt-3">
                <label for="nip" class="col-4 col-form-label">NIP</label>
                <div class="col-8">
                    <input required id="nip" name="nip" type="text" class="form-control" value="<?php echo $pegawai['nip']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="nama" class="col-4 col-form-label">Nama</label>
                <div class="col-8">
                    <input required id="nama" name="nama" type="text" class="form-control" value="<?php echo $pegawai['nama']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis_kelamin" class="col-4 col-form-label">Jenis Kelamin</label>
                <div class="col-8">
                    <select required id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" <?php echo ($pegawai['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?php echo ($pegawai['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="jabatan" class="col-4 col-form-label">Jabatan</label>
                <div class="col-8">
                    <input required id="jabatan" name="jabatan" type="text" class="form-control" value="<?php echo $pegawai['jabatan']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button name="submit" type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
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