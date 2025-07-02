<?php
require_once 'dbkoneksi.php';

if (isset($_POST['submit'])) {

    $_nip = $_POST['nip'];
    $_nama = $_POST['nama'];
    $_jenis_kelamin = $_POST['jenis_kelamin'];
    $_jabatan = $_POST['jabatan'];

    $data = [$_nip, $_nama, $_jenis_kelamin, $_jabatan];

    $sql = "INSERT INTO pegawai (nip, nama, jenis_kelamin, jabatan) VALUES (?, ?, ?, ?)";

    $stmt = $dbh->prepare($sql);

    $stmt->execute($data);

    header("Location: data_pegawai.php");
}