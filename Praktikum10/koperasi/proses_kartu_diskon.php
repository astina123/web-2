<?php
require_once 'dbkoneksi.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $persen_diskon = $_POST['persen_diskon'];

    if ($persen_diskon < 0) {
        $persen_diskon = 0;
    } elseif ($persen_diskon > 100) {
        $persen_diskon = 100;
    }

    $sql = "INSERT INTO kartu_diskon (nama, deskripsi, persen_diskon) VALUES (?, ?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$nama, $deskripsi, $persen_diskon]);
    header("Location: data_kartu_diskon.php");
    exit();
}