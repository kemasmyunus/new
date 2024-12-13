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
          <h1>Halaman Surat Keterangan Berkelakuan Baik</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data Surat </h3>
        <a href="skbb-tambah.php" class="btn btn-sm btn-warning float-right">+ Tambah Data</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="example2">
            <thead>
              <tr style="white-space: nowrap !important;">
                <th>No</th>
                <th>No SKBB</th>
                <th>Nama</th>
                <th>Agama</th>
                <th>Nik</th>
                <th>alamat</th>
                <th>Warga</th>
                <th>Keperluan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php
              include('koneksi.php'); //memanggil file koneksi
              if ($_SESSION['level'] == 'admin'||$_SESSION['level'] == 'pimpinan') {
                // Query for admin to see all SKbb
                $datas = mysqli_query($koneksi, "SELECT skbb.*, users.nama 
                                                FROM skbb 
                                                JOIN users ON users.id = skbb.id_user") or die(mysqli_error($koneksi));
              } else {
                // Query for users to see their own SKbb
                $user_id = $_SESSION['user_id'];
                $datas = mysqli_query($koneksi, "SELECT skbb.*, users.nama 
                                                FROM skbb 
                                                JOIN users ON users.id = skbb.id_user 
                                                WHERE skbb.id_user = '$user_id'") or die(mysqli_error($koneksi));
              }

              $no = 1; //untuk pengurutan nomor

              //melakukan perulangan
              while ($row = mysqli_fetch_assoc($datas)) {
              ?>

                <tr style="white-space: nowrap !important;">
                  <td><?= $no; ?></td>
                  <td><?= $row['no_skbb']; ?></td>
                  <td><?= $row['nama']; ?></td>
                  <td><?= $row['agama']; ?></td>
                  <td><?= $row['nik']; ?></td>
                  <td><?= $row['alamat']; ?></td>
                  <td><?= $row['warga']; ?></td>
                  <td><?= $row['keperluan']; ?></td>
                  <td><?= $row['status']; ?></td>
                  <td>
                    <?php if ($_SESSION['level'] == 'pelanggan') { ?>

                      <?php if ($row['file']) { ?>
                        <a href="file/<?= $row['file']; ?>" download="<?= $row['file']; ?>" class="btn btn-sm btn-success">Download</a>
                      <?php } else { ?>
                        No File
                      <?php } ?>
                    <?php } ?>

                    <?php if ($_SESSION['level'] == 'admin'||$_SESSION['level'] == 'pimpinan') { ?>
                      <a href="surat-skbb.php?id=<?= $row['id']; ?>" target="_blank" class="btn btn-sm btn-primary">Cetak</a>
                      <a href="skbb-edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                      <a href="skbb-index.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?');">Hapus</a>
                    <?php } ?>

                  </td>
                </tr>

              <?php $no++;
              } ?>
            </tbody>
          </table>
        </div>
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
  $datas = mysqli_query($koneksi, "DELETE FROM skbb WHERE id ='$id'") or die(mysqli_error($koneksi));
  //alert dan redirect ke index.php
  echo "<script>alert('Data berhasil dihapus.');window.location='skbb-index.php';</script>";
}
?>

<div class="modal fade" id="lap-skbb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Bulan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="GET" action="laporan-skbb.php">
        <div class="modal-body">
          <input type="month" name="bulan" required="" class="form-control" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function setSkbbId(skbbId, totalPembayaran) {
    document.getElementById('skbb_id').value = skbbId;
    document.getElementById('total_pembayaran').value = 'Rp ' + totalPembayaran;
  }
</script>