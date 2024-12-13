<?php
include('koneksi.php'); // Include the database connection file

if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id = $_GET['id'];
    $aksi = $_GET['aksi'];

    // Tentukan kolom yang akan diperbarui berdasarkan aksi
    switch ($aksi) {
        case 'hadir':
            $updateColumn = 'hadir';
            $pointIncrement = 200;
            break;
        case 'izin':
            $updateColumn = 'izin';
            $pointIncrement = 0; // Tidak ada poin untuk izin
            break;
        case 'sakit':
            $updateColumn = 'sakit';
            $pointIncrement = 0; // Tidak ada poin untuk sakit
            break;
        default:
            echo "<script>alert('Aksi tidak valid.');window.location='presensi-index.php';</script>";
            exit;
    }

    // Perbarui kolom presensi yang sesuai dan poin
    $query = "UPDATE pegawai SET $updateColumn = $updateColumn + 1, point = point + '$pointIncrement' WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Presensi berhasil diperbarui.');window.location='presensi-index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan.');window.location='presensi-index.php';</script>";
    }
} else {
    echo "<script>alert('Data tidak valid.');window.location='presensi-index.php';</script>";
}
?>
