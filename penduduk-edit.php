<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Include database connection

// Initialize variables for error messages
$errors = [];
$success = false;

// Get the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Fetch existing data for users and penduduk
    $user_query = "SELECT users.*, penduduk.* FROM users 
                    INNER JOIN penduduk ON users.id = penduduk.user_id 
                    WHERE users.id = '$id' LIMIT 1";
    $result = mysqli_query($koneksi, $user_query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        // Populate form data
        $username = $data['username'];
        $nama_user = $data['nama'];
        $email = $data['email'];
        $nik = $data['nik'];
        $nama = $data['nama'];
        $tgl = $data['tgl'];
        $jk = $data['jk'];
        $agama = $data['agama'];
        $alamat = $data['alamat'];
        $no_hp = $data['no_hp'];
        $pekerjaan = $data['pekerjaan'];
        $warga = $data['warga'];
        $verifikasi = $data['verifikasi'];
    } else {
        $errors[] = "Data tidak ditemukan.";
    }
} else {
    $errors[] = "ID tidak valid.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data for users
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']); // Hash password
    $nama_user = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

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
    $verifikasi = mysqli_real_escape_string($koneksi, $_POST['verifikasi']);

    // Validate input
    if (empty($username) || empty($nama_user) || empty($email) || empty($nik) || empty($nama) || empty($tgl) || empty($jk) || empty($agama) || empty($alamat) || empty($no_hp)|| empty($pekerjaan) || empty($warga) || empty($verifikasi)) {
        $errors[] = "All fields are required.";
    }

    // Check for errors before proceeding
    if (empty($errors)) {
        // Update users table
        $query_user = "UPDATE users SET username = '$username', ";
        if (!empty($password)) {
            $query_user .= "password = '$password', ";
        }
        $query_user .= "nama = '$nama_user', email = '$email', verifikasi = '$verifikasi' WHERE id = '$id'";
    
        if (mysqli_query($koneksi, $query_user)) {
            // Update penduduk table
            $query_penduduk = "UPDATE penduduk SET nik = '$nik', nama = '$nama', tgl = '$tgl', jk = '$jk', agama = '$agama', alamat = '$alamat', no_hp='$no_hp', pekerjaan = '$pekerjaan', warga = '$warga' WHERE user_id = '$id'";
            if (mysqli_query($koneksi, $query_penduduk)) {
                $success = true;
            } else {
                $errors[] = "Error updating penduduk: " . mysqli_error($koneksi);
            }
        } else {
            $errors[] = "Error updating users: " . mysqli_error($koneksi);
        }
    }
    
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Penduduk & Pengguna</h1>
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
                <h3 class="card-title">Form Edit Data Penduduk & Pengguna</h3>
            </div>
            <div class="card-body">
                <?php if ($success) : ?>
                    <div class="alert alert-success">Data berhasil diperbarui!</div>
                <?php endif; ?>

                <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                            <p><?= $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($id > 0 && $data) : ?>
                <form method="post" action="">
                    <!-- Users Form Section -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $username; ?>" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="nama_user">Nama Pengguna</label>
                        <input type="text" class="form-control" id="nama_user" name="nama_user" value="<?= $nama_user; ?>" placeholder="Nama Pengguna">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $email; ?>" placeholder="Email">
                    </div>

                    <!-- Penduduk Form Section -->
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?= $nik; ?>" placeholder="NIK">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama; ?>" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="tgl">Tanggal Lahir</label>
                        <input type="text" class="form-control" id="tgl" name="tgl" value="<?= $tgl; ?>" placeholder="Tanggal Lahir">
                    </div>
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <select class="form-control" id="jk" name="jk" required>
                            <option value="" disabled>Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki" <?= $jk == 'Laki-Laki' ? 'selected' : ''; ?>>Laki-Laki</option>
                            <option value="Perempuan" <?= $jk == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="" disabled>Pilih Agama</option>
                            <option value="Islam" <?= $agama == 'Islam' ? 'selected' : ''; ?>>Islam</option>
                            <option value="Kristen" <?= $agama == 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
                            <option value="Katolik" <?= $agama == 'Katolik' ? 'selected' : ''; ?>>Katolik</option>
                            <option value="Hindu" <?= $agama == 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
                            <option value="Buddha" <?= $agama == 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
                            <option value="Konghucu" <?= $agama == 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat"><?= $alamat; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Nomor Hp</label>
                        <input type="text"class="form-control" id="no_hp" name="no_hp" value="<?= $no_hp; ?>" placeholder="no_hp">
                    </div>

                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= $pekerjaan; ?>" placeholder="Pekerjaan">
                    </div>
                    <div class="form-group">
                        <label for="warga">Warga Negara</label>
                        <input type="text" class="form-control" id="warga" name="warga" value="<?= $warga; ?>" placeholder="Warga Negara">
                    </div>
                    <div class="form-group">
                        <label for="verifikasi">Status Verifikasi</label>
                        <select class="form-control" id="verifikasi" name="verifikasi">
                            <option value="" disabled>Pilih Status Verifikasi</option>
                            <option value="Belum Terverifikasi" <?= $verifikasi == 'Belum Terverifikasi' ? 'selected' : ''; ?>>Belum Terverifikasi</option>
                            <option value="Sudah Terverifikasi" <?= $verifikasi == 'Sudah Terverifikasi' ? 'selected' : ''; ?>>Sudah Terverifikasi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<?php
include('templates/footer.php');
?>
