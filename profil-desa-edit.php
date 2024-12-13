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
          <h1>Halaman Edit Profil Desa</h1>
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

        $id = $_GET['id']; //mengambil id profil desa yang ingin diubah

        //menampilkan profil desa berdasarkan id
        $data = mysqli_query($koneksi, "SELECT * FROM profil_desa WHERE id = '$id'");
        $row = mysqli_fetch_assoc($data);
        ?>
        <form action="" method="post" role="form">
          <input type="hidden" name="id" required="" value="<?= $row['id']; ?>">
          <div class="form-group">
            <label>Nama Desa</label>
            <input type="text" name="nama" required="" value="<?= $row['nama']; ?>" class="form-control" autofocus="">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" required="" value="<?= $row['alamat']; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label>Kecamatan</label>
            <input type="text" name="kecamatan" required="" value="<?= $row['kecamatan']; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label>Kota</label>
            <input type="text" name="kota" required="" value="<?= $row['kota']; ?>" class="form-control">
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
  $alamat = $_POST['alamat'];
  $kecamatan = $_POST['kecamatan'];
  $kota = $_POST['kota'];

  // Update data di tabel profil_desa
  mysqli_query($koneksi, "UPDATE profil_desa SET nama='$nama', alamat='$alamat', kecamatan='$kecamatan', kota='$kota' WHERE id='$id'") or die(mysqli_error($koneksi));

  // Redirect ke halaman profil-desa-index.php
  echo "<script>alert('Data berhasil diupdate.');window.location='profil-desa-index.php';</script>";
}
?>
<?php
include('templates/footer.php');
?>