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
          <h1>Halaman Daftar Penduduk</h1>
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
        <a href="penduduk-tambah.php" class="btn btn-sm btn-success float-right">+ Tambah Data</a>
        <a href="export-penduduk.php" class="btn btn-sm btn-primary float-right">Export to XLS</a>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="example2">
          <thead>
            <tr>
              <th>No</th>
              <th>NIK</th>
              <th>Nama</th>
              <th>Tempat/tgl. Lahir</th>
              <th>Jenis Kelamin</th>
              <th>Agama</th>
              <th>Alamat</th>
              <th>Nomor Hp</th>
              <th>Keterangan Akun</th>
              <th>Status Verifikasi</th>
              <th>Foto KTP</th> <!-- Menambahkan kolom Foto KTP -->
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include('koneksi.php'); // Memanggil file koneksi
            $datas = mysqli_query($koneksi, "
                SELECT penduduk.*, users.id as uid, users.username, users.nama AS user_nama, users.verifikasi
                FROM penduduk
                LEFT JOIN users ON penduduk.user_id = users.id
            ") or die(mysqli_error($koneksi));

            $no = 1; // Untuk pengurutan nomor

            // Melakukan perulangan
            while ($row = mysqli_fetch_assoc($datas)) {
                $foto_ktp = $row['foto_ktp']; // Mendapatkan nama file foto_ktp
            ?>

              <tr>
                <td><?= $no; ?></td>
                <td><?= $row['nik']; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['tgl']; ?></td>
                <td><?= $row['jk']; ?></td>
                <td><?= $row['agama']; ?></td>
                <td><?= $row['alamat']; ?></td>
                <td><?= $row['no_hp']; ?></td>
                <td><?= $row['username']; ?> (<?= $row['user_nama']; ?>)</td>
                <td>
                  <?= $row['verifikasi']; ?>
                </td>
                <td style="text-align: center;">
                  <?php if (!empty($foto_ktp)): ?>
                    <!-- Menampilkan Foto KTP jika ada -->
                    <img src="assets/img/ktp/<?= $foto_ktp; ?>" alt="Foto KTP" style="width: 50px; height: auto;">
                  <?php else: ?>
                    <!-- Menampilkan placeholder jika foto tidak ada -->
                    <img src="assets/img/no-image.png" alt="No KTP" style="width: 50px; height: auto;">
                  <?php endif; ?>
                </td>
                <td style="text-align: center;">
                  <a href="penduduk-edit.php?id=<?= $row['uid']; ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="penduduk-index.php?id=<?= $row['uid']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin hapus data ini?');">Hapus</a>
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
  $user_id = $_GET['id']; // Ubah dari 'uid' menjadi 'id'

  // Hapus data dari tabel penduduk terlebih dahulu
  $hapus_penduduk = mysqli_query($koneksi, "DELETE FROM penduduk WHERE user_id = '$user_id'") or die(mysqli_error($koneksi));

  // Hapus data dari tabel users
  $hapus_user = mysqli_query($koneksi, "DELETE FROM users WHERE id = '$user_id'") or die(mysqli_error($koneksi));

  // Jika berhasil, tampilkan pesan dan redirect
  if ($hapus_penduduk && $hapus_user) {
      echo "<script>alert('Data berhasil dihapus.');window.location='penduduk-index.php';</script>";
  } else {
      echo "<script>alert('Gagal menghapus data.');window.location='penduduk-index.php';</script>";
  }
}
?>
