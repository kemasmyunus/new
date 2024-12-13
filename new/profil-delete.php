<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('koneksi.php'); // Include database connection

session_start(); // Ensure session is started

// Get the user ID from the session
$id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

// Handle deletion only if ID is valid and if the deletion request is made
if ($id = $id) {
    // Delete associated penduduk data where user_id matches the session user ID
    $delete_penduduk_query = "DELETE FROM penduduk WHERE user_id = '$id'";
    if (mysqli_query($koneksi, $delete_penduduk_query)) {
        // Delete user from `users` table
        $delete_user_query = "DELETE FROM users WHERE id = '$id'";
        if (mysqli_query($koneksi, $delete_user_query)) {
            // Clear session and redirect to login page
            session_destroy();
            header("Location: login.php");
            exit();
        } else {
            die("Error deleting user: " . mysqli_error($koneksi));
        }
    } else {
        die("Error deleting penduduk data: " . mysqli_error($koneksi));
    }
}
?>

<!-- Link/Button to trigger deletion -->
