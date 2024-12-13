<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Include the database connection file

// Check if the ID is set
if (isset($_GET['id'])) {
    $id_kegiatan = $_GET['id'];

    // Fetch the current data of the kegiatan
    $query = "SELECT * FROM kegiatan WHERE id = '$id_kegiatan'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $id_pegawai = $row['id_pegawai'];
        $nama_pegawai = $row['nama_pegawai'];
        $kegiatan = $row['kegiatan'];
        $poin = $row['poin'];
    } else {
        echo "<script>alert('Data tidak ditemukan.');window.location='kegiatan-index.php';</script>";
        exit;
    }
}

// Check if form is submitted for update
if (isset($_POST['update'])) {
    $id_kegiatan = $_POST['id_kegiatan'];
    $id_pegawai = $_POST['id_pegawai'];
    $kegiatan = $_POST['kegiatan'];
    $poin_baru = $_POST['poin'];

    // Fetch the original point value before the update
    $query = "SELECT poin FROM kegiatan WHERE id = '$id_kegiatan'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    $poin_lama = $row['poin'];

    // Calculate the difference between the new and old points
    $poin_selisih = $poin_baru - $poin_lama;

    // Get the nama_pegawai based on id_pegawai
    $pegawaiQuery = "SELECT nama FROM pegawai WHERE id = '$id_pegawai'";
    $pegawaiResult = mysqli_query($koneksi, $pegawaiQuery);
    $pegawaiRow = mysqli_fetch_assoc($pegawaiResult);
    $nama_pegawai = $pegawaiRow['nama'];

    // Update the kegiatan data in the database
    $updateQuery = "UPDATE kegiatan SET id_pegawai = '$id_pegawai', nama_pegawai = '$nama_pegawai', kegiatan = '$kegiatan', poin = '$poin_baru' WHERE id = '$id_kegiatan'";
    
    if (mysqli_query($koneksi, $updateQuery)) {
        // Update the total points in the pegawai table
        $updatePoinQuery = "UPDATE pegawai SET point = point + '$poin_selisih' WHERE id = '$id_pegawai'";
        mysqli_query($koneksi, $updatePoinQuery);

        echo "<script>alert('Data berhasil diperbarui.');window.location='kegiatan-index.php';</script>";
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($koneksi);
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Kegiatan</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form Edit Kegiatan</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
          <div class="form-group">
            <label for="id_pegawai">Nama Pegawai</label>
            <select class="form-control" id="id_pegawai" name="id_pegawai" required>
              <?php
              // Fetch all employees from the pegawai table
              $pegawaiQuery = "SELECT id, nama FROM pegawai";
              $pegawaiResult = mysqli_query($koneksi, $pegawaiQuery);
              while ($row = mysqli_fetch_assoc($pegawaiResult)) {
                  $selected = ($row['id'] == $id_pegawai) ? 'selected' : '';
                  echo "<option value='" . $row['id'] . "' $selected>" . $row['nama'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="kegiatan">Kegiatan</label>
            <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="<?php echo $kegiatan; ?>" required>
          </div>
          <div class="form-group">
            <label for="poin">Point</label>
            <input type="number" class="form-control" id="poin" name="poin" value="<?php echo $poin; ?>" required>
          </div>
          <button type="submit" name="update" class="btn btn-primary">Perbarui Data</button>
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
include('templates/footer.php');
?>
