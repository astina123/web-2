<?php
require 'dbkoneksi.php';

if (!isset($_GET['id'])) {
    header("Location: data_kartu_diskon.php");
    exit();
}

$id = $_GET['id'];

$checkStmt = $dbh->prepare("SELECT id FROM kartu_diskon WHERE id = ?");
$checkStmt->execute([$id]);
if ($checkStmt->rowCount() == 0) {
    header("Location: data_kartu_diskon.php");
    exit();
}

try {
    $checkAnggota = $dbh->prepare("SELECT id FROM anggota WHERE kartu_diskon_id = ? LIMIT 1");
    $checkAnggota->execute([$id]);
    if ($checkAnggota->rowCount() > 0) {
        echo "<script>
            alert('Tidak dapat menghapus kartu diskon karena digunakan oleh anggota.');
            window.location.href = 'data_kartu_diskon.php';
            </script>";
        exit();
    }

    $sql = "DELETE FROM kartu_diskon WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);

    header("Location: data_kartu_diskon.php");
} catch (PDOException $e) {
    echo "<script>
        alert('Gagal menghapus kartu diskon: " . $e->getMessage() . "');
        window.location.href = 'data_kartu_diskon.php';
        </script>";
}
exit();
?>