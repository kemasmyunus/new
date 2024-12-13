<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); //memanggil file koneksi

$query = "SELECT MAX(no_sku) AS max_no_sku FROM sku";
$result = mysqli_query($koneksi, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $next_no_sku = $row['max_no_sku'] + 1;
} else {
    $next_no_sku = 1; // Jika tabel kosong, mulai dari 1
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $no_sku = $_POST['no_sku'];
  $id_user = $_POST['id_user'];
  $jk = $_POST['jk'];
  $tgl_lahir = $_POST['tgl_lahir'];
  $agama = $_POST['agama'];
  $pekerjaan = $_POST['pekerjaan'];
  $nik = $_POST['nik'];
  $alamat = $_POST['alamat'];
  $warga = $_POST['warga'];
  $usaha = $_POST['usaha'];
  $keperluan = $_POST['keperluan'];
  $status = 'Menuggu'; // Default status
  $file = $_POST['file'];
  $alamat_usaha = $_POST['alamat_usaha'];

  $query = "INSERT INTO sku (no_sku, id_user, jk, tgl_lahir, agama, pekerjaan, nik, alamat, warga, usaha, keperluan, alamat_usaha, file, status) 
  VALUES ('$no_sku', '$id_user', '$jk', '$tgl_lahir', '$agama', '$pekerjaan', '$nik', '$alamat', '$warga', '$usaha', '$keperluan', '$alamat_usaha', '$file', '$status')";

  $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

  if ($result) {
    echo "<script>alert('Data berhasil ditambahkan.');window.location='sku-index.php';</script>";
  } else {
    echo "<script>alert('Data gagal ditambahkan.');window.location='sku-tambah.php';</script>";
  }
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-8">
          <h1>Tambah Data Surat Keterangan Usaha</h1>
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
        <form method="POST" action="">
          <?php include('koneksi.php'); ?>
          <div class="form-group">
            <label for="no_sku">No SKU</label>
            <input type="text" class="form-control" id="no_sku" name="no_sku" value="<?php echo $next_no_sku; ?>" readonly>
          </div>
          <?php if ($_SESSION['level'] == 'admin'||$_SESSION['level'] == 'pimpinan') { ?>

            <div class="form-group">
              <label>nama</label>
              <select class="form-control " name="id_user" required="">
                <option value="">Pilih</option>
                <?php
                $datas = mysqli_query($koneksi, "select * from users") or die(mysqli_error($koneksi));
                while ($row = mysqli_fetch_assoc($datas)) {
                ?>
                  <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                <?php } ?>
              </select>
            <?php } else { ?>
              <input type="hidden" name="id_user" value="<?= $_SESSION['user_id']; ?>">
            <?php } ?>
            <div class="form-group">
              <label for="jk">Jenis Kelamin</label>
              <select class="form-control" id="jk" name="jk" required>
                <option value="Laki-Laki" <?= ($_SESSION['penduduk_jk'] == 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
                <option value="Perempuan" <?= ($_SESSION['penduduk_jk'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>
            <div class="form-group">
              <label for="tgl_lahir">Tanggal Lahir</label>
              <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= htmlspecialchars($_SESSION['penduduk_tgl']) ?>" required>
            </div>
            <div class="form-group">
              <label for="agama">Agama</label>
              <select class="form-control" id="agama" name="agama" required>
                <option value="islam" <?= ($_SESSION['penduduk_agama'] == 'islam') ? 'selected' : '' ?>>Islam</option>
                <option value="kristen" <?= ($_SESSION['penduduk_agama'] == 'kristen') ? 'selected' : '' ?>>Kristen</option>
                <option value="katolik" <?= ($_SESSION['penduduk_agama'] == 'katolik') ? 'selected' : '' ?>>Katolik</option>
                <option value="hindu" <?= ($_SESSION['penduduk_agama'] == 'hindu') ? 'selected' : '' ?>>Hindu</option>
                <option value="buddha" <?= ($_SESSION['penduduk_agama'] == 'buddha') ? 'selected' : '' ?>>Buddha</option>
                <option value="konghucu" <?= ($_SESSION['penduduk_agama'] == 'konghucu') ? 'selected' : '' ?>>Konghucu</option>
              </select>
            </div>
            <div class="form-group">
              <label for="pekerjaan">Pekerjaan</label>
              <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= htmlspecialchars($_SESSION['penduduk_pekerjaan']) ?>" required>
            </div>
            <div class="form-group">
              <label for="nik">NIK</label>
              <input type="text" class="form-control" id="nik" name="nik" value="<?= htmlspecialchars($_SESSION['penduduk_nik']) ?>" required>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea class="form-control" id="alamat" name="alamat" required><?= htmlspecialchars($_SESSION['penduduk_alamat']) ?></textarea>
            </div>
            <div class="form-group">
              <label for="warga">Warga</label>
              <select class="form-control" id="warga" name="warga" required>
                <option value="WNI" <?= ($_SESSION['penduduk_warga'] == 'WNI') ? 'selected' : '' ?>>WNI</option>
                <option value="WNA" <?= ($_SESSION['penduduk_warga'] == 'WNA') ? 'selected' : '' ?>>WNA</option>
              </select>
            </div>

            <div class="form-group">
              <label for="usaha">usaha</label>
              <textarea class="form-control" id="usaha" name="usaha" required></textarea>
            </div>
            <div class="form-group">
              <label for="keperluan">Keperluan</label>
              <textarea class="form-control" id="keperluan" name="keperluan" required></textarea>
            </div>
            <div class="form-group">
              <label for="alamat_usaha">Alamat Usaha</label>
              <textarea class="form-control" id="alamat_usaha" name="alamat_usaha" required></textarea>
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