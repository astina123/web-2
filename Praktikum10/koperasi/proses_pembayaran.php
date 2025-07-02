<?php
require 'dbkoneksi.php';

if (isset($_POST['submit'])) {
    $pesanan_id = $_POST['pesanan_id'];
    $tanggal = $_POST['tanggal'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $sisa_pembayaran = $_POST['sisa_pembayaran'];
    $bayar_lunas = isset($_POST['bayar_lunas']) ? 1 : 0;

    // Validasi jumlah pembayaran
    if ($jumlah_bayar <= 0 || $jumlah_bayar > $sisa_pembayaran) {
        header("Location: form_pembayaran.php?id=" . $pesanan_id . "&error=invalid_amount");
        exit();
    }

    $dbh->beginTransaction();

    try {
        // Insert data pembayaran
        $sql_pembayaran = "INSERT INTO pembayaran (jumlah_bayar, tanggal, pesanan_id) VALUES (?, ?, ?)";
        $stmt_pembayaran = $dbh->prepare($sql_pembayaran);
        $stmt_pembayaran->execute([$jumlah_bayar, $tanggal, $pesanan_id]);

        // Update status pesanan jika bayar lunas dan jumlah pembayaran mencukupi
        if ($bayar_lunas && $jumlah_bayar >= $sisa_pembayaran) {
            $sql_update_status = "UPDATE pesanan SET status_bayar = 1 WHERE id = ?";
            $stmt_update_status = $dbh->prepare($sql_update_status);
            $stmt_update_status->execute([$pesanan_id]);
        }

        $dbh->commit();
        header("Location: view_pesanan.php?id=" . $pesanan_id);
        exit();
    } catch (Exception $e) {
        $dbh->rollBack();
        header("Location: form_pembayaran.php?id=" . $pesanan_id . "&error=db_error");
        exit();
    }
} else {
    header("Location: data_pesanan.php");
    exit();
}