<?php
require_once 'dbkoneksi.php';

if (isset($_POST['submit'])) {
    $dbh->beginTransaction();

    try {
        $tanggal = $_POST['tanggal'];
        $anggota_id = $_POST['anggota_id'];
        $diskon = $_POST['diskon'];
        $status_bayar = 0;

        $data_pesanan = [$tanggal, $diskon, $status_bayar, $anggota_id];

        $sql_pesanan = "INSERT INTO pesanan (tanggal, diskon, status_bayar, anggota_id) 
                        VALUES (?, ?, ?, ?)";
        
        $stmt_pesanan = $dbh->prepare($sql_pesanan);
        $stmt_pesanan->execute($data_pesanan);

        $pesanan_id = $dbh->lastInsertId();
        
        $produk_terpilih = false;
        if (isset($_POST['produk']) && is_array($_POST['produk'])) {
            foreach ($_POST['produk'] as $produk_id => $jumlah) {
                if ($jumlah > 0) {
                    $produk_terpilih = true;
        
                    $sql_detail = "INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah) 
                                  VALUES (?, ?, ?)";
         
                    $stmt_detail = $dbh->prepare($sql_detail);
                    $stmt_detail->execute([$pesanan_id, $produk_id, $jumlah]);
                    
                    $sql_update_stok = "UPDATE produk SET stok = stok - ? WHERE id = ?";
                    $stmt_update_stok = $dbh->prepare($sql_update_stok);
                    $stmt_update_stok->execute([$jumlah, $produk_id]);
                }
            }
        }
        
        if (!$produk_terpilih) {
            $dbh->rollBack();
            header("Location: form_pesanan.php?error=no_products");
            exit();
        }
        
        $dbh->commit();
         header("Location: data_pesanan.php?id=" . $pesanan_id);
        exit();
        
    } catch (Exception $e) {
        $dbh->rollBack();
        header("Location: form_pesanan.php?error=db_error");
        exit();
    }
} else {
    header("Location: form_pesanan.php");
    exit();
}