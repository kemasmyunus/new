<?php
include('templates/header.php');
include('templates/sidebar.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Halaman Tambah Profil Desa</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tambah Data</h3>
      </div>
      <div class="card-body">
        <form action="" method="post" role="form">
          <div class="form-group">
            <label>Nama Desa</label>
            <input type="text" name="nama" required="" class="form-control" autofocus="">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" required="" class="form-control">
          </div>
          <div class="form-group">
            <label>Kecamatan</label>
            <input type="text" name="kecamatan" required="" class="form-control">
          </div>
          <div class="form-group">
            <label>Kota</label>
            <input type="text" name="kota" required="" class="form-control">
          </div>
          <button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan Data</button>
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
include('koneksi.php');

// Check if the submit button was clicked
if (isset($_POST['submit'])) {
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $kecamatan = $_POST['kecamatan'];
  $kota = $_POST['kota'];

  // Insert data into profil_desa table
  $datas = mysqli_query($koneksi, "INSERT INTO profil_desa (nama, alamat, kecamatan, kota) VALUES ('$nama', '$alamat', '$kecamatan', '$kota')") or die(mysqli_error($koneksi));

  echo "<script>alert('Data berhasil disimpan.');window.location='profil-desa-index.php';</script>";
}
?>
<?php
include('templates/footer.php');
?>