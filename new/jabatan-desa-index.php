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
          <h1>Halaman Daftar Jabatan Desa</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data</h3>
        <a href="jabatan-desa-tambah.php" class="btn btn-sm btn-success float-right">+ Tambah Data</a>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="example2">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pejabat Desa</th>
              <th>Jabatan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include('koneksi.php'); //memanggil file koneksi
            $datas = mysqli_query($koneksi, "SELECT * FROM pejabat_desa") or die(mysqli_error($koneksi));

            $no = 1; //untuk pengurutan nomor

            //melakukan perulangan
            while ($row = mysqli_fetch_assoc($datas)) {
            ?>

              <tr>
                <td><?= $no; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['jabatan']; ?></td>
                <td style="text-align: center;">
                  <a href="jabatan-desa-edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="jabatan-desa-index.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin hapus data ini?');">Hapus</a>
                </td>
              </tr>

            <?php $no++;
            } ?>
          </tbody>
        </table>
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

<?php
if ((isset($_GET['status'])) && ($_GET['status'] == 'hapus')) {
  $id = $_GET['id']; //menampung id
  //query hapus
  $datas = mysqli_query($koneksi, "DELETE FROM pejabat_desa WHERE id ='$id'") or die(mysqli_error($koneksi));
  //alert dan redirect ke index.php
  echo "<script>alert('Data berhasil dihapus.');window.location='jabatan-desa-index.php';</script>";
}
?>