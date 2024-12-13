<?php
// Display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Include the database connection file

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';
    $presensi_data = isset($_POST['presensi']) ? $_POST['presensi'] : [];

    foreach ($presensi_data as $id_pegawai => $presensi) {
        // Check if attendance record already exists for the given date
        $check_query = "SELECT * FROM presensi_pegawai WHERE id_pegawai = '$id_pegawai' AND tanggal = '$tanggal'";
        $check_result = mysqli_query($koneksi, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Update existing record
            $old_presensi_query = "SELECT presensi FROM presensi_pegawai WHERE id_pegawai = '$id_pegawai' AND tanggal = '$tanggal'";
            $old_presensi_result = mysqli_query($koneksi, $old_presensi_query);
            $old_presensi = mysqli_fetch_assoc($old_presensi_result)['presensi'];

            // Update points and counts
            if ($old_presensi == 'hadir' && $presensi != 'hadir') {
                // Deduct points if changing from 'hadir' to something else
                $deduct_points_query = "UPDATE pegawai SET point = point - 200 WHERE id = '$id_pegawai'";
                mysqli_query($koneksi, $deduct_points_query);
            } elseif ($old_presensi != 'hadir' && $presensi == 'hadir') {
                // Add points if changing to 'hadir'
                $add_points_query = "UPDATE pegawai SET point = point + 200 WHERE id = '$id_pegawai'";
                mysqli_query($koneksi, $add_points_query);
            }

            // Update the record
            $update_query = "UPDATE presensi_pegawai SET presensi = '$presensi' WHERE id_pegawai = '$id_pegawai' AND tanggal = '$tanggal'";
            mysqli_query($koneksi, $update_query);
        } else {
            // Insert new record
            $insert_query = "INSERT INTO presensi_pegawai (id_pegawai, tanggal, presensi) VALUES ('$id_pegawai', '$tanggal', '$presensi')";
            mysqli_query($koneksi, $insert_query);

            // Add points if 'hadir'
            if ($presensi == 'hadir') {
                $add_points_query = "UPDATE pegawai SET point = point + 200 WHERE id = '$id_pegawai'";
                mysqli_query($koneksi, $add_points_query);
            }
        }

        // Update counts
        $update_counts_query = "
            UPDATE pegawai
            SET 
                hadir = (
                    SELECT COUNT(*) FROM presensi_pegawai 
                    WHERE id_pegawai = '$id_pegawai' AND presensi = 'hadir'
                ),
                izin = (
                    SELECT COUNT(*) FROM presensi_pegawai 
                    WHERE id_pegawai = '$id_pegawai' AND presensi = 'izin'
                ),
                sakit = (
                    SELECT COUNT(*) FROM presensi_pegawai 
                    WHERE id_pegawai = '$id_pegawai' AND presensi = 'sakit'
                ),
                alpha = (
                    SELECT COUNT(*) FROM presensi_pegawai 
                    WHERE id_pegawai = '$id_pegawai' AND presensi = 'alpha'
                )
            WHERE id = '$id_pegawai'
        ";
        mysqli_query($koneksi, $update_counts_query);
    }
}

// Handle deletion of attendance records
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Get the presensi data before deleting
    $presensi_query = "SELECT id_pegawai, presensi FROM presensi_pegawai WHERE id = '$delete_id'";
    $presensi_result = mysqli_query($koneksi, $presensi_query);
    $presensi_data = mysqli_fetch_assoc($presensi_result);

    if ($presensi_data) {
        $id_pegawai = $presensi_data['id_pegawai'];
        $presensi = $presensi_data['presensi'];

        // Delete the record
        $delete_query = "DELETE FROM presensi_pegawai WHERE id = '$delete_id'";
        mysqli_query($koneksi, $delete_query);

        // Subtract points if 'hadir'
        if ($presensi == 'hadir') {
            $deduct_points_query = "UPDATE pegawai SET point = point - 200 WHERE id = '$id_pegawai'";
            mysqli_query($koneksi, $deduct_points_query);
        }

        // Update counts
        $update_counts_query = "
            UPDATE pegawai
            SET 
                hadir = (
                    SELECT COUNT(*) FROM presensi_pegawai 
                    WHERE id_pegawai = '$id_pegawai' AND presensi = 'hadir'
                ),
                izin = (
                    SELECT COUNT(*) FROM presensi_pegawai 
                    WHERE id_pegawai = '$id_pegawai' AND presensi = 'izin'
                ),
                sakit = (
                    SELECT COUNT(*) FROM presensi_pegawai 
                    WHERE id_pegawai = '$id_pegawai' AND presensi = 'sakit'
                ),
                alpha = (
                    SELECT COUNT(*) FROM presensi_pegawai 
                    WHERE id_pegawai = '$id_pegawai' AND presensi = 'alpha'
                )
            WHERE id = '$id_pegawai'
        ";
        mysqli_query($koneksi, $update_counts_query);
    }
}

// Handle date selection
$tanggal_hari_ini = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Fetch attendance data for the selected date
$attendance_query = "SELECT * FROM presensi_pegawai WHERE tanggal = '$tanggal_hari_ini'";
$attendance_result = mysqli_query($koneksi, $attendance_query);

