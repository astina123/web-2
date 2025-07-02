<?php
require_once 'dbkoneksi.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $deskripsi = !empty($_POST['deskripsi']) ? $_POST['deskripsi'] : null;

    if (empty($nama)) {
        echo "<script>
            alert('Nama jenis produk tidak boleh kosong.');
            window.history.back();
            </script>";
        exit();
    }

    $sql = "INSERT INTO jenis_produk (nama, deskripsi) VALUES (?, ?)";

    $stmt = $dbh->prepare($sql);

    $stmt->execute([$nama, $deskripsi]);

    header("Location: data_jenis_produk.php");
    exit();
}