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
          <h1>Halaman Monitoring Tugas</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Filter -->
    <form method="GET" action="tugas-index.php">
      <div class="form-group d-flex align-items-center">
        <label for="bulan" class="mr-2">Filter Bulan:</label>
        <select name="bulan" class="form-control mr-2" style="width: auto;">
          <option value="">Semua Bulan</option>
          <?php
          $bulan_array = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
          ];
          foreach ($bulan_array as $value) {
            $selected = isset($_GET['bulan']) && $_GET['bulan'] == $value ? "selected" : "";
            echo "<option value='$value' $selected>$value</option>";
          }
          ?>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
    </form>


    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data Tugas</h3>
        <a href="tugas-tambah.php" class="btn btn-sm btn-success float-right">+ Tambah Data</a>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="example2">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pegawai</th>
              <th>Tugas</th>
              <th>Point</th>
              <th>Bulan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include('koneksi.php'); // Memanggil file koneksi

            $where = "";
            if (isset($_GET['bulan']) && $_GET['bulan'] != "") {
              $bulan = $_GET['bulan'];
              $where = "WHERE bulan = '$bulan'";
            }

            $datas = mysqli_query($koneksi, "SELECT * FROM tugas $where") or die(mysqli_error($koneksi));

            $no = 1; // Untuk pengurutan nomor

            // Melakukan perulangan
            while ($row = mysqli_fetch_assoc($datas)) {
            ?>

              <tr>
                <td><?= $no; ?></td>
                <td><?= $row['nama_pegawai']; ?></td>
                <td><?= $row['tugas']; ?></td>
                <td><?= $row['poin']; ?></td>
                <td><?= $row['bulan']; ?></td>
                <td style="text-align: center;">
                  <a href="tugas-edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="tugas-index.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin hapus data ini?');">Hapus</a>
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
  $id = $_GET['id']; // Menampung id tugas

  // Ambil informasi tugas yang akan dihapus
  $query = "SELECT * FROM tugas WHERE id = '$id'";
  $result = mysqli_query($koneksi, $query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    $id_pegawai = $row['id_pegawai'];
    $poin = $row['poin'];

    // Kurangi poin pada tabel pegawai
    $updatePoinQuery = "UPDATE pegawai SET point = point - '$poin' WHERE id = '$id_pegawai'";
    mysqli_query($koneksi, $updatePoinQuery);

    // Hapus data tugas
    $deleteQuery = "DELETE FROM tugas WHERE id = '$id'";
    mysqli_query($koneksi, $deleteQuery) or die(mysqli_error($koneksi));

    // Alert dan redirect
    echo "<script>alert('Data berhasil dihapus.');window.location='tugas-index.php';</script>";
  } else {
    echo "<script>alert('Data tidak ditemukan.');window.location='tugas-index.php';</script>";
  }
}
?>
