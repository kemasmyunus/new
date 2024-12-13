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
$query = "
    SELECT 
        skk.no_skk, 
        users.nama,
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
        skk.tempat, 
        skk.status, 
        skk.file 
    FROM 
        skk 
    JOIN 
        users 
    ON 
        skk.id_user = users.id 
    WHERE 
        skk.id = '$id'
";

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
        <title>Surat Keterangan Kematian</title>
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

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            td {
                padding: 5px;
                vertical-align: top;
            }

            .info-table td {
                width: 50%;
            }

            .footer-table {
                width: 100%;
                font-size: 12px;
                margin-top: 30px;
            }

            .footer-table td {
                text-align: center;
            }

            .signature {
                width: 200px;
                float: right;
                margin-top: 60px;
                text-align: center;
            }
        </style>
    </head>

    <body class="A4">
        <section class="sheet padding-10mm" style="height: auto;font-size: 12px;">
            <img src="assets/img/logo-desa.png" style="width: 50px;float: left;margin-right: 10px;" class="text-center">
            <h3 class="text-center" style="margin-bottom: -10px;"><b> PEMERINTAHAN BANJARMASIN</b></h3>
            <h3 class="text-center" style="margin-bottom: -10px;"><b>KECAMATAN BANJARMASIN UTARA</b></h3>
            <h3 class="text-center" style="margin-bottom: -10px;"><b>KELUARAHAN SURGI MUFTI</b></h3>
            <p class="text-center" style="margin-bottom: 10px;">
                Jalan Jahri Saleh RT.19, Surgi Mufti, Kecamatan Banjarmasin Utara, Kota Banjarmasin, 70122
            </p>
            <hr>
            <h4 class="text-center"><b><u>SURAT KETERANGAN KEMATIAN</u></b></h4>
            <p class="text-center">Nomor: <?= $row['no_skk']; ?>/X/<?= date('Y'); ?></p>

            <p>Yang bertanda tangan di bawah ini, Lurah Surgi Mufti, Kecamatan Banjarmasin Utara, Banjarmasin, menerangkan bahwa:</p>

            <table class="info-table">
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>: <?= $row['nama']; ?></td>
                </tr>
                <tr>
                    <td><strong>Nik</strong></td>
                    <td>: <?= $row['nik']; ?></td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>: <?= $row['jk']; ?></td>
                </tr>
                <tr>
                    <td><strong>Agama</strong></td>
                    <td>: <?= $row['agama']; ?></td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td>: <?= $row['alamat']; ?></td>
                </tr>
            </table>

            <p>Warga tersebut di atas adalah benar warga Kelurahan Surgi Mufti yang telah meninggal dunia berdasarkan laporan dari:</p>

            <table class="info-table">
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>: <?= $row['nama2']; ?></td>
                </tr>
                <tr>
                    <td><strong>Nik</strong></td>
                    <td>: <?= $row['nik2']; ?></td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>: <?= $row['jk2']; ?></td>
                </tr>
                <tr>
                    <td><strong>Tmp. & Tgl. Lahir</strong></td>
                    <td>: <?= $row['tgl_lahir']; ?></td>
                </tr>
                <tr>
                    <td><strong>Agama</strong></td>
                    <td>: <?= $row['agama2']; ?></td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td>: <?= $row['alamat2']; ?></td>
                </tr>
                <tr>
                    <td><strong>Hubungan Dengan Alm/Almh.</strong></td>
                    <td>: <?= $row['hubungan']; ?></td>
                </tr>
            </table>

            <h5><b>KETERANGAN TEMPAT/WAKTU & SEBAB KEMATIAN</b></h5>
            <table class="info-table">
                <tr>
                    <td><strong>Sebab</strong></td>
                    <td>: <?= $row['sebab']; ?></td>
                </tr>
                <tr>
                    <td><strong>Hari</strong></td>
                    <td>: <?= $row['hari']; ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: <?= $row['tanggal']; ?></td>
                </tr>
                <tr>
                    <td><strong>Waktu</strong></td>
                    <td>: <?= $row['waktu']; ?></td>
                </tr>
                <tr>
                    <td><strong>Tempat</strong></td>
                    <td>: <?= $row['tempat']; ?></td>
                </tr>
            </table>

            <p>Demikian surat keterangan ini dibuat dengan sebenar-benarnya dan digunakan sebagaimana mestinya.</p>

            <div class="signature">
                <strong>Surgi Mufti, <?= strftime('%d %B %Y'); ?></strong><br>
                <strong>Lurah Surgi Mufti</strong>
                <br>
                    <?php if ($tampilkanTandaTangan && $tandaTanganFile): ?>
                        <img src="<?= $tandaTanganFile ?>" alt="Tanda Tangan" style="width: 150px;">
                    <?php endif; ?>
                <br>
                <strong><u><?= $nama_ttd; ?></u></strong>
            </div>
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