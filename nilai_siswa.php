<?php
$proses = $_POST['proses'];
$nama_siswa = $_POST['nama'];
$mata_kuliah = $_POST['matkul'];
$nilai_uts = $_POST['nilai_uts'];
$nilai_uas = $_POST['nilai_uas'];
$nilai_tugas = $_POST['nilai_tugas'];

/* MENENTUKAN LULUS ATAU TIDAK MENGGUNAKAN IF ELSE
SISWA DINYATAKAN LULUS JIKA NILAI TOTAL dengan presentase 30% UTS, 35% UAS dan TUGAS 35% melebihi 55+ */

/* MENENTUKAN GRADE NILAI MENGGUNAKAN IF ELSE
0-35 = E
36-55 = D
56-69 = C
70-84 = B
85-100 = A
< 0 || > 100 = I
*/

/* MENENTUKAN PREDIKAT NILAI MENGGUNAKAN SWITCH
E = Sangat Kurang
D = Kurang
C = Cukup
B = Memuaskan
A = Sangat Memuaskan
I = Tidak ada
*/

if (!empty($proses)) {
    echo 'Proses : ' . $proses;
    echo '<br/>Nama : ' . $nama_siswa;
    echo '<br/>Mata Kuliah : ' . $mata_kuliah;
    echo '<br/>Nilai UTS : ' . $nilai_uts;
    echo '<br/>Nilai UAS : ' . $nilai_uas;
    echo '<br/>Nilai Tugas Praktikum : ' . $nilai_tugas;
    // echo '<br/>Nilai Akhir : ' . number_format($nilai_akhir, 2, ',', '.');
    // echo '<br/>Status : ' . $status;
    // echo '<br/>Grade : ' . $grade;
    // echo '<br/>Predikat : ' . $predikat;
}
?>
