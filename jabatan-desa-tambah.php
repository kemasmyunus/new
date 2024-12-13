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
          <h1>Halaman Tambah Jabatan Desa</h1>
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
            <label>Nama Pejabat Desa</label>
            <input type="text" name="nama" required="" class="form-control" autofocus="">
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan" required="" class="form-control">
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
  $jabatan = $_POST['jabatan'];

  // Insert data into jabatan_desa table
  $datas = mysqli_query($koneksi, "INSERT INTO pejabat_desa (nama, jabatan) VALUES ('$nama', '$jabatan')") or die(mysqli_error($koneksi));

  echo "<script>alert('Data berhasil disimpan.');window.location='jabatan-desa-index.php';</script>";
}
?>
<?php
include('templates/footer.php');
?>