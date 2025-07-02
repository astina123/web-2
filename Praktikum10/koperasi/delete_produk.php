<?php
require 'dbkoneksi.php';

if (!isset($_GET['id'])) {
    header("Location: data_produk.php");
    exit();
}

$id = $_GET['id'];

$checkStmt = $dbh->prepare("SELECT id FROM produk WHERE id = ?");
$checkStmt->execute([$id]);
if ($checkStmt->rowCount() == 0) {
    header("Location: data_produk.php");
    exit();
}

$sql = "DELETE FROM produk WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$id]);

header("Location: data_produk.php");
exit();
?>