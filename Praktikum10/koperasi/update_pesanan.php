<?php
require 'dbkoneksi.php';

if (isset($_POST['submit'])) {
    $dbh->beginTransaction();

    try {
        $id = $_POST['id'];
        $tanggal = $_POST['tanggal'];
        $anggota_id = $_POST['anggota_id'];
        $diskon = $_POST['diskon'];

        // Check if order exists
        $checkOrder = $dbh->prepare("SELECT status_bayar FROM pesanan WHERE id = ?");
        $checkOrder->execute([$id]);
        $orderData = $checkOrder->fetch(PDO::FETCH_ASSOC);
        
        if (!$orderData) {
            // Order not found
            $dbh->rollBack();
            header("Location: data_pesanan.php");
            exit();
        }

        // Update pesanan
        $sql_pesanan = "UPDATE pesanan SET tanggal = ?, diskon = ?, anggota_id = ? WHERE id = ?";
        $stmt_pesanan = $dbh->prepare($sql_pesanan);
        $stmt_pesanan->execute([$tanggal, $diskon, $anggota_id, $id]);

        // If order is not paid yet, update product details
        if ($orderData['status_bayar'] == 0) {
            // Get current details to restore stock before updating
            $currentDetails = $dbh->prepare("SELECT produk_id, jumlah FROM detail_pesanan WHERE pesanan_id = ?");
            $currentDetails->execute([$id]);
            $details = $currentDetails->fetchAll(PDO::FETCH_ASSOC);

            // Restore stock for products in current order
            foreach ($details as $detail) {
                $sql_restore_stock = "UPDATE produk SET stok = stok + ? WHERE id = ?";
                $stmt_restore_stock = $dbh->prepare($sql_restore_stock);
                $stmt_restore_stock->execute([$detail['jumlah'], $detail['produk_id']]);
            }

            // Delete all current details
            $sql_delete_details = "DELETE FROM detail_pesanan WHERE pesanan_id = ?";
            $stmt_delete_details = $dbh->prepare($sql_delete_details);
            $stmt_delete_details->execute([$id]);

            // Insert new details
            $produk_terpilih = false;
            if (isset($_POST['produk']) && is_array($_POST['produk'])) {
                foreach ($_POST['produk'] as $produk_id => $jumlah) {
                    if ($jumlah > 0) {
                        $produk_terpilih = true;

                        // Insert new detail
                        $sql_detail = "INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah) 
                                  VALUES (?, ?, ?)";
                        $stmt_detail = $dbh->prepare($sql_detail);
                        $stmt_detail->execute([$id, $produk_id, $jumlah]);

                        // Update stock
                        $sql_update_stok = "UPDATE produk SET stok = stok - ? WHERE id = ?";
                        $stmt_update_stok = $dbh->prepare($sql_update_stok);
                        $stmt_update_stok->execute([$jumlah, $produk_id]);
                    }
                }
            }

            if (!$produk_terpilih) {
                $dbh->rollBack();
                header("Location: edit_pesanan.php?id=" . $id . "&error=no_products");
                exit();
            }
        }

        $dbh->commit();
        header("Location: data_pesanan.php");
        exit();

    } catch (Exception $e) {
        $dbh->rollBack();
        header("Location: edit_pesanan.php?id=" . $_POST['id'] . "&error=db_error");
        exit();
    }
} else {
    header("Location: data_pesanan.php");
    exit();
}