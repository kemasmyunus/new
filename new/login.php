<?php
session_start();
include('koneksi.php');
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $level = $_POST['level'];

  // Query untuk memeriksa username, password, dan level
  $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND level = '$level'");

  $cek = mysqli_num_rows($result);

  if ($cek > 0) {
    $data = mysqli_fetch_assoc($result);

    // Cek status verifikasi
    if ($data['verifikasi'] == 'Sudah Terverifikasi') {
      $user_id = $data['id'];

      // Ambil data penduduk yang terkait dengan user_id
      $penduduk_result = mysqli_query($koneksi, "SELECT * FROM penduduk WHERE user_id = '$user_id'");
      $data_penduduk = mysqli_fetch_assoc($penduduk_result);

      // Tambahkan pemeriksaan khusus untuk level "warga"
      if ($level == 'pelanggan') {
        if ($penduduk_result && mysqli_num_rows($penduduk_result) > 0) {
          $penduduk_nik = $data_penduduk['nik'];

          // Periksa apakah NIK penduduk ada di tabel SKK dengan kolom nik2
          $skk_result = mysqli_query($koneksi, "SELECT * FROM skk WHERE nik2 = '$penduduk_nik'");
          if ($skk_result && mysqli_num_rows($skk_result) > 0) {
            echo "<script>alert('Akun Anda sudah dinonaktifkan. Hubungi administrator.');window.location='login.php';</script>";
            exit();
          }
        }
      }

      // Set session untuk pengguna
      $_SESSION['username'] = $username;
      $_SESSION['status'] = 'sudah_login';
      $_SESSION['user_id'] = $data['id'];
      $_SESSION['level'] = $data['level'];
      $_SESSION['nama'] = $data['nama'];

      if ($penduduk_result && mysqli_num_rows($penduduk_result) > 0) {
        $_SESSION['penduduk'] = $data_penduduk;
      } else {
        $_SESSION['penduduk'] = null;
      }

      $_SESSION['penduduk_id'] = $data_penduduk['id'] ?? null;
      $_SESSION['penduduk_nik'] = $data_penduduk['nik'] ?? null;
      $_SESSION['penduduk_nama'] = $data_penduduk['nama'] ?? null;
      $_SESSION['penduduk_tgl'] = $data_penduduk['tgl'] ?? null;
      $_SESSION['penduduk_jk'] = $data_penduduk['jk'] ?? null;
      $_SESSION['penduduk_agama'] = $data_penduduk['agama'] ?? null;
      $_SESSION['penduduk_alamat'] = $data_penduduk['alamat'] ?? null;
      $_SESSION['penduduk_user_id'] = $data_penduduk['user_id'] ?? null;
      $_SESSION['penduduk_pekerjaan'] = $data_penduduk['pekerjaan'] ?? null;
      $_SESSION['penduduk_warga'] = $data_penduduk['warga'] ?? null;

      // Redirect ke halaman utama
      header("location:index.php");
    } else {
      echo "<script>alert('Akun belum terverifikasi! Silakan hubungi administrator.');window.location='login.php';</script>";
    }
  } else {
    echo "<script>alert('Gagal Login! Username / Password / Level Salah.');window.location='login.php';</script>";
  }
}

?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Kantor</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif;
      background-image: url('assets/img/Foto.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      padding: 30px;
      max-width: 400px;
      width: 100%;
      text-align: center;
    }

    .login-logo img {
      width: 50%;
      margin-bottom: 20px;
    }

    .login-card-body {
      background: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      padding: 20px;
    }

    .input-group-text {
      background: #f4f6f9;
    }

    .btn-success {
      width: 100%;
      border-radius: 50px;
      padding: 10px;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    .btn-success:hover {
      background: #28a745;
    }

    .text-danger {
      font-weight: bold;
    }

    .btn-register {
      background: #007bff;
      border-radius: 50px;
      padding: 10px;
      font-size: 16px;
      transition: background 0.3s ease;
      color: white;
    }

    .btn-register:hover {
      background: #0056b3;
    }
  </style>
</head>

<body>
  <div class="login-box">
    <div class="login-logo">
      <img src="assets/img/logo-desa.png" alt="Logo">
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg text-warning">LOGIN </p>

        <form action="" method="post" role="form">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="ketikkan username.." name="username" required="" autofocus="">
            <div class="input-group-append">
              <div class="input-group-text">
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="ketikkan password.." name="password" required="">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select class="form-control" name="level" required="">
              <option value="admin">Admin</option>
              <option value="pelanggan">Warga</option>
              <option value="pimpinan">Pimpinan</option>
            </select>
          </div>
          <div class="row">
            <div class="col-6">
              <a href="register.php" class="btn btn-register">Daftar Sekarang!</a>
            </div>
            <div class="col-6">
              <button type="submit" class="btn btn-success" name="submit" value="simpan">Login sekarang!</button>
            </div>
          </div>
        </form>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="./assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./assets/dist/js/adminlte.min.js"></script>

</body>

</html>