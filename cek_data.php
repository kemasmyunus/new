<?php
// Memasukkan koneksi database
require 'koneksi.php';

// Menampilkan error jika ada
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Memeriksa apakah parameter 'nik' ada
if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    // Mengecek apakah NIK tidak kosong
    if (empty($nik)) {
        echo json_encode(['status' => 'error', 'message' => 'NIK kosong']);
        exit;
    }

    // Query untuk mencari data di tabel penduduk
    $stmt = $conn->prepare("SELECT nama, jk, tgl_lahir, agama, alamat FROM penduduk WHERE nik = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Query error: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode([
            'status' => 'found',
            'nama' => $data['nama'],
            'jk' => $data['jk'],
            'tgl_lahir' => $data['tgl_lahir'],
            'agama' => $data['agama'],
            'alamat' => $data['alamat']
        ]);
    } else {
        echo json_encode(['status' => 'not_found']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Parameter NIK tidak ditemukan']);
}

$conn->close();
?>
