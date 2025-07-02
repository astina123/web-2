<?php
require_once 'dbkoneksi.php';

if (isset($_POST['submit'])) {
    $status_aktif = $_POST['status_aktif'];
  
    $pegawai_id = !empty($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
    $kartu_diskon_id = !empty($_POST['kartu_diskon_id']) ? $_POST['kartu_diskon_id'] : null;

    if ($pegawai_id && $kartu_diskon_id) {
        $sql = "INSERT INTO anggota (status_aktif, pegawai_id, kartu_diskon_id) VALUES (?, ?, ?)";
        $data = [$status_aktif, $pegawai_id, $kartu_diskon_id];
    } elseif ($pegawai_id) {
        $sql = "INSERT INTO anggota (status_aktif, pegawai_id) VALUES (?, ?)";
        $data = [$status_aktif, $pegawai_id];
    } elseif ($kartu_diskon_id) {
        $sql = "INSERT INTO anggota (status_aktif, kartu_diskon_id) VALUES (?, ?)";
        $data = [$status_aktif, $kartu_diskon_id];
    } else {
        $sql = "INSERT INTO anggota (status_aktif) VALUES (?)";
        $data = [$status_aktif];
    }

    $stmt = $dbh->prepare($sql);

    $stmt->execute($data);

    header("Location: data_anggota.php");
    exit();
}