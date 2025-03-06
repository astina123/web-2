<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer = $_POST['customer'];
    $product = $_POST['product'];
    $jumlah = $_POST['jumlah'];

    $harga_produk = [
        "TV" => 4200000,
        "Kulkas" => 3100000,
        "Mesin Cuci" => 3800000
    ];

    $total = $harga_produk[$product] * $jumlah;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belanja Online</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Belanja Online</h2>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Customer</label>
            <input type="text" name="customer" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilih Produk</label><br>
            <input type="radio" name="product" value="TV" required> TV
            <input type="radio" name="product" value="Kulkas"> Kulkas
            <input type="radio" name="product" value="Mesin Cuci"> Mesin Cuci
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <hr>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
        <h4>Hasil Belanja</h4>
        <p>Nama Customer: <?= htmlspecialchars($customer) ?></p>
        <p>Produk Pilihan: <?= htmlspecialchars($product) ?></p>
        <p>Jumlah Beli: <?= htmlspecialchars($jumlah) ?></p>
        <p>Total Belanja: Rp. <?= number_format($total, 2, ',', '.') ?></p>
    <?php endif; ?>

    <div class="mt-4 p-3 bg-primary text-white">
        <h5>Daftar Harga</h5>
        <ul>
            <li>TV: Rp. 4.200.000</li>
            <li>Kulkas: Rp. 3.100.000</li>
            <li>Mesin Cuci: Rp. 3.800.000</li>
        </ul>
        <p>Harga Dapat Berubah Setiap Saat</p>
    </div>

</body>
</html>
