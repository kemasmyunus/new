<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Memanggil file koneksi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pencarian data berdasarkan NIK untuk warga yang meninggal
if (isset($_GET['nik2'])) {
    $nik2 = $_GET['nik2'];
    $sql = "SELECT * FROM penduduk WHERE nik = '$nik2'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama2 = $row['nama'];
        $jk2 = $row['jk'];
        $tgl_lahir = $row['tgl'];
        $agama2 = $row['agama'];
        $alamat2 = $row['alamat'];
    } else {
        $nama2 = $jk2 = $tgl_lahir = $agama2 = $alamat2 = "";
        echo "<script>alert('Data tidak ditemukan di tabel penduduk.');</script>";
    }
} else {
    $nik2 = $nama2 = $jk2 = $tgl_lahir = $agama2 = $alamat2 = "";
}

// Mengambil nilai max_no_skk
$query = "SELECT MAX(no_skk) AS max_no_skk FROM skk";
$result = mysqli_query($koneksi, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $next_no_skk = $row['max_no_skk'] + 1;
} else {
    $next_no_skk = 1; // Jika tabel kosong, mulai dari 1
}

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_skk = $_POST['no_skk'];
    $id_user = $_POST['id_user'];
    $nama2 = $_POST['nama2'];
    $jk = $_POST['jk'];
    $jk2 = $_POST['jk2'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    $agama2 = $_POST['agama2'];
    $nik = $_POST['nik'];
    $nik2 = $_POST['nik2'];
    $alamat = $_POST['alamat'];
    $alamat2 = $_POST['alamat2'];
    $hubungan = $_POST['hubungan'];
    $status = 'Menunggu';
    $sebab = $_POST['sebab'];
    $hari = $_POST['hari'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $tempat = $_POST['tempat'];

    $query = "INSERT INTO skk (no_skk, id_user, nama2, jk, jk2, tgl_lahir, agama, agama2, nik, alamat, nik2, alamat2, hubungan, status, sebab, hari, tanggal, waktu, tempat) 
              VALUES ('$no_skk', '$id_user', '$nama2', '$jk', '$jk2', '$tgl_lahir', '$agama', '$agama2', '$nik', '$alamat', '$nik2', '$alamat2', '$hubungan', '$status', '$sebab', '$hari', '$tanggal', '$waktu', '$tempat')";

    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    if ($result) {
        echo "<script>alert('Data berhasil ditambahkan.');window.location='skk-index.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan.');window.location='skk-tambah.php';</script>";
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Tambah Data Surat Keterangan Kematian</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Data</h3>
            </div>
            <div class="card-body">
                <!-- Form Pencarian NIK untuk warga yang meninggal -->
                <form method="GET" action="">
                    <div class="form-group">
                        <label for="nik2">Cari NIK (Warga yang meninggal):</label>
                        <input type="text" class="form-control" name="nik2" id="nik2" value="<?= htmlspecialchars($nik2) ?>" required>
                        <button type="submit" class="btn btn-info mt-2">Cek Data</button>
                    </div>
                </form>

                <!-- Form Tambah Data -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="no_skk">No SK</label>
                        <input type="text" class="form-control" id="no_skk" name="no_skk" value="<?= $next_no_skk; ?>" readonly>
                    </div>

                    <!-- Data Pengaju -->
                    <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pimpinan') { ?>
                        <div class="form-group">
                            <label>Nama Pengaju</label>
                            <select class="form-control" name="id_user" required>
                                <option value="">Pilih</option>
                                <?php
                                $datas = mysqli_query($koneksi, "SELECT * FROM users") or die(mysqli_error($koneksi));
                                while ($row = mysqli_fetch_assoc($datas)) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="id_user" value="<?= $_SESSION['user_id']; ?>">
                    <?php } ?>

                    <!-- Data Warga yang meninggal -->
                    <h5><b>WARGA YANG MENINGGAL DUNIA</b></h5>
                    <div class="form-group">
                        <label for="nama2">Nama</label>
                        <input type="text" class="form-control" id="nama2" name="nama2" value="<?= htmlspecialchars($nama2) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nik2">NIK</label>
                        <input type="text" class="form-control" id="nik2" name="nik2" value="<?= htmlspecialchars($nik2) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jk2">Jenis Kelamin</label>
                        <input type="text" class="form-control" id="jk2" name="jk2" value="<?= htmlspecialchars($jk2) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= htmlspecialchars($tgl_lahir) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="agama2">Agama</label>
                        <input type="text" class="form-control" id="agama2" name="agama2" value="<?= htmlspecialchars($agama2) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="alamat2">Alamat</label>
                        <textarea class="form-control" id="alamat2" name="alamat2" readonly><?= htmlspecialchars($alamat2) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hubungan">Hubungan dengan Alm./Almh.</label>
                        <input type="text" class="form-control" id="hubungan" name="hubungan" required>
                    </div>

                    <!-- Keterangan Tempat/Waktu & Sebab Kematian -->
                    <h5><b>KETERANGAN TEMPAT/WAKTU & SEBAB KEMATIAN</b></h5>
                    <div class="form-group">
                        <label for="sebab">Sebab</label>
                        <input type="text" class="form-control" id="sebab" name="sebab" required>
                    </div>
                    <div class="form-group">
                        <label for="hari">Hari</label>
                        <input type="text" class="form-control" id="hari" name="hari" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu">Waktu</label>
                        <input type="text" class="form-control" id="waktu" name="waktu" required>
                    </div>
                    <div class="form-group">
                        <label for="tempat">Tempat</label>
                        <input type="text" class="form-control" id="tempat" name="tempat" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('templates/footer.php');
?>
