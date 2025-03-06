<?php
// buat variabel yang menerima value yang dikirim dari form
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];

// LOGIKA MENGHITUNG TOTAL HARGA
$total_harga = $harga * $jumlah;

// mencetak belanjaan
echo "Total belanja Anda adalah: Rp " . number_format($total_harga, 0, ',', '.');
?>
