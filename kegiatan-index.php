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
          <h1>Halaman Monitoring Kegiatan</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data Kegiatan</h3>
        <a href="kegiatan-tambah.php" class="btn btn-sm btn-success float-right">+ Tambah Data</a>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="example2">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pegawai</th>
              <th>Kegiatan</th>
              <th>Point</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include('koneksi.php'); //memanggil file koneksi
            $datas = mysqli_query($koneksi, "SELECT * FROM kegiatan") or die(mysqli_error($koneksi));

            $no = 1; //untuk pengurutan nomor

            //melakukan perulangan
            while ($row = mysqli_fetch_assoc($datas)) {
            ?>

              <tr>
                <td><?= $no; ?></td>
                <td><?= $row['nama_pegawai']; ?></td>
                <td><?= $row['kegiatan']; ?></td>
                <td><?= $row['poin']; ?></td>
                <td style="text-align: center;">
                  <a href="kegiatan-edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="kegiatan-index.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin hapus data ini?');">Hapus</a>
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
  $id = $_GET['id']; //menampung id kegiatan

  // Ambil informasi kegiatan yang akan dihapus
  $query = "SELECT * FROM kegiatan WHERE id = '$id'";
  $result = mysqli_query($koneksi, $query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    $id_pegawai = $row['id_pegawai'];
    $poin = $row['poin'];

    // Kurangi poin pada tabel pegawai
    $updatePoinQuery = "UPDATE pegawai SET point = point - '$poin' WHERE id = '$id_pegawai'";
    mysqli_query($koneksi, $updatePoinQuery);

    // Hapus data kegiatan
    $deleteQuery = "DELETE FROM kegiatan WHERE id = '$id'";
    mysqli_query($koneksi, $deleteQuery) or die(mysqli_error($koneksi));

    // Alert dan redirect
    echo "<script>alert('Data berhasil dihapus.');window.location='kegiatan-index.php';</script>";
  } else {
    echo "<script>alert('Data tidak ditemukan.');window.location='kegiatan-index.php';</script>";
  }
}
?>
