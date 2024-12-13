<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>kantor</title>
    <link rel="icon" href="./assets/gambar/logo.png">
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

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            padding: 20px;
            max-width: 500px;
            width: 100%;
        }

        .card-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
            border-radius: 50px;
            padding: 10px;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }
    </style>
</head>

<body>
    <?php include 'koneksi.php'; ?>

    <div class="card">
        <div class="card-header">DAFTAR</div>
        <div class="card-body">
            <form action="" method="post" role="form" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" required="" class="form-control">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required="" class="form-control">
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required="" class="form-control">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required="" class="form-control">
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" required="" class="form-control">
                </div>

                <div class="form-group">
                    <label>Tempat/Tanggal Lahir</label>
                    <input type="text" name="tgl" required="" class="form-control">
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jk" class="form-control" required="">
                        <option value="Laki-laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Agama</label>
                    <input type="text" name="agama" required="" class="form-control">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" required=""></textarea>
                </div>

                <div class="form-group">
                    <label>Nomor Hp</label>
                    <textarea name="no_hp" class="form-control" required=""></textarea>
                </div>

                <div class="form-group">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" required="" class="form-control">
                </div>

                <div class="form-group">
                    <label>Warga Negara</label>
                    <input type="text" name="warga" required="" class="form-control">
                </div>

                <!-- Input for file upload -->
                <div class="form-group">
                    <label>Foto KTP</label>
                    <input type="file" name="foto_ktp" accept="image/*" required="" class="form-control">
                </div>

                <button type="submit" class="btn btn-warning" name="submit" value="simpan">Simpan data</button>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="./assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./assets/dist/js/adminlte.min.js"></script>

</body>

</html>

<?php
// Menampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

// Cek koneksi database
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Check if submit button is clicked
if (isset($_POST['submit'])) {
    // Menyimpan data ke variabel dengan filter
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $level = 'pelanggan';

    // Periksa apakah username atau email sudah ada
    $check_user_query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($check_user_query) > 0) {
        echo "<script>alert('Username atau email sudah terdaftar. Silakan gunakan yang lain.');window.location='register.php';</script>";
    } else {
        // Insert new user into the users table
        $insert_user_query = mysqli_query($koneksi, "INSERT INTO users (nama, username, password, email, level) VALUES ('$nama', '$username', '$password', '$email', '$level')");

        if ($insert_user_query) {
            // Get the last inserted user ID
            $user_id = mysqli_insert_id($koneksi);

            // Handle file upload
            if (isset($_FILES['foto_ktp']) && $_FILES['foto_ktp']['error'] == 0) {
                $target_dir = "assets/img/ktp/";
                $file_name = basename($_FILES['foto_ktp']['name']);
                $file_tmp = $_FILES['foto_ktp']['tmp_name'];
                $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                // Validate file type
                if (in_array($file_type, ['jpg', 'jpeg', 'png'])) {
                    // Use user ID to generate a unique file name
                    $new_file_name = "foto_ktp_" . $user_id . '.' . $file_type;
                    $target_file = $target_dir . $new_file_name;

                    if (move_uploaded_file($file_tmp, $target_file)) {
                        // Insert penduduk data into the database
                        $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
                        $tgl = mysqli_real_escape_string($koneksi, $_POST['tgl']);
                        $jk = mysqli_real_escape_string($koneksi, $_POST['jk']);
                        $agama = mysqli_real_escape_string($koneksi, $_POST['agama']);
                        $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
                        $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
                        $pekerjaan = mysqli_real_escape_string($koneksi, $_POST['pekerjaan']);
                        $warga = mysqli_real_escape_string($koneksi, $_POST['warga']);

                        // Insert penduduk data into the database
                        $insert_penduduk_query = mysqli_query($koneksi, "INSERT INTO penduduk (nik, nama, tgl, jk, agama, alamat, no_hp, user_id, pekerjaan, warga, foto_ktp) 
                            VALUES ('$nik', '$nama', '$tgl', '$jk', '$agama', '$alamat', '$no_hp', '$user_id', '$pekerjaan', '$warga', '$new_file_name')");

                        if ($insert_penduduk_query) {
                            echo "<script>alert('Berhasil Daftar.');window.location='login.php';</script>";
                        } else {
                            echo "Error: " . mysqli_error($koneksi);
                        }
                    } else {
                        echo "Error uploading file.";
                    }
                } else {
                    echo "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
                }
            } else {
                echo "No file uploaded or an error occurred.";
            }
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
?>

