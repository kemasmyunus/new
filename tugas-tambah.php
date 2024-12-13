<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Include the database connection file

// Check if form is submitted
if (isset($_POST['submit'])) {
    $id_pegawai = $_POST['id_pegawai'];
    $tugas = $_POST['tugas'];
    $poin = $_POST['poin'];
    $bulan = $_POST['bulan']; // Get the bulan value from the POST request

    // Get the nama_pegawai based on id_pegawai
    $pegawaiQuery = "SELECT nama FROM pegawai WHERE id = '$id_pegawai'";
    $pegawaiResult = mysqli_query($koneksi, $pegawaiQuery);
    $pegawaiRow = mysqli_fetch_assoc($pegawaiResult);
    $nama_pegawai = $pegawaiRow['nama'];

    // Insert the new tugas data into the database
    $query = "INSERT INTO tugas (id_pegawai, nama_pegawai, tugas, poin, bulan) VALUES ('$id_pegawai', '$nama_pegawai', '$tugas', '$poin', '$bulan')";

    if (mysqli_query($koneksi, $query)) {
        // Update the total points in the pegawai table
        $updateQuery = "UPDATE pegawai SET point = point + '$poin' WHERE id = '$id_pegawai'";
        mysqli_query($koneksi, $updateQuery);

        echo "<script>alert('Data berhasil ditambahkan.');window.location='tugas-index.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
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
          <h1>Tambah tugas</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form Tambah tugas</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <div class="form-group">
            <label for="id_pegawai">Nama Pegawai</label>
            <select class="form-control" id="id_pegawai" name="id_pegawai" required>
              <?php
              // Fetch all employees from the pegawai table
              $pegawaiQuery = "SELECT id, nama FROM pegawai";
              $pegawaiResult = mysqli_query($koneksi, $pegawaiQuery);
              while ($row = mysqli_fetch_assoc($pegawaiResult)) {
                  echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="tugas">Tugas</label>
            <input type="text" class="form-control" id="tugas" name="tugas" required>
          </div>
          <div class="form-group">
            <label for="poin">Point</label>
            <input type="number" class="form-control" id="poin" name="poin" required>
          </div>
          <div class="form-group">
            <label for="bulan">Bulan</label>
            <select class="form-control" id="bulan" name="bulan" required>
              <option value="Januari">Januari</option>
              <option value="Februari">Februari</option>
              <option value="Maret">Maret</option>
              <option value="April">April</option>
              <option value="Mei">Mei</option>
              <option value="Juni">Juni</option>
              <option value="Juli">Juli</option>
              <option value="Agustus">Agustus</option>
              <option value="September">September</option>
              <option value="Oktober">Oktober</option>
              <option value="November">November</option>
              <option value="Desember">Desember</option>
            </select>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
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
