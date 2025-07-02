<?php
$ar_prodi = [
    "SI" => "Sistem Informasi",
    "TI" => "Teknik Informatika",
    "BD" => "Bisnis Digital"
];
$ar_skill = [
    "HTML" => 10,
    "CSS" => 10,
    "JavaScript" => 20,
    "RWD Bootstrap" => 20,
    "PHP" => 30,
    "Python" => 30,
    "Java" => 50
];
$ar_domisili = [
    "Jakarta",
    "Bogor",
    "Depok",
    "Tanggerang",
    "Bekasi",
    "Lainnya"
];
function skor_skill($pilihan) {
    global $ar_skill;
    $skor = 0;
    foreach ($pilihan as $skill) {
        if (isset($ar_skill[$skill])) {
            $skor += $ar_skill[$skill];
        }
    }
    return $skor;
}

function kategori_skill($skor) {
    if ($skor <= 0) {
        return "Tidak Memadai";
    } elseif ($skor <= 40) {
        return "Kurang";
    } elseif ($skor <= 60) {
        return "Cukup";
    } elseif ($skor <= 100) {
        return "Baik";
    } elseif ($skor <= 150) {
        return "Sangat Baik";
    } elseif ($skor <= 170) {
        return "Sepuh";
    } else {
        return "Invalid";
    }
}

if (isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jk = $_POST['jenis_kelamin'];
    $prodi = $_POST['prodi'];
    $domisili = $_POST['domisili'];
    $email = $_POST['email'];
    $skill_pilihan = isset($_POST['skill']) ? $_POST['skill'] : [];

    $skor = skor_skill($skill_pilihan);
    $kategori = kategori_skill($skor);
?>

<?php require_once 'header.php' ?>
<?php require_once 'sidebar.php' ?>
<div class="content-wrapper">
    <div class="content">
        <div class="container">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .result {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .result h2 {
            margin-bottom: 20px;
        }
        .list-group-item {
            background-color: transparent;
            border: none;
            padding: 5px 0;
        }
        .list-group-item strong {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="result">
            <h2>Hasil Registrasi</h2>
            <ul class="list-group">
                <li class="list-group-item"><strong>NIM :</strong> <?= $nim ?></li>
                <li class="list-group-item"><strong>Nama :</strong> <?= $nama ?></li>
                <li class="list-group-item"><strong>Jenis Kelamin :</strong> <?= $jk ?></li>
                <li class="list-group-item"><strong>Program Studi :</strong> <?= $ar_prodi[$prodi] ?></li>
                <li class="list-group-item"><strong>Skill :</strong> <?= implode(", ", $skill_pilihan) ?></li>
                <li class="list-group-item"><strong>Skor Skill :</strong> <?= $skor ?></li>
                <li class="list-group-item"><strong>Kategori Skill :</strong> <?= $kategori ?></li>
                <li class="list-group-item"><strong>Email :</strong> <?= $domisili ?></li>
                <li class="list-group-item"><strong>Email :</strong> <?= $email ?></li>
            </ul>
        </div>
    </div>
</div>
</div>
</div>

<?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php require_once 'footer.php' ?>
