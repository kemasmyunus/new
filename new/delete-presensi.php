<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the record
    $delete_query = "DELETE FROM presensi_pegawai WHERE id = '$id'";
    if (mysqli_query($koneksi, $delete_query)) {
        header('Location: presensi-index.php'); // Redirect to the main page after deletion
    } else {
        echo "Error deleting record: " . mysqli_error($koneksi);
    }
}
?>
