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
          <h1>Halaman Monitoring Pegawai</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Best Performing Employee -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Pegawai Terbaik</h3>
      </div>
      <div class="card-body">
        <?php
        include('koneksi.php'); // Ensure this is included before querying

        // Query to cast 'point' as an integer and fetch the best performing employee
        $best_performing_query = mysqli_query($koneksi, "SELECT *, CAST(point AS SIGNED) AS int_point FROM pegawai ORDER BY int_point DESC LIMIT 1");

        if ($best_performing_query && $best_performing = mysqli_fetch_assoc($best_performing_query)) {
          // Determine performance category based on the integer point value
          $performance_category = $best_performing['int_point'] > 80 ? 'Kinerja Terbaik' : 'Kinerja Cukup Baik';
        ?>
          <div class="list-group-item">
            <div>
              <h5><?= htmlspecialchars($best_performing['nama']); ?> (<?= htmlspecialchars($best_performing['nip']); ?>)</h5>
              <p><?= htmlspecialchars($performance_category); ?></p>
            </div>
            <span class="badge badge-primary"><?= htmlspecialchars($best_performing['int_point']); ?> Points</span>
          </div>
        <?php
        } else {
          // Handle the case where no data is returned or query fails
          echo "<p>Tidak ada data pegawai.</p>";
        }
        ?>
      </div>
    </div>

    <!-- /.card-body -->
    <!-- /.card -->

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data Pegawai</h3>
        <a href="pegawai-tambah.php" class="btn btn-sm btn-success float-right">+ Tambah Data</a>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="example2">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama / NIP</th>
              <th>Jenis Kelamin</th>
              <th>Jabatan</th>
              <th>Golongan</th>
              <th>Pendidikan Terakhir</th>
              <th>Point</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $datas = mysqli_query($koneksi, "SELECT * FROM pegawai") or die(mysqli_error($koneksi));

            $no = 1; //untuk pengurutan nomor

            //melakukan perulangan
            while ($row = mysqli_fetch_assoc($datas)) {
            ?>

              <tr>
                <td><?= $no; ?></td>
                <td><?= $row['nama']; ?><br><small><?= $row['nip']; ?></small></td>
                <td><?= $row['jk']; ?></td>
                <td><?= $row['jabatan']; ?></td>
                <td><?= $row['golongan']; ?></td>
                <td><?= $row['pendidikan']; ?></td>
                <td><?= $row['point']; ?></td>
                <td style="text-align: center;">
                  <a href="pegawai-edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="pegawai-index.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin hapus data ini?');">Hapus</a>
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
  $datas = mysqli_query($koneksi, "DELETE FROM pegawai WHERE id ='$id'") or die(mysqli_error($koneksi));
  //alert dan redirect ke index.php
  echo "<script>alert('Data berhasil dihapus.');window.location='pegawai-index.php';</script>";
}
?>
