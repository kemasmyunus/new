<?php

include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // include the database connection file

// Check if the form is submitted for updating the data
if (isset($_POST['update'])) {
  $id = $_POST['id'];
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

  // Update the employee data in the database
  $query = "UPDATE pegawai SET nama='$nama', nip='$nip', jk='$jk', jabatan='$jabatan', tjabatan='$tjabatan', golongan='$golongan', masa='$masa', pendidikan='$pendidikan', dik='$dik', diklat='$diklat', point='$point' WHERE id='$id'";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil diperbarui.');window.location='pegawai-index.php';</script>";
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
  }
}

// Fetch the employee data to be edited
$id = $_GET['id'];
$query = "SELECT * FROM pegawai WHERE id='$id'";
$result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
$data = mysqli_fetch_assoc($result);

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
          <h1>Edit Pegawai</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form Edit Pegawai</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <input type="hidden" name="id" value="<?= $data['id']; ?>">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama']; ?>" required>
          </div>
          <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" value="<?= $data['nip']; ?>" required>
          </div>
          <div class="form-group">
            <label for="jk">Jenis Kelamin</label>
            <select class="form-control" id="jk" name="jk" required>
              <option value="Laki-laki" <?= $data['jk'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
              <option value="Perempuan" <?= $data['jk'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <select class="form-control" id="jabatan" name="jabatan" required>
              <?php while ($row = mysqli_fetch_assoc($jabatans)) { ?>
                <option value="<?= $row['jabatan']; ?>" <?= $data['jabatan'] == $row['jabatan'] ? 'selected' : ''; ?>><?= $row['jabatan']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="tjabatan">TMT Jabatan</label>
            <input type="date" class="form-control" id="tjabatan" name="tjabatan" value="<?= $data['tjabatan']; ?>" required>
          </div>
          <div class="form-group">
            <label for="golongan">Pangkat/Golongan ruang</label>
            <input type="text" class="form-control" id="golongan" name="golongan" value="<?= $data['golongan']; ?>" required>
          </div>
          <div class="form-group">
            <label for="masa">Tanggal</label>
            <input type="text" class="form-control" id="masa" name="masa" value="<?= $data['masa']; ?>" required>
          </div>
          <div class="form-group">
            <label for="pendidikan">Pendidikan Terakhir</label>
            <input type="text" class="form-control" id="pendidikan" name="pendidikan" value="<?= $data['pendidikan']; ?>" required>
          </div>
          <div class="form-group">
            <label for="dik">Diklatpim</label>
            <input type="text" class="form-control" id="dik" name="dik" value="<?= $data['dik']; ?>" required>
          </div>
          <div class="form-group">
            <label for="diklat">Diklat</label>
            <input type="text" class="form-control" id="diklat" name="diklat" value="<?= $data['diklat']; ?>" required>
          </div>
          <div class="form-group">
            <label for="point">Point</label>
            <input type="text" class="form-control" id="point" name="point" value="<?= $data['point']; ?>" required>
          </div>
          <button type="submit" name="update" class="btn btn-primary">Update Data</button>
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