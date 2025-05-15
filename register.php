<?php
require_once 'dbkoneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $nip = rand(1000000000, 9999999999);
  $jenis_kelamin = 'L';
  $jabatan = 'Staf';

  $stmt = $pdo->prepare("INSERT INTO pegawai (nip, nama, jenis_kelamin, jabatan, email, password) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$nip, $nama, $jenis_kelamin, $jabatan, $email, $password]);

  $_SESSION['user'] = ['nama' => $nama, 'email' => $email];
  header("Location: dashboard.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Register - Manajemen Koperasi Pegawai</title>
  <link href="assets/css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Create Account</h3>
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="form-floating mb-3">
                      <input class="form-control" name="nama" id="inputName" type="text" required />
                      <label for="inputName">Full Name</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" name="email" id="inputEmail" type="email" required />
                      <label for="inputEmail">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" name="password" id="inputPassword" type="password" required />
                      <label for="inputPassword">Password</label>
                    </div>
                    <div class="d-grid mt-4 mb-0">
                      <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small"><a href="index.php">Already have an account? Login</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="layoutAuthentication_footer">
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; 2023</div>
            <div><a href="#">Privacy Policy</a> &middot; <a href="#">Terms</a></div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="assets/js/scripts.js"></script>
</body>

</html>