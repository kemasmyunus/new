<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE);


$message = "";
$upload_dir = "assets/img/tanda_tangan/";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['signature'])) {
    $file = $_FILES['signature'];
    $file_name = "tanda_tangan_" . $_SESSION['user_id'] . ".png"; // Nama file berdasarkan user ID
    $file_tmp = $file['tmp_name'];
    $file_dest = $upload_dir . $file_name;

    // Validasi file
    $allowed_types = ['image/png'];
    if (in_array($file['type'], $allowed_types)) {
        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($file_tmp, $file_dest)) {
            $message = "Tanda tangan berhasil diunggah.";
        } else {
            $message = "Terjadi kesalahan saat mengunggah file.";
        }
    } else {
        $message = "Hanya file PNG yang diperbolehkan.";
    }
}

include('templates/header.php');
include('templates/sidebar.php');
?>

<div class="content-wrapper">
    <div class="container">
        <h1 class="page-title">Upload Tanda Tangan</h1>
        <p class="message"><?= $message; ?></p>

        <form action="tanda-tangan.php" method="POST" enctype="multipart/form-data" class="upload-form">
            <div class="form-group">
                <label for="signature">Unggah Tanda Tangan (PNG):</label>
                <input type="file" name="signature" id="signature" accept="image/png" required>
            </div>
            <button type="submit" class="submit-btn">Unggah</button>
        </form>

        <?php
        // Periksa apakah tanda tangan sudah diunggah
        $file_path = $upload_dir . "tanda_tangan_" . $_SESSION['user_id'] . ".png";
        if (file_exists($file_path)) {
            echo "<h2>Tanda Tangan Anda:</h2>";
            echo "<img src='$file_path' alt='Tanda Tangan' class='signature-img'>";
        }
        ?>
    </div>
</div>

<?php
include('templates/footer.php');
?>

<!-- Add some custom CSS here -->
<style>
    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        margin-left: 20px;  /* Menambahkan margin kiri agar tidak terlalu dekat dengan sidebar */
    }

    .page-title {
        font-size: 24px;
        margin-bottom: 15px;
    }

    .message {
        color: green;
        margin-bottom: 20px;
        text-align: left;
    }

    .upload-form {
        display: block;
    }

    .form-group {
        margin-bottom: 15px;
        width: 100%;
    }

    .form-group label {
        display: block;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .form-group input[type="file"] {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    .submit-btn {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        display: inline-block;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }

    .signature-img {
        display: block;
        margin-top: 20px;
        max-width: 200px;
        height: auto;
    }
</style>
