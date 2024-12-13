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
          <h1>Halaman Surat Keterangan Kematian</h1>
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
        <a href="skk-tambah.php" class="btn btn-sm btn-warning float-right">+ Tambah Data</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="example2">
            <thead>
              <tr style="white-space: nowrap !important;">
                <th>No</th>
                <th>No SKK</th>
                <th>Nama</th>
                <th>Nik</th>
                <th>Jenis Kelaminn</th>
                <th>Agama</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php
              include('koneksi.php'); //memanggil file koneksi
              if ($_SESSION['level'] == 'admin'||$_SESSION['level'] == 'pimpinan') {
                // Query for admin to see all SKk
                $datas = mysqli_query($koneksi, "SELECT skk.*, users.nama 
                                                FROM skk 
                                                JOIN users ON users.id = skk.id_user") or die(mysqli_error($koneksi));
              } else {
                // Query for users to see their own SKk
                $user_id = $_SESSION['user_id'];
                $datas = mysqli_query($koneksi, "SELECT skk.*, users.nama 
                                                FROM skk 
                                                JOIN users ON users.id = skk.id_user 
                                                WHERE skk.id_user = '$user_id'") or die(mysqli_error($koneksi));
              }

              $no = 1; //untuk pengurutan nomor

              //melakukan perulangan
              while ($row = mysqli_fetch_assoc($datas)) {
              ?>

                <tr style="white-space: nowrap !important;">
                  <td><?= $no; ?></td>
                  <td><?= $row['no_skk']; ?></td>
                  <td><?= $row['nama']; ?></td>
                  <td><?= $row['nik']; ?></td>
                  <td><?= $row['jk']; ?></td>
                  <td><?= $row['agama']; ?></td>
                  <td><?= $row['alamat']; ?></td>
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
                      <a href="surat-skk.php?id=<?= $row['id']; ?>" target="_blank" class="btn btn-sm btn-primary">Cetak</a>
                      <a href="skk-edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                      <a href="skk-index.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?');">Hapus</a>
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
  $datas = mysqli_query($koneksi, "DELETE FROM skk WHERE id ='$id'") or die(mysqli_error($koneksi));
  //alert dan redirect ke index.php
  echo "<script>alert('Data berhasil dihapus.');window.location='skk-index.php';</script>";
}
?>

<div class="modal fade" id="lap-skk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Bulan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="GET" action="laporan-skk.php">
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
  function setSkkId(skkId, totalPembayaran) {
    document.getElementById('skk_id').value = skkId;
    document.getElementById('total_pembayaran').value = 'Rp ' + totalPembayaran;
  }
</script>