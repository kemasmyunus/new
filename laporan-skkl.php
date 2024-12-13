<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan SKKL</title>
  <link rel="stylesheet" href="assets/dist/css/normalize.min.css">
  <link rel="stylesheet" href="assets/dist/css/paper.css">
  <link rel="stylesheet" href="assets/dist/css/bs.css">
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
  include('koneksi.php');
  setlocale(LC_TIME, 'id_ID.UTF-8');

  // Fetch the name of the person responsible for the signature
  $query_pejabat = "SELECT nama FROM pejabat_desa WHERE ttd IS NOT NULL LIMIT 1";
  $result_pejabat = mysqli_query($koneksi, $query_pejabat) or die(mysqli_error($koneksi));
  $row_pejabat = mysqli_fetch_assoc($result_pejabat);
  $nama_ttd = $row_pejabat['nama'] ?? 'Nama Tidak Tersedia';

  // Get the date filter values from the URL
  $tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
  $tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';

  // Fetch data from the 'skkl' table and related 'penduduk' table
  $query_skkl = "
    SELECT 
      skkl.id,
      skkl.no_skkl,
      skkl.id_user,
      skkl.tgl_lahir,
      skkl.nama_anak,
      skkl.jenis_kelamin,
      penduduk.nama AS nama_penduduk
    FROM 
      skkl
    JOIN
      penduduk ON skkl.id_user = penduduk.user_id
    WHERE 
      skkl.tgl_lahir BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'
  ";
  $result_skkl = mysqli_query($koneksi, $query_skkl) or die(mysqli_error($koneksi));
  ?>

  <section class="sheet padding-10mm" style="height: auto; font-size: 10px;">
    <img src="assets/img/logo-desa.png" style="width: 50px; float: left; margin-right: 10px;" class="text-center">
    <h3 class="text-center" style="margin-bottom: -10px;"><b> PEMERINTAHAN BANJARMASIN</b></h3>
    <h3 class="text-center" style="margin-bottom: -10px;"><b>KECAMATAN BANJARMASIN UTARA</b></h3>
    <h3 class="text-center" style="margin-bottom: -10px;"><b>KELUARAHAN SURGI MUFTI</b></h3>
    <p class="text-center" style="margin-bottom: 10px;">Jalan Jahri Saleh RT.19, Surgi Mufti, Kecamatan Banjarmasin Utara, Kota Banjarmasin, 70122</p>
    <div style="width: 100%; height: 2px; background-color: #3d3d3d; -webkit-print-color-adjust: exact;"></div>
    <hr>
    <h4 class="text-center">LAPORAN SURAT KETERANGAN KELAHIRAN (SKKL)</h4>
    <hr>
    <p>Laporan data Surat Keterangan Kelahiran dari tanggal <?= $tanggal_mulai; ?> sampai tanggal <?= $tanggal_selesai; ?></p>

    <table class="table table-bordered" id="example2">
      <thead>
        <tr>
          <th>No</th>
          <th>No SKKL</th>
          <th>Nama</th>
          <th>Tanggal Lahir</th>
          <th>Nama Anak</th>
          <th>Jenis Kelamin</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result_skkl)) {
        ?>
          <tr>
            <td><?= $no; ?></td>
            <td><?= $row['no_skkl']; ?></td>
            <td><?= $row['nama_penduduk']; ?></td>
            <td><?= $row['tgl_lahir']; ?></td>
            <td><?= $row['nama_anak']; ?></td>
            <td><?= $row['jenis_kelamin']; ?></td>
          </tr>
        <?php $no++; } ?>
      </tbody>
    </table>

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
