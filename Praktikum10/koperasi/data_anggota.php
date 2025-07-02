<?php
//1. sertakan koneksi database
require 'dbkoneksi.php';
include_once 'header.php';
include_once 'sidebar.php';

//2 Query untuk mendapatkan data anggota dengan join ke pegawai dan kartu_diskon
$query = $dbh->query('SELECT a.*, p.nama as nama_pegawai, p.nip, k.nama as nama_kartu, k.persen_diskon 
                     FROM anggota a 
                     LEFT JOIN pegawai p ON a.pegawai_id = p.id
                     LEFT JOIN kartu_diskon k ON a.kartu_diskon_id = k.id
                     ORDER BY a.id');
$nomor = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Anggota</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <a href="form_anggota.php"><button class="btn btn-primary mb-1">Tambah Anggota</button></a>
                                <div class="table-responsive">
                                    <table class="table table-head-fixed table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP Pegawai</th>
                                            <th>Nama Pegawai</th>
                                            <th>Status</th>
                                            <th>Kartu Diskon</th>
                                            <th>Persen Diskon</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($query as $row) {
                                            echo "<tr>";
                                            echo "<td>" . $nomor++ . "</td>";
                                            echo "<td>" . ($row['nip'] ?? '-') . "</td>";
                                            echo "<td>" . ($row['nama_pegawai'] ?? '-') . "</td>";
                                            echo "<td>" . ($row['status_aktif'] ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>') . "</td>";
                                            echo "<td>" . ($row['nama_kartu'] ?? '-') . "</td>";
                                            echo "<td>" . ($row['persen_diskon'] ? $row['persen_diskon'] . '%' : '-') . "</td>";
                                            echo "<td>
                                                <a href='edit_anggota.php?id=" . $row['id'] . "' class='btn btn-info btn-sm' style='margin-right: 5px;'>Edit</a>
                                                <a href='delete_anggota.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus anggota ini?\")'>Delete</a>
                                            </td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <?php
    include_once 'footer.php';
    ?>
</body>

</html>