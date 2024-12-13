<?php
include('koneksi.php'); // Include connection file

$id = $_GET['id'];
$query = "SELECT * FROM skkl WHERE id = '$id'";
$result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_skkl = $_POST['no_skkl'];
    $id_user = $_POST['id_user'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $nama_anak = $_POST['nama_anak'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $status = $_POST['status'];

    $query = "UPDATE skkl SET no_skkl='$no_skkl', id_user='$id_user', tgl_lahir='$tgl_lahir', nama_anak='$nama_anak', jenis_kelamin='$jenis_kelamin', status='$status' WHERE id='$id'";
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    if ($result) {
        echo "<script>alert('Data berhasil diubah.');window.location='skkl-index.php';</script>";
    } else {
        echo "<script>alert('Data gagal diubah.');window.location='skkl-edit.php?id=$id';</script>";
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
                    <h1>Edit Surat Keterangan Kelahiran</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Surat Keterangan Kelahiran</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="no_skkl">No SKKL</label>
                        <input type="text" class="form-control" id="no_skkl" name="no_skkl" value="<?= $data['no_skkl']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <select class="form-control" name="id_user" required>
                            <option value="">Pilih</option>
                            <?php
                            $users = mysqli_query($koneksi, "SELECT * FROM users") or die(mysqli_error($koneksi));
                            while ($user = mysqli_fetch_assoc($users)) {
                            ?>
                                <option value="<?= $user['id'] ?>" <?= $user['id'] == $data['id_user'] ? 'selected' : '' ?>><?= $user['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= $data['tgl_lahir']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_anak">Nama Anak</label>
                        <input type="text" class="form-control" id="nama_anak" name="nama_anak" value="<?= $data['nama_anak']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-Laki" <?= $data['jenis_kelamin'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                            <option value="Perempuan" <?= $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Menunggu" <?= $data['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                            <option value="Disetujui" <?= $data['status'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                            <option value="Ditolak" <?= $data['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include('templates/footer.php'); ?>
