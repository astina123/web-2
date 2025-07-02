<?php
require_once 'dbkoneksi.php';

if (isset($_POST['submit'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $jenis_produk_id = $_POST['jenis_produk_id'];

    $data = [$kode, $nama, $deskripsi, $harga, $stok, $jenis_produk_id];

    $sql = "INSERT INTO produk (kode, nama, deskripsi, harga, stok, jenis_produk_id) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $dbh->prepare($sql);

    $stmt->execute($data);

    header("Location: data_produk.php");
    exit();
}