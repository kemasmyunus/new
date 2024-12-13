<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Include database connection

// Initialize variables for error messages
$errors = [];
$success = false;

// Fetch penduduk data for the dropdown
$penduduk_options = [];
$result = mysqli_query($koneksi, "SELECT id, nama FROM penduduk ORDER BY nama ASC");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $penduduk_options[] = $row;
    }
}

// Fetch users data for the dropdown
$users_options = [];
$result_users = mysqli_query($koneksi, "SELECT id, username, nama FROM users ORDER BY nama ASC");
if ($result_users) {
    while ($row_users = mysqli_fetch_assoc($result_users)) {
        $users_options[] = $row_users;
    }
}

// Fetch last ID for auto-increment in users
$last_user_id = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MAX(id) AS last_id FROM users"))['last_id'] + 1;

// Fetch last ID for auto-increment in penduduk
$last_penduduk_id = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MAX(id) AS last_id FROM penduduk"))['last_id'] + 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data for users
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']); // Hash password
    $nama_user = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $verifikasi = mysqli_real_escape_string($koneksi, $_POST['verifikasi']);

    // Get POST data for penduduk
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tgl = mysqli_real_escape_string($koneksi, $_POST['tgl']);
    $jk = mysqli_real_escape_string($koneksi, $_POST['jk']);
    $agama = mysqli_real_escape_string($koneksi, $_POST['agama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $pekerjaan = mysqli_real_escape_string($koneksi, $_POST['pekerjaan']);
    $warga = mysqli_real_escape_string($koneksi, $_POST['warga']);

    // Validate input
    if (empty($username) || empty($password) || empty($nama_user) || empty($email) || empty($nik) || empty($nama) || empty($tgl) || empty($jk) || empty($agama) || empty($alamat) || empty("$no_hp")|| empty($pekerjaan) || empty($warga) || empty($verifikasi)) {
        $errors[] = "All fields are required.";
    }

    // Check for errors before proceeding
    if (empty($errors)) {
        // Insert into users table
        $query_user = "INSERT INTO users (id, username, password, nama, email, verifikasi) VALUES ('$last_user_id', '$username', '$password', '$nama_user', '$email', '$verifikasi')";
        if (mysqli_query($koneksi, $query_user)) {
            // Insert into penduduk table
            $query_penduduk = "INSERT INTO penduduk (id, nik, nama, tgl, jk, agama, alamat, no_hp, user_id, pekerjaan, warga) VALUES ('$last_penduduk_id', '$nik', '$nama', '$tgl', '$jk', '$agama', '$alamat', '$no_hp', '$last_user_id', '$pekerjaan', '$warga')";
            if (mysqli_query($koneksi, $query_penduduk)) {
                $success = true;
            } else {
                $errors[] = "Error inserting into penduduk: " . mysqli_error($koneksi);
            }
        } else {
            $errors[] = "Error inserting into users: " . mysqli_error($koneksi);
        }
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Data Penduduk & Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <a href="penduduk-index.php" class="btn btn-sm btn-primary float-right">Kembali</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Data Penduduk & Pengguna</h3>
            </div>
            <div class="card-body">
                <?php if ($success) : ?>
                    <div class="alert alert-success">Data berhasil ditambahkan!</div>
                <?php endif; ?>

                <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                            <p><?= $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="">
                    <!-- Users Form Section -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="nama_user">Nama Pengguna</label>
                        <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Nama Pengguna">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>

                    <!-- Penduduk Form Section -->
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="tgl">Tanggal Lahir</label>
                        <input type="text" class="form-control" id="tgl" name="tgl" placeholder="Tanggal Lahir">
                    </div>
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <select class="form-control" id="jk" name="jk" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="" disabled selected>Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Nomor Hp</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor Hp">
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan">
                    </div>
                    <div class="form-group">
                        <label for="warga">Warga Negara</label>
                        <input type="text" class="form-control" id="warga" name="warga" placeholder="Warga Negara">
                    </div>
                    <div class="form-group">
                        <label for="verifikasi">Status Verifikasi</label>
                        <select class="form-control" id="verifikasi" name="verifikasi">
                            <option value="" disabled selected>Pilih Status Verifikasi</option>
                            <option value="Belum Terverifikasi">Belum Terverifikasi</option>
                            <option value="Sudah Terverifikasi">Sudah Terverifikasi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
include('templates/footer.php');
?>
