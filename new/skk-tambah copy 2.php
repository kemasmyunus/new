<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Memanggil file koneksi

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan data dari tabel penduduk
$query_penduduk = "SELECT * FROM penduduk WHERE user_id = '$user_id'";
$result_penduduk = mysqli_query($koneksi, $query_penduduk);
$data_penduduk = mysqli_fetch_assoc($result_penduduk); // Ambil data sebagai array asosiatif

// Query untuk mendapatkan nomor SKK berikutnya
$query_skk = "SELECT MAX(no_skk) AS max_no_skk FROM skk";
$result_skk = mysqli_query($koneksi, $query_skk);
if ($result_skk) {
  $row_skk = mysqli_fetch_assoc($result_skk);
  $next_no_skk = $row_skk['max_no_skk'] + 1;
} else {
  $next_no_skk = 1; // Jika tabel kosong, mulai dari 1
}

// Proses penyimpanan data saat form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $no_skk = $_POST['no_skk'];
  $id_user = $_POST['id_user'];
  $nama2 = $_POST['nama2'];
  $jk = $_POST['jk'];
  $jk2 = $_POST['jk2'];
  $tgl_lahir = $_POST['tgl_lahir'];
  $agama = $_POST['agama'];
  $agama2 = $_POST['agama2'];
  $nik = $_POST['nik'];
  $nik2 = $_POST['nik2'];
  $alamat = $_POST['alamat'];
  $alamat2 = $_POST['alamat2'];
  $hubungan = $_POST['hubungan'];
  $status = 'Menuggu';
  $sebab = $_POST['sebab'];
  $hari = $_POST['hari'];
  $tanggal = $_POST['tanggal'];
  $waktu = $_POST['waktu'];
  $tempat = $_POST['tempat'];

  $query_insert = "INSERT INTO skk (no_skk, id_user, nama2, jk, jk2, tgl_lahir, agama, agama2, nik, alamat, nik2, alamat2, hubungan, status, sebab, hari, tanggal, waktu, tempat) 
                   VALUES ('$no_skk', '$id_user', '$nama2', '$jk', '$jk2', '$tgl_lahir', '$agama', '$agama2', '$nik', '$alamat', '$nik2', '$alamat2', '$hubungan', '$status', '$sebab', '$hari', '$tanggal', '$waktu', '$tempat')";

  $result_insert = mysqli_query($koneksi, $query_insert) or die(mysqli_error($koneksi));

  if ($result_insert) {
    echo "<script>alert('Data berhasil ditambahkan.');window.location='skk-index.php';</script>";
  } else {
    echo "<script>alert('Data gagal ditambahkan.');window.location='skk-tambah.php';</script>";
  }
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-8">
          <h1>Tambah Data Surat Keterangan Kematian</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form Tambah Data</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <div class="form-group">
            <label for="no_skk">No SK</label>
            <input type="text" class="form-control" id="no_skk" name="no_skk" value="<?php echo $next_no_skk; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="nama2">Nama</label>
            <input type="text" class="form-control" id="nama2" name="nama2" value="<?php echo htmlspecialchars($data_penduduk['nama'] ?? ''); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" value="<?php echo htmlspecialchars($data_penduduk['nik'] ?? ''); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="jk">Jenis Kelamin</label>
            <input type="text" class="form-control" id="jk" name="jk" value="<?php echo htmlspecialchars($data_penduduk['jk'] ?? ''); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="agama">Agama</label>
            <input type="text" class="form-control" id="agama" name="agama" value="<?php echo htmlspecialchars($data_penduduk['agama'] ?? ''); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" readonly><?php echo htmlspecialchars($data_penduduk['alamat'] ?? ''); ?></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </section>
</div>

<?php
include('templates/footer.php');
?>
