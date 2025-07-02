<?php
ob_start(); // Start output buffering at the very beginning

require_once 'dbkoneksi.php';
include_once 'header.php';
include_once 'sidebar.php';

// Cek apakah ada parameter id
if (!isset($_GET['id'])) {
    header("Location: data_anggota.php");
    exit();
}

// Ambil id dari parameter URL
$id = $_GET['id'];

// Query untuk mendapatkan data anggota berdasarkan id
$stmt = $dbh->prepare("SELECT * FROM anggota WHERE id = ?");
$stmt->execute([$id]);
$anggota = $stmt->fetch();

// Jika anggota tidak ditemukan, redirect ke halaman data anggota
if (!$anggota) {
    header("Location: data_anggota.php");
    exit();
}

// Query untuk mendapatkan daftar pegawai untuk dropdown
$queryPegawai = $dbh->query('SELECT * FROM pegawai ORDER BY nama');

// Query untuk mendapatkan daftar kartu diskon untuk dropdown
$queryKartu = $dbh->query('SELECT * FROM kartu_diskon ORDER BY nama');

// Proses update data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status_aktif = $_POST['status_aktif'];
    
    // Jika pegawai_id atau kartu_diskon_id tidak dipilih, set ke NULL
    $pegawai_id = !empty($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
    $kartu_diskon_id = !empty($_POST['kartu_diskon_id']) ? $_POST['kartu_diskon_id'] : null;

    $sql = "UPDATE anggota SET status_aktif=?, pegawai_id=?, kartu_diskon_id=? WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$status_aktif, $pegawai_id, $kartu_diskon_id, $id]);

    header("Location: data_anggota.php");
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

    <title>Edit Anggota</title>
</head>

<body>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Anggota</h1>
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
                                        <label for="status_aktif" class="col-4 col-form-label">Status Anggota</label>
                                        <div class="col-8">
                                            <select required id="status_aktif" name="status_aktif" class="form-control">
                                                <option value="1" <?php echo ($anggota['status_aktif'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                                                <option value="0" <?php echo ($anggota['status_aktif'] == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pegawai_id" class="col-4 col-form-label">Pegawai</label>
                                        <div class="col-8">
                                            <select id="pegawai_id" name="pegawai_id" class="form-control">
                                                <option value="">-- Pilih Pegawai --</option>
                                                <?php
                                                foreach ($queryPegawai as $pegawai) {
                                                    $selected = ($pegawai['id'] == $anggota['pegawai_id']) ? 'selected' : '';
                                                    echo "<option value='" . $pegawai['id'] . "' " . $selected . ">" . $pegawai['nip'] . " - " . $pegawai['nama'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <small class="form-text text-muted">Opsional. Pilih pegawai jika anggota adalah pegawai.</small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kartu_diskon_id" class="col-4 col-form-label">Kartu Diskon</label>
                                        <div class="col-8">
                                            <select id="kartu_diskon_id" name="kartu_diskon_id" class="form-control">
                                                <option value="">-- Pilih Kartu Diskon --</option>
                                                <?php
                                                foreach ($queryKartu as $kartu) {
                                                    $selected = ($kartu['id'] == $anggota['kartu_diskon_id']) ? 'selected' : '';
                                                    echo "<option value='" . $kartu['id'] . "' " . $selected . ">" . $kartu['nama'] . " (" . $kartu['persen_diskon'] . "%)</option>";
                                                }
                                                ?>
                                            </select>
                                            <small class="form-text text-muted">Opsional. Pilih kartu diskon untuk anggota.</small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-4 col-8">
                                            <button name="submit" type="submit" class="btn btn-primary">Update</button>
                                            <a href="data_anggota.php" class="btn btn-secondary">Kembali</a>
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