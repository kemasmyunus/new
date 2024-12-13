<?php
include('koneksi.php'); // Memanggil file koneksi

// Fungsi untuk mencari nomor tertinggi
function cariNomorTertinggi($folderPath) {
    $nomorTertinggi = 0;

    if (is_dir($folderPath)) {
        $files = scandir($folderPath);

        foreach ($files as $file) {
            if (preg_match('/tanda_tangan_(\d+)\.png$/', $file, $matches)) {
                $nomor = (int)$matches[1];
                if ($nomor > $nomorTertinggi) {
                    $nomorTertinggi = $nomor;
                }
            }
        }
    }

    return $nomorTertinggi;
}

// Path ke folder tanda tangan
$folderPath = "assets/img/tanda_tangan/";
$nomorTertinggi = cariNomorTertinggi($folderPath);

// Tentukan file tanda tangan
$tandaTanganFile = $nomorTertinggi > 0 ? $folderPath . "tanda_tangan_" . $nomorTertinggi . ".png" : null;

$query_pejabat = "SELECT nama FROM pejabat_desa WHERE ttd IS NOT NULL LIMIT 1";
$result_pejabat = mysqli_query($koneksi, $query_pejabat) or die(mysqli_error($koneksi));
$row_pejabat = mysqli_fetch_assoc($result_pejabat);
$nama_ttd = $row_pejabat['nama'] ?? 'Nama Tidak Tersedia';
// Mendapatkan ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Query untuk mendapatkan data surat berdasarkan ID
$query = "SELECT sku.no_sku, users.nama, sku.jk, sku.usaha, sku.keperluan, sku.tgl_lahir, sku.agama, sku.pekerjaan, sku.nik, sku.alamat, sku.warga, sku.status, sku.file, sku.alamat_usaha FROM sku JOIN users ON sku.id_user = users.id WHERE sku.id = '$id'";

$result = mysqli_query($koneksi, $query);

if ($row = mysqli_fetch_assoc($result)) {
    // Periksa apakah status adalah "Disetujui"
    $status = $row['status'];
    $tampilkanTandaTangan = ($status == "Disetujui");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Surat </title>
        <link rel="stylesheet" href="assets/dist/css/normalize.min.css">
        <link rel="stylesheet" href="assets/dist/css/paper.css">
        <link rel="stylesheet" href="assets/dist/css/bs.css">
        <style>
            body {
                background-color: #999;
            }

            @page {
                size: A4 portrait;
            }

            * {
                font-family: "Arial";
            }

            .text-center {
                text-align: center;
            }

            p {
                margin: 5px 0;
            }

            h1 {
                font-size: 24px;
            }

            h3 {
                font-size: 16px;
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
                margin-right: 80px;
                text-align: left;
                vertical-align: middle !important;
            }





            table {
                width: 70%;
                margin: 10px auto;
            }



            .tabbed {
                padding-left: 40px;
            }
        </style>
    </head>

    <body class="A4">
        <section class="sheet padding-10mm" style="height: auto;font-size: 12px;">
            <img src="assets/img/logo-desa.png" style="width: 50px;float: left;margin-right: 10px;" class="text-center">
            <h3 class="text-center" style="margin-bottom: -10px;"><b> PEMERINTAHAN BANJARMASIN</b></h3>
            <h3 class="text-center" style="margin-bottom: -10px;"><b>KECAMATAN BANJARMASIN UTARA</b> </h3>
            <h3 class="text-center" style="margin-bottom: -10px;"><b>KELUARAHAN SURGI MUFTI</b></h3>
            <p class="text-center" style="margin-bottom: 10px;">Jalan Jahri Saleh RT.19, surgi Mufti, Kecamatan Banjarmasin Utara, kota banjarmasin, 70122</p>
            <div style="width: 100%; height: 2px; background-color: #3d3d3d; -webkit-print-color-adjust: exact;"></div>
            <hr>
            <h3 class="text-center" style="margin-bottom: -10px;"><b><u>SURAT KETERANGAN USAHA</u></b></h3>
            <p class="text-center" style="margin-bottom: 0px;">Nomor: <?= $row['no_sku']; ?>/X/SKU/<?= date('Y'); ?></p>
            <br>
            <p class="tabbed">Yang bertanda tangan di bawah ini, Lurah Surgi Mufti, Kecamatan Banjarmasin Utara, Banjarmasin, menerangkan dengan sebenarnya bahwa :</p>

            <table>
                <tr class="tabel">
                    <td><strong>Nama</strong></td>
                    <td><b>:<?= $row['nama']; ?></b></td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>:<?= $row['jk']; ?></td>
                </tr>
                <tr>
                    <td><strong>Keperluan</strong></td>
                    <td>:<?= $row['keperluan']; ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>:<?= $row['tgl_lahir']; ?></td>
                </tr>
                <tr>
                    <td><strong>Agama</strong></td>
                    <td>:<?= $row['agama']; ?></td>
                </tr>
                <tr>
                    <td><strong>Pekerjaan</strong></td>
                    <td>:<?= $row['pekerjaan']; ?></td>
                </tr>
                <tr>
                    <td><strong>NIK</strong></td>
                    <td>:<?= $row['nik']; ?></td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td>:<?= $row['alamat']; ?></td>
                </tr>
                <tr>
                    <td><strong>Kewarganegaraan </strong></td>
                    <td>:<?= $row['warga']; ?></td>
                </tr>

            </table>
            <p class="tabbed"><b><u>MENERANGKAN BAHWA :</u></b></p>
            <p class="tabbed">- Nama tersebut di atas benar-benar warga kelurahan kami, dengan alamat diatas.</p>
            <p class="tabbed">- Nama tersebut di atas benar-benar mempunyai usaha di <?= $row['alamat_usaha']; ?></p>
            <p class="tabbed">- Usahanya berupa :</p>
            <p class="tabbed text-center"><b><u>"<?= $row['usaha']; ?>"</u></b></p>
            <p class="tabbed">- Surat Keterangan ini dipergunakan untuk :</p>
            <p class="tabbed text-center"><b><u>"<?= $row['keperluan']; ?>"</u></b></p>
            <p class="tabbed">Demikian surat keterangan ini dibuat dengan sebenar-benarnya dan digunakan sebagaimana mestinya.
            </p>
            <table style="width: 100%;font-size: 12px; margin-top: 30px;">
                <tr>
                    <td style="width: 5%;"></td>
                    <td style="width: 5%; text-align: center;">
                        <strong>TTD. Bersangkutan</strong>
                        <br><br><br><br>
                        <strong><u><?= $row['nama']; ?></u></strong>
                    </td>
                    <td style="width: 10%;"></td>
                    <td style="width: 10%; text-align: center;">
                        <strong>Surgi Mufti,<?= strftime('%d %B %Y'); ?></strong><br>
                        <strong>Lurah Surgi Mufti</strong>
                        <br>
                        <?php if ($tampilkanTandaTangan && $tandaTanganFile): ?>
                            <img src="<?= $tandaTanganFile ?>" alt="Tanda Tangan" style="width: 150px;">
                        <?php endif; ?>
                        <br>
                        <strong><u><?= $nama_ttd; ?></u></strong>
                    </td>
                </tr>
            </table>
        </section>
        <script>
            window.print();
        </script>
    </body>

    </html>
<?php
} else {
    echo "Data tidak ditemukan.";
}
?>