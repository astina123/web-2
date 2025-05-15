<?php
require_once "../dbkoneksi.php";

if (isset($_GET['id'])) {
   $id = $_GET['id'];

   // Hapus data produk
   $sql = "DELETE FROM produk WHERE id = ?";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$id]);

   header("Location: index.php");
   exit;
} else {
   header("Location: index.php");
   exit;
}
