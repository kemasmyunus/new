<?php
include('koneksi.php'); // Include the database connection

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=penduduk_data.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
        <th>No</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>tempat/tgl.Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Agama</th>
        <th>Alamat</th>
      </tr>";

$datas = mysqli_query($koneksi, "SELECT * FROM penduduk") or die(mysqli_error($koneksi));

$no = 1;
while ($row = mysqli_fetch_assoc($datas)) {
  echo "<tr>
            <td>{$no}</td>
            <td>{$row['nik']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['tgl']}</td>
            <td>{$row['jk']}</td>
            <td>{$row['agama']}</td>
            <td>{$row['alamat']}</td>
          </tr>";
  $no++;
}

echo "</table>";