// Fetch employee information
$employee_query = "SELECT * FROM pegawai";
$employee_result = mysqli_query($koneksi, $employee_query);

// Fetch employee attendance counts and points for display
$attendance_counts_query = "
    SELECT 
        pegawai.id, 
        pegawai.nama, 
        pegawai.nip,
        SUM(CASE WHEN presensi_pegawai.presensi = 'hadir' THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN presensi_pegawai.presensi = 'izin' THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN presensi_pegawai.presensi = 'sakit' THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN presensi_pegawai.presensi = 'alpha' THEN 1 ELSE 0 END) AS alpha,
        pegawai.point
    FROM pegawai
    LEFT JOIN presensi_pegawai ON pegawai.id = presensi_pegawai.id_pegawai
    GROUP BY pegawai.id
";
$attendance_counts_result = mysqli_query($koneksi, $attendance_counts_query);
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
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Formulir Presensi</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $tanggal_hari_ini ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Daftar Pegawai</label>
                            <?php
                            $pegawai_result = mysqli_query($koneksi, "SELECT id, nama FROM pegawai");
                            while ($pegawai = mysqli_fetch_assoc($pegawai_result)) :
                                // Get the existing attendance value for the given date
                                $presensi_result = mysqli_query($koneksi, "SELECT presensi FROM presensi_pegawai WHERE id_pegawai = '{$pegawai['id']}' AND tanggal = '$tanggal_hari_ini'");
                                $presensi_data = mysqli_fetch_assoc($presensi_result);
                                $presensi_value = $presensi_data ? $presensi_data['presensi'] : 'hadir'; // Default to 'hadir' if no data
                            ?>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input type="hidden" name="id_pegawai[]" value="<?= $pegawai['id'] ?>">
                                        <p class="form-control"><?= $pegawai['nama'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Radio buttons for attendance status -->
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="hadir_<?= $pegawai['id'] ?>" name="presensi[<?= $pegawai['id'] ?>]" value="hadir" class="form-check-input" <?= $presensi_value == 'hadir' ? 'checked' : '' ?>>
                                            <label for="hadir_<?= $pegawai['id'] ?>" class="form-check-label">Hadir</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="izin_<?= $pegawai['id'] ?>" name="presensi[<?= $pegawai['id'] ?>]" value="izin" class="form-check-input" <?= $presensi_value == 'izin' ? 'checked' : '' ?>>
                                            <label for="izin_<?= $pegawai['id'] ?>" class="form-check-label">Izin</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="sakit_<?= $pegawai['id'] ?>" name="presensi[<?= $pegawai['id'] ?>]" value="sakit" class="form-check-input" <?= $presensi_value == 'sakit' ? 'checked' : '' ?>>
                                            <label for="sakit_<?= $pegawai['id'] ?>" class="form-check-label">Sakit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="alpha_<?= $pegawai['id'] ?>" name="presensi[<?= $pegawai['id'] ?>]" value="alpha" class="form-check-input" <?= $presensi_value == 'alpha' ? 'checked' : '' ?>>
                                            <label for="alpha_<?= $pegawai['id'] ?>" class="form-check-label">Alpha</label>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
            <!-- Date selection for attendance records -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Pilih Tanggal Presensi</h3>
                </div>
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $tanggal_hari_ini ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>
                </div>
            </div>

            <?php
            // Fetch attendance data for the selected date with employee names
            $attendance_query = "
                SELECT 
                    pegawai.id AS id, 
                    pegawai.nama AS nama_pegawai, 
                    presensi_pegawai.presensi, 
                    presensi_pegawai.tanggal 
                FROM presensi_pegawai
                JOIN pegawai ON presensi_pegawai.id_pegawai = pegawai.id
                WHERE presensi_pegawai.tanggal = '$tanggal_hari_ini'
            ";
            $attendance_result = mysqli_query($koneksi, $attendance_query);
            ?>

            <!-- Table for today's attendance -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Presensi Hari Ini</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pegawai</th>
                                <th>Presensi</th>
                                <th>Tanggal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($attendance = mysqli_fetch_assoc($attendance_result)) : ?>
                                <tr>
                                    <td><?= $attendance['id'] ?></td>
                                    <td><?= $attendance['nama_pegawai'] ?></td>
                                    <td><?= $attendance['presensi'] ?></td>
                                    <td><?= $attendance['tanggal'] ?></td>
                                    <td>
                                        <a href="edit-presensi.php?id=<?= $attendance['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete_id=<?= $attendance['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Table for employee attendance counts -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Data Pegawai dan Presensi</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Hadir</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th>Alpha</th>
                                <th>Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($attendance_counts = mysqli_fetch_assoc($attendance_counts_result)) : ?>
                                <tr>
                                    <td><?= $attendance_counts['id'] ?></td>
                                    <td><?= $attendance_counts['nama'] ?></td>
                                    <td><?= $attendance_counts['nip'] ?></td>
                                    <td><?= $attendance_counts['hadir'] ?></td>
                                    <td><?= $attendance_counts['izin'] ?></td>
                                    <td><?= $attendance_counts['sakit'] ?></td>
                                    <td><?= $attendance_counts['alpha'] ?></td>
                                    <td><?= $attendance_counts['point'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('templates/footer.php'); ?>