<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Include the database connection

// Initialize variables for date filtering
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Halaman Laporan</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card">
      <div class="card-body">
        <h3 class="mb-4">Daftar Laporan</h3>

        <!-- Form for date filtering -->
        <form method="GET" action="">
          <div class="row mb-4">
            <div class="col-md-5">
              <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="<?= $tanggal_mulai ?>">
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="<?= $tanggal_selesai ?>">
              </div>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Filter</button>
            </div>
          </div>
        </form>

        <div class="row">
          <?php
          // Array laporan untuk di-loop dan ditampilkan
          $laporan = [
            ["Laporan Pegawai", "laporan-pegawai.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"],
            ["Laporan Surat Keterangan", "laporan-sk.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"],
            ["Laporan Surat Keterangan Berkelakuan Baik", "laporan-skbb.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"],
            ["Laporan Surat Keterangan Domisili", "laporan-skd.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"],
            ["Laporan Surat Keterangan Tidak Mampu", "laporan-skm.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"],
            ["Laporan Surat Keterangan Usaha", "laporan-sku.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"],
            ["Laporan Surat Keterangan Kematian", "laporan-skk.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"],
            ["Laporan Surat Keterangan Belum Menikah", "laporan-skbm.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"],
            ["Laporan Surat Keterangan Belum Memiliki Rumah", "laporan-skbmr.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"],
            ["Laporan Surat Keterangan Kelahiran", "laporan-skkl.php?tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai"]
          ];


          foreach ($laporan as $lapor) {
          ?>
            <div class="col-md-6 mb-4">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="card-title"><?= $lapor[0]; ?></span>
                    <a href="<?= $lapor[1]; ?>" class="btn btn-warning btn-sm">
                      <i class="fas fa-print"></i> Cetak!
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div> <!-- row -->
      </div> <!-- card-body -->
    </div> <!-- card -->
  </section> <!-- content -->
</div> <!-- content-wrapper -->

<?php
include('templates/footer.php');
?>
