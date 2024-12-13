<?php
include('koneksi.php'); // Include connection file

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to delete the SKKL record
    $query = "DELETE FROM skkl WHERE id = '$id'";

    // Execute the query
    if (mysqli_query($koneksi, $query)) {
        // Redirect back to the SKKL index page with a success message
        header("Location: skkl-index.php?message=Data berhasil dihapus.");
        exit();
    } else {
        // If deletion failed, show error message
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // If ID is not provided, redirect to index page
    header("Location: skkl-index.php");
    exit();
}
?>
