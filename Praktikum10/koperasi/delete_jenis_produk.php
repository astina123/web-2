<?php
require 'dbkoneksi.php';

if (!isset($_GET['id'])) {
    header("Location: data_jenis_produk.php");
    exit();
}

$id = $_GET['id'];

$checkStmt = $dbh->prepare("SELECT id FROM jenis_produk WHERE id = ?");
$checkStmt->execute([$id]);
if ($checkStmt->rowCount() == 0) {
    header("Location: data_jenis_produk.php");
    exit();
}

try {
    $checkProduk = $dbh->prepare("SELECT id FROM produk WHERE jenis_produk_id = ? LIMIT 1");
    $checkProduk->execute([$id]);
    if ($checkProduk->rowCount() > 0) {
        echo "<script>
            alert('Tidak dapat menghapus jenis produk karena memiliki produk terkait.');
            window.location.href = 'data_jenis_produk.php';
            </script>";
        exit();
    }

    $sql = "DELETE FROM jenis_produk WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);

    header("Location: data_jenis_produk.php");
} catch (PDOException $e) {
    echo "<script>
        alert('Gagal menghapus jenis produk: " . $e->getMessage() . "');
        window.location.href = 'data_jenis_produk.php';
        </script>";
}
exit();
?>