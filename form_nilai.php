<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Nilai</title>
</head>
<body>
    <form action="nilai_mahasiswa.php" method="POST">
        Nama : <input type="text" name="nama" value="" size="6" /></br>
        Mata Kuliah :
        <select name="matkul">
            <option value="DDP">Dasar Dasar Pemrograman</option>
            <option value="BD1">Basis Data</option>
            <option value="WEB1">Pemrograman Web</option>
        </select></br>
        Nilai UTS : <input type="number" name="nilai_uts" value="" size="6" /></br>
        Nilai UAS : <input type="number" name="nilai_uas" value="" size="6" /></br>
        Nilai Tugas/Praktikum : <input type="number" name="nilai_tugas" value="" size="6" /></br>
        <input type="submit" value="Simpan" name="proses" />
    </form>
</body>
</html>
