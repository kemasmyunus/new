<?php
ob_start(); // Start output buffering
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current data for this record
    $edit_query = "SELECT * FROM presensi_pegawai WHERE id = '$id'";
    $edit_result = mysqli_query($koneksi, $edit_query);
    $edit_data = mysqli_fetch_assoc($edit_result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_pegawai = $_POST['id_pegawai'];
        $tanggal = $_POST['tanggal'];
        $presensi = $_POST['presensi'];

        // Update the record
        $update_query = "UPDATE presensi_pegawai SET id_pegawai='$id_pegawai', tanggal='$tanggal', presensi='$presensi' WHERE id='$id'";
        if (mysqli_query($koneksi, $update_query)) {
            header('Location: presensi-index.php'); // Redirect to the main page after updating
            exit(); // Ensure no further code is executed after redirect
        } else {
            echo "Error updating record: " . mysqli_error($koneksi);
        }
    }
} else {
    header('Location: presensi-index.php');
    exit(); // Ensure no further code is executed after redirect
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Halaman Presensi Pegawai</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Form for attendance -->

            <!-- Edit Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Edit Presensi</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="id_pegawai">Nama Pegawai</label>
                            <select id="id_pegawai" name="id_pegawai" class="form-control" required>
                                <?php
                                $pegawai_query = "SELECT id, nama FROM pegawai";
                                $pegawai_result = mysqli_query($koneksi, $pegawai_query);
                                while ($pegawai = mysqli_fetch_assoc($pegawai_result)) :
                                ?>
                                    <option value="<?= $pegawai['id'] ?>" <?= $pegawai['id'] == $edit_data['id_pegawai'] ? 'selected' : '' ?>><?= $pegawai['nama'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $edit_data['tanggal'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="presensi">Presensi</label>
                            <select id="presensi" name="presensi" class="form-control" required>
                                <option value="hadir" <?= $edit_data['presensi'] == 'hadir' ? 'selected' : '' ?>>Hadir</option>
                                <option value="izin" <?= $edit_data['presensi'] == 'izin' ? 'selected' : '' ?>>Izin</option>
                                <option value="sakit" <?= $edit_data['presensi'] == 'sakit' ? 'selected' : '' ?>>Sakit</option>
                                <option value="alpha" <?= $edit_data['presensi'] == 'alpha' ? 'selected' : '' ?>>Alpha</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
<?php
include('templates/footer.php');
ob_end_flush(); // Flush the output buffer
?>
