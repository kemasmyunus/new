<?php
ob_start(); // Start output buffering
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // include the database connection file

// Check if form is submitted
if (isset($_POST['submit'])) {
  $nama = $_POST['nama'];
  $nip = $_POST['nip'];
  $jk = $_POST['jk'];
  $jabatan = $_POST['jabatan'];
  $tjabatan = $_POST['tjabatan'];
  $golongan = $_POST['golongan'];
  $masa = $_POST['masa'];
  $pendidikan = $_POST['pendidikan'];
  $dik = $_POST['dik'];
  $diklat = $_POST['diklat'];
  $point = $_POST['point'];

  // Insert the new employee data into the database
  $query = "INSERT INTO pegawai (nama, nip, jk, jabatan, tjabatan, golongan, masa, pendidikan, dik, diklat, point) 
              VALUES ('$nama', '$nip', '$jk', '$jabatan', '$tjabatan', '$golongan', '$masa', '$pendidikan', '$dik', '$diklat', '$point')";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil ditambahkan.');window.location='pegawai-index.php';</script>";
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
  }
}

// Fetch available positions from the jabatan_desa table
$jabatans = mysqli_query($koneksi, "SELECT * FROM pejabat_desa") or die(mysqli_error($koneksi));
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tambah Pegawai</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form Tambah Pegawai</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
          </div>
          <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" required>
          </div>
          <div class="form-group">
            <label for="jk">Jenis Kelamin</label>
            <select class="form-control" id="jk" name="jk" required>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <select class="form-control" id="jabatan" name="jabatan" required>
              <?php while ($row = mysqli_fetch_assoc($jabatans)) { ?>
                <option value="<?= $row['jabatan']; ?>"><?= $row['jabatan']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="tjabatan">TMT Jabatan</label>
            <input type="date" class="form-control" id="tjabatan" name="tjabatan" required>
          </div>
          <div class="form-group">
            <label for="golongan">Pangkat/Golongan ruang</label>
            <input type="text" class="form-control" id="golongan" name="golongan" required>
          </div>
          <div class="form-group">
            <label for="masa">Tanggal</label>
            <input type="text" class="form-control" id="masa" name="masa" required>
          </div>
          <div class="form-group">
            <label for="pendidikan">Pendidikan Terakhir</label>
            <input type="text" class="form-control" id="pendidikan" name="pendidikan" required>
          </div>
          <div class="form-group">
            <label for="dik">Diklatpim</label>
            <input type="text" class="form-control" id="dik" name="dik" required>
          </div>
          <div class="form-group">
            <label for="diklat">Diklat Fungsional/Teknis</label>
            <input type="text" class="form-control" id="diklat" name="diklat" required>
          </div>
          <div class="form-group">
            <label for="point">Point</label>
            <input type="text" class="form-control" id="point" name="point" required>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
        </form>
      </div>
    </div>
    <!-- /.card-body -->
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('templates/footer.php');
?>