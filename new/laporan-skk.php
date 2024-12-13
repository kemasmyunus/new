<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>LAPORAN</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="assets/dist/css/normalize.min.css">
  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="assets/dist/css/paper.css">
  <link rel="stylesheet" href="assets/dist/css/bs.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "" if you need -->
  <style>
    body {
      background-color: #999;
    }

    @page {
      size: A4 landscape
    }

    * {
      font-family: "Arial";
    }

    .text-center {
      text-align: center;
    }

    h1 {
      font-size: 20px;
    }

    h3 {
      font-size: 14px;
      font-weight: normal;
      margin-top: -8px;
    }

    h4 {
      margin-top: 20px;
      text-transform: uppercase;
      margin-bottom: -10px;
    }

    td {
      padding: 5px !important;
      text-align: center;
      vertical-align: middle !important;
    }
  </style>
</head>

<body class="A4 landscape">
  <?php
  include('koneksi.php'); // Include the database connection
  setlocale(LC_TIME, 'id_ID.UTF-8');

  // Fetch the name of the person responsible for the signature
  $query_pejabat = "SELECT nama FROM pejabat_desa WHERE ttd IS NOT NULL LIMIT 1";
  $result_pejabat = mysqli_query($koneksi, $query_pejabat) or die(mysqli_error($koneksi));
  $row_pejabat = mysqli_fetch_assoc($result_pejabat);
  $nama_ttd = $row_pejabat['nama'] ?? 'Nama Tidak Tersedia';
  // Get the date filter values from the URL
  $tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
  $tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';

  // Fetch data from the 'skk' table with a join to get user names for the first table
  $query_skk = "
    SELECT 
      skk.no_skk, 
      u.nama AS user_name,
      skk.nama2, 
      skk.jk, 
      skk.jk2, 
      skk.tgl_lahir, 
      skk.agama,
      skk.agama2, 
      skk.nik,
      skk.nik2, 
      skk.alamat,
      skk.alamat2, 
      skk.hubungan,
      skk.sebab,
      skk.hari,
      skk.tanggal,
      skk.waktu,
      skk.tempat
    FROM 
      skk 
    JOIN 
      users u ON skk.id_user = u.id
    WHERE 
      skk.tanggal_dibuat BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'
  ";
  $result_skk = mysqli_query($koneksi, $query_skk) or die(mysqli_error($koneksi));

  // Fetch the result into an array for repeated use
  $data_skk = [];
  $jumlah_laki_laki = 0;
  $jumlah_perempuan = 0;
  $jumlah_laki_laki2 = 0;
  $jumlah_perempuan2 = 0;

  while ($row = mysqli_fetch_assoc($result_skk)) {
      $data_skk[] = $row;
      // Hitung jumlah laki-laki dan perempuan
      if ($row['jk'] === 'Laki-laki') {
          $jumlah_laki_laki++;
      } elseif ($row['jk'] === 'Perempuan') {
          $jumlah_perempuan++;
      }
      // Hitung jumlah laki-laki dan perempuan
      if ($row['jk2'] === 'Laki-laki') {
          $jumlah_laki_laki2++;
      } elseif ($row['jk2'] === 'Perempuan') {
          $jumlah_perempuan2++;
      }
  }
  ?>

  <section class="sheet padding-10mm" style="height: auto; font-size: 10px;">
    <img src="assets/img/logo-desa.png" style="width: 50px; float: left; margin-right: 10px;" class="text-center">
    <h3 class="text-center" style="margin-bottom: -10px;"><b> PEMERINTAHAN BANJARMASIN</b></h3>
    <h3 class="text-center" style="margin-bottom: -10px;"><b>KECAMATAN BANJARMASIN UTARA</b></h3>
    <h3 class="text-center" style="margin-bottom: -10px;"><b>KELUARAHAN SURGI MUFTI</b></h3>
    <p class="text-center" style="margin-bottom: 10px;">Jalan Jahri Saleh RT.19, Surgi Mufti, Kecamatan Banjarmasin Utara, Kota Banjarmasin, 70122</p>
    <div style="width: 100%; height: 2px; background-color: #3d3d3d; -webkit-print-color-adjust: exact;"></div>
    <hr>
    <h4 class="text-center">LAPORAN SURAT KETERANGAN KEMATIAN</h4>
    <hr>
    <p>Laporan Surat Keterangan Kematian dari tanggal <?= $tanggal_mulai; ?> sampai tanggal <?= $tanggal_selesai; ?></p>

    <table class="table table-bordered" id="example2">
      <thead>
        <tr>
          <th>No SKK</th>
          <th>Nama User</th>
          <th>Nik</th>
          <th>Tanggal Lahir</th>
          <th>Agama</th>
          <th>Alamat</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data_skk as $row) { ?>
          <tr>
            <td><?= $row['no_skk']; ?></td>
            <td><?= $row['user_name']; ?></td>
            <td><?= $row['nik']; ?></td>
            <td><?= $row['tgl_lahir']; ?></td>
            <td><?= $row['agama']; ?></td>
            <td><?= $row['alamat']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <!-- Tambahkan keterangan jenis kelamin di bawah tabel -->
    <p>Keterangan pengaju berdasarkan jenis kelamin:</p>
    <p>a. Jumlah laki-laki: <?= $jumlah_laki_laki2; ?></p>
    <p>b. Jumlah perempuan: <?= $jumlah_perempuan2; ?></p>

    <p>Warga yang Telah Meninggal Dunia</p>
    <table class="table table-bordered" id="example2">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Nik</th>
          <th>Tanggal Lahir</th>
          <th>Tmp.& lahir</th>
          <th>Agama</th>
          <th>Alamat</th>
          <th>Hubungan Dengan Alm/Almh</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($data_skk as $row) { ?>
          <tr>
            <td><?= $row['nama2']; ?></td>
            <td><?= $row['nik2']; ?></td>
            <td><?= $row['jk2']; ?></td>
            <td><?= $row['tgl_lahir']; ?></td>
            <td><?= $row['agama2']; ?></td>
            <td><?= $row['alamat2']; ?></td>
            <td><?= $row['hubungan']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <p>Keterangan Tempat/waktu & dan Sebab Kematian :</p>
    <table class="table table-bordered" id="example2">
      <thead>
        <tr>
          <th>Sebab</th>
          <th>Hari</th>
          <th>Tanggal</th>
          <th>Waktu</th>
          <th>Tempat</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data_skk as $row) { ?>
          <tr>
            <td><?= $row['sebab']; ?></td>
            <td><?= $row['hari']; ?></td>
            <td><?= $row['tanggal']; ?></td>
            <td><?= $row['waktu']; ?></td>
            <td><?= $row['tempat']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>


    <!-- Tambahkan keterangan jenis kelamin di bawah tabel -->
    <p>Keterangan pengaju berdasarkan jenis kelamin:</p>
    <p>a. Jumlah laki-laki: <?= $jumlah_laki_laki2; ?></p>
    <p>b. Jumlah perempuan: <?= $jumlah_perempuan2; ?></p>


    <table style="width: 200px; font-size: 11px; float:right; margin-top: 60px;">
      <tr>
        <th colspan="2">Surgi Mufti, <?= strftime('%d %B %Y'); ?></th>
      </tr>
      <tr>
        <th>Lurah Surgi Mufti</th>
      </tr>
      <tr style="height: 100px;">
        <td style="width: 50%"></td>
      </tr>
      <tr>
        <td style="text-align: center;"><?= $nama_ttd; ?></td>
      </tr>
    </table>
  </section>
  <script>
    window.print();
  </script>
</body>

</html>