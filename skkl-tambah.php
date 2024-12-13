<?php
include('koneksi.php'); // Include connection file
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Function to generate the next no_skkl
function generate_no_skkl($koneksi) {
    // Query to get the last no_skkl from the database
    $query = "SELECT no_skkl FROM skkl ORDER BY no_skkl DESC LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $last_no_skkl = $row['no_skkl'];
        
        // Get the number part and increment it
        $new_no = (int)$last_no_skkl + 1;
        return $new_no;
    } else {
        // If no records, start from 1
        return 1;
    }
}

// Get the next no_skkl
$no_skkl = generate_no_skkl($koneksi);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $nama_anak = $_POST['nama_anak'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $status = $_POST['status'];

    // Query to insert the new data into the database
    $query = "INSERT INTO skkl (no_skkl, id_user, tgl_lahir, nama_anak, jenis_kelamin, status) VALUES ('$no_skkl', '$id_user', '$tgl_lahir', '$nama_anak', '$jenis_kelamin', '$status')";
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    if ($result) {
        echo "<script>alert('Data berhasil ditambahkan.');window.location='skkl-index.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan.');</script>";
    }
}

include('templates/header.php');
include('templates/sidebar.php');
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Surat Keterangan Kelahiran</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Surat Keterangan Kelahiran</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="no_skkl">No SKKL</label>
                        <!-- No SKKL is auto-generated -->
                        <input type="text" class="form-control" id="no_skkl" name="no_skkl" value="<?= $no_skkl; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <select class="form-control" name="id_user" required>
                            <option value="">Pilih</option>
                            <?php
                            $users = mysqli_query($koneksi, "SELECT * FROM users") or die(mysqli_error($koneksi));
                            while ($user = mysqli_fetch_assoc($users)) {
                            ?>
                                <option value="<?= $user['id'] ?>"><?= $user['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_anak">Nama Anak</label>
                        <input type="text" class="form-control" id="nama_anak" name="nama_anak" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include('templates/footer.php'); ?>
