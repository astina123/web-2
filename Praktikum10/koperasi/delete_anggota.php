<?php
require 'dbkoneksi.php';

if (!isset($_GET['id'])) {
    header("Location: data_anggota.php");
    exit();
}

$id = $_GET['id'];

$checkStmt = $dbh->prepare("SELECT id FROM anggota WHERE id = ?");
$checkStmt->execute([$id]);
if ($checkStmt->rowCount() == 0) {
    header("Location: data_anggota.php");
    exit();
}

try {
    $checkPesanan = $dbh->prepare("SELECT id FROM pesanan WHERE anggota_id = ? LIMIT 1");
    $checkPesanan->execute([$id]);
    if ($checkPesanan->rowCount() > 0) {
        echo "<script>
            alert('Tidak dapat menghapus anggota karena memiliki pesanan terkait.');
            window.location.href = 'data_anggota.php';
            </script>";
        exit();
    }

    $sql = "DELETE FROM anggota WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);

    header("Location: data_anggota.php");
} catch (PDOException $e) {
    echo "<script>
        alert('Gagal menghapus anggota: " . $e->getMessage() . "');
        window.location.href = 'data_anggota.php';
        </script>";
}
exit();
?>