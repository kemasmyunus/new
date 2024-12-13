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

  // Fetch data from the 'skm' table with a join to get user names
  $query_skm = "
    SELECT 
      skm.no_skm, 
      u.nama AS user_name, 
      skm.jk, 
      skm.tgl_lahir, 
      skm.agama, 
      skm.pekerjaan, 
      skm.nik, 
      skm.alamat, 
      skm.warga, 
      skm.keperluan 
    FROM 
      skm 
    JOIN 
      users u ON skm.id_user = u.id
    WHERE 
      skm.tanggal_dibuat BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'
  ";
  $result_skm = mysqli_query($koneksi, $query_skm) or die(mysqli_error($koneksi));
  ?>

  <section class="sheet padding-10mm" style="height: auto; font-size: 10px;">
    <img src="assets/img/logo-desa.png" style="width: 50px; float: left; margin-right: 10px;" class="text-center">
    <h3 class="text-center" style="margin-bottom: -10px;"><b> PEMERINTAHAN BANJARMASIN</b></h3>
    <h3 class="text-center" style="margin-bottom: -10px;"><b>KECAMATAN BANJARMASIN UTARA</b></h3>
    <h3 class="text-center" style="margin-bottom: -10px;"><b>KELUARAHAN SURGI MUFTI</b></h3>
    <p class="text-center" style="margin-bottom: 10px;">Jalan Jahri Saleh RT.19, Surgi Mufti, Kecamatan Banjarmasin Utara, Kota Banjarmasin, 70122</p>
    <div style="width: 100%; height: 2px; background-color: #3d3d3d; -webkit-print-color-adjust: exact;"></div>
    <hr>
    <h4 class="text-center">LAPORAN SURAT KETERANGAN TIDAK MAMPU</h4>
    <hr>
    <p>Laporan Surat Keterangan Tidak Mampu dari tanggal <?= $tanggal_mulai; ?> sampai tanggal <?= $tanggal_selesai; ?></p>

    <table class="table table-bordered" id="example2">
      <thead>
        <tr>
          <th>No SKM</th>
          <th>Nama User</th>
          <th>Jenis Kelamin</th>
          <th>Tanggal Lahir</th>
          <th>Agama</th>
          <th>Pekerjaan</th>
          <th>NIK</th>
          <th>Alamat</th>
          <th>Warga</th>
          <th>Keperluan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1; // For row numbering
        $jumlah_laki = 0;
        $jumlah_perempuan = 0;
        while ($row = mysqli_fetch_assoc($result_skm)) {
          if ($row['jk'] == 'Laki-laki') {
            $jumlah_laki++;
          } elseif ($row['jk'] == 'Perempuan') {
            $jumlah_perempuan++;
          }
        ?>
          <tr>
            <td><?= $row['no_skm']; ?></td>
            <td><?= $row['user_name']; ?></td>
            <td><?= $row['jk']; ?></td>
            <td><?= $row['tgl_lahir']; ?></td>
            <td><?= $row['agama']; ?></td>
            <td><?= $row['pekerjaan']; ?></td>
            <td><?= $row['nik']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td><?= $row['warga']; ?></td>
            <td><?= $row['keperluan']; ?></td>
          </tr>
        <?php $no++;
        } ?>
      </tbody>
    </table>
    <div>
      <p>Keterangan pengaju berdasarkan jenis kelamin:</p>
      <p>a. Jumlah laki-laki: <?= $jumlah_laki; ?></p>
      <p>b. Jumlah perempuan: <?= $jumlah_perempuan; ?></p>
    </div>
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