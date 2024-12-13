<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Include the database connection file

// Check if the ID is set
if (isset($_GET['id'])) {
    $id_tugas = $_GET['id'];

    // Fetch the current data of the tugas
    $query = "SELECT * FROM tugas WHERE id = '$id_tugas'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $id_pegawai = $row['id_pegawai'];
        $nama_pegawai = $row['nama_pegawai'];
        $tugas = $row['tugas'];
        $poin = $row['poin'];
        $bulan = $row['bulan']; // Get the current month value from the database
    } else {
        echo "<script>alert('Data tidak ditemukan.');window.location='tugas-index.php';</script>";
        exit;
    }
}

if (isset($_POST['update'])) {
    $id_tugas = $_POST['id_tugas'];
    $id_pegawai = $_POST['id_pegawai'];
    $tugas = $_POST['tugas'];
    $poin_baru = $_POST['poin'];
    $bulan = $_POST['bulan']; // Retrieve the value of 'bulan'

    // Fetch the original point value before the update
    $query = "SELECT poin FROM tugas WHERE id = '$id_tugas'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    $poin_lama = $row['poin'];

    // Calculate the difference between the new and old points
    $poin_selisih = $poin_baru - $poin_lama;

    // Get the nama_pegawai based on id_pegawai
    $pegawaiQuery = "SELECT nama FROM pegawai WHERE id = '$id_pegawai'";
    $pegawaiResult = mysqli_query($koneksi, $pegawaiQuery);
    $pegawaiRow = mysqli_fetch_assoc($pegawaiResult);
    $nama_pegawai = $pegawaiRow['nama'];

    // Update the tugas data in the database
    $updateQuery = "UPDATE tugas SET id_pegawai = '$id_pegawai', nama_pegawai = '$nama_pegawai', tugas = '$tugas', poin = '$poin_baru', bulan = '$bulan' WHERE id = '$id_tugas'";
    
    if (mysqli_query($koneksi, $updateQuery)) {
        // Update the total points in the pegawai table
        $updatePoinQuery = "UPDATE pegawai SET point = point + '$poin_selisih' WHERE id = '$id_pegawai'";
        mysqli_query($koneksi, $updatePoinQuery);

        echo "<script>alert('Data berhasil diperbarui.');window.location='tugas-index.php';</script>";
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($koneksi);
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit tugas</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit tugas</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <input type="hidden" name="id_tugas" value="<?php echo $id_tugas; ?>">
                    <div class="form-group">
                        <label for="id_pegawai">Nama Pegawai</label>
                        <select class="form-control" id="id_pegawai" name="id_pegawai" required>
                            <?php
                            // Fetch all employees from the pegawai table
                            $pegawaiQuery = "SELECT id, nama FROM pegawai";
                            $pegawaiResult = mysqli_query($koneksi, $pegawaiQuery);
                            while ($row = mysqli_fetch_assoc($pegawaiResult)) {
                                $selected = ($row['id'] == $id_pegawai) ? 'selected' : '';
                                echo "<option value='" . $row['id'] . "' $selected>" . $row['nama'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tugas">tugas</label>
                        <input type="text" class="form-control" id="tugas" name="tugas" value="<?php echo $tugas; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="poin">Point</label>
                        <input type="number" class="form-control" id="poin" name="poin" value="<?php echo $poin; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select class="form-control" id="bulan" name="bulan" required>
                            <option value="Januari" <?php if($bulan == 'Januari') echo 'selected'; ?>>Januari</option>
                            <option value="Februari" <?php if($bulan == 'Februari') echo 'selected'; ?>>Februari</option>
                            <option value="Maret" <?php if($bulan == 'Maret') echo 'selected'; ?>>Maret</option>
                            <option value="April" <?php if($bulan == 'April') echo 'selected'; ?>>April</option>
                            <option value="Mei" <?php if($bulan == 'Mei') echo 'selected'; ?>>Mei</option>
                            <option value="Juni" <?php if($bulan == 'Juni') echo 'selected'; ?>>Juni</option>
                            <option value="Juli" <?php if($bulan == 'Juli') echo 'selected'; ?>>Juli</option>
                            <option value="Agustus" <?php if($bulan == 'Agustus') echo 'selected'; ?>>Agustus</option>
                            <option value="September" <?php if($bulan == 'September') echo 'selected'; ?>>September</option>
                            <option value="Oktober" <?php if($bulan == 'Oktober') echo 'selected'; ?>>Oktober</option>
                            <option value="November" <?php if($bulan == 'November') echo 'selected'; ?>>November</option>
                            <option value="Desember" <?php if($bulan == 'Desember') echo 'selected'; ?>>Desember</option>
                        </select>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Perbarui Data</button>
                </form>
            </div>
        </div>
        <!-- /.card-body -->
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('templates/footer.php');
?>
