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
          <h1>Halaman Edit Jabatan Desa</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Edit Data</h3>
      </div>
      <div class="card-body">
        <?php
        include('koneksi.php');

        $id = $_GET['id']; //mengambil id jabatan desa yang ingin diubah

        //menampilkan jabatan desa berdasarkan id
        $data = mysqli_query($koneksi, "SELECT * FROM pejabat_desa WHERE id = '$id'");
        $row = mysqli_fetch_assoc($data);
        ?>
        <form action="" method="post" role="form">
          <input type="hidden" name="id" required="" value="<?= $row['id']; ?>">
          <div class="form-group">
            <label>Nama Pejabat Desa</label>
            <input type="text" name="nama" required="" value="<?= $row['nama']; ?>" class="form-control" autofocus="">
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan" required="" value="<?= $row['jabatan']; ?>" class="form-control">
          </div>
          <button type="submit" class="btn btn-primary" name="submit" value="simpan">Ubah Data</button>
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

// Jika tombol submit diklik, lakukan perubahan
if (isset($_POST['submit'])) {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $jabatan = $_POST['jabatan'];

  // Update data di tabel jabatan_desa
  mysqli_query($koneksi, "UPDATE pejabat_desa SET nama='$nama', jabatan='$jabatan' WHERE id='$id'") or die(mysqli_error($koneksi));

  // Redirect ke halaman jabatan-desa-index.php
  echo "<script>alert('Data berhasil diupdate.');window.location='jabatan-desa-index.php';</script>";
}
?>
<?php
include('templates/footer.php');
?>