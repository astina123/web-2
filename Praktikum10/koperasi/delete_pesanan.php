<?php
require 'dbkoneksi.php';

// Cek apakah ada parameter id
if (!isset($_GET['id'])) {
    header("Location: data_pesanan.php");
    exit();
}

// Ambil id dari parameter URL
$id = $_GET['id'];

$checkStmt = $dbh->prepare("SELECT id FROM pesanan WHERE id = ?");
$checkStmt->execute([$id]);
if ($checkStmt->rowCount() == 0) {
    // Pesanan tidak ditemukan, redirect ke halaman data pesanan
    header("Location: data_pesanan.php");
    exit();
}

try {
    // Cek apakah pesanan memiliki pembayaran terkait
    $checkPembayaran = $dbh->prepare("SELECT id FROM pembayaran WHERE pesanan_id = ? LIMIT 1");
    $checkPembayaran->execute([$id]);
    if ($checkPembayaran->rowCount() > 0) {
        // Ada pembayaran terkait, tidak bisa menghapus
        echo "<script>
            alert('Tidak dapat menghapus pesanan karena memiliki pembayaran terkait.');
            window.location.href = 'data_pesanan.php';
            </script>";
        exit();
    }

    // Tidak ada pembayaran terkait, proses hapus data
    $sql = "DELETE FROM pesanan WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);

    // Redirect ke halaman data pesanan
    header("Location: data_pesanan.php");
} catch (PDOException $e) {
    // Handle error
    echo "<script>
        alert('Gagal menghapus pesanan: " . $e->getMessage() . "');
        window.location.href = 'data_pesanan.php';
        </script>";
}
exit();
?>