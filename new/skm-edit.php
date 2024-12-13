<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); //memanggil file koneksi

$id = $_GET['id'];

// Fetch existing data based on the ID
$query = "SELECT * FROM skm WHERE id = '$id'";
$result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_skm = $_POST['no_skm'];
    $id_user = $_POST['id_user'];
    $jk = $_POST['jk'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    $pekerjaan = $_POST['pekerjaan'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $warga = $_POST['warga'];
    $keperluan = $_POST['keperluan'];
    $status = $_POST['status'];
    $file = $_POST['file'];

    $query = "UPDATE skm SET no_skm='$no_skm', id_user='$id_user', jk='$jk', tgl_lahir='$tgl_lahir', agama='$agama', pekerjaan='$pekerjaan', nik='$nik', alamat='$alamat', warga='$warga', keperluan='$keperluan', status='$status', file='$file' WHERE id='$id'";

    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    if ($result) {
        echo "<script>alert('Data berhasil diubah.');window.location='skm-index.php';</script>";
    } else {
        echo "<script>alert('Data gagal diubah.');window.location='skm-edit.php?id=$id';</script>";
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Surat Keterangan Tidak Mampu</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Data</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="no_skm">No SKTM</label>
                        <input type="text" class="form-control" id="no_skm" name="no_skm" value="<?= $data['no_skm']; ?>" required>
                    </div>
                    <?php if ($_SESSION['level'] == 'admin'||$_SESSION['level'] == 'pimpinan') { ?>
                        <div class="form-group">
                            <label>Nama</label>
                            <select class="form-control" name="id_user" required="">
                                <option value="">Pilih</option>
                                <?php
                                $users = mysqli_query($koneksi, "SELECT * FROM users") or die(mysqli_error($koneksi));
                                while ($user = mysqli_fetch_assoc($users)) {
                                ?>
                                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $data['id_user'] ? 'selected' : '' ?>><?= $user['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="id_user" value="<?= $_SESSION['user_id']; ?>">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" value="<?= $_SESSION['nama']; ?>" readonly>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <select class="form-control" id="jk" name="jk" required>
                            <option value="Laki-Laki" <?= $data['jk'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                            <option value="Perempuan" <?= $data['jk'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tempat/Tgl.lahir</label>
                        <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= $data['tgl_lahir']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="Islam" <?= $data['agama'] == 'Islam' ? 'selected' : '' ?>>Islam</option>
                            <option value="Kristen" <?= $data['agama'] == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                            <option value="Katolik" <?= $data['agama'] == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                            <option value="Hindu" <?= $data['agama'] == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                            <option value="Buddha" <?= $data['agama'] == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                            <option value="Konghucu" <?= $data['agama'] == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= $data['pekerjaan']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?= $data['nik']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required><?= $data['alamat']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="warga">Warga</label>
                        <select class="form-control" id="warga" name="warga" required>
                            <option value="WNI" <?= $data['warga'] == 'WNI' ? 'selected' : '' ?>>WNI</option>
                            <option value="WNA" <?= $data['warga'] == 'WNA' ? 'selected' : '' ?>>WNA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keperluan">Keperluan</label>
                        <textarea class="form-control" id="keperluan" name="keperluan" required><?= $data['keperluan']; ?></textarea>
                    </div>
                    <?php if ($_SESSION['level'] == 'pimpinan') {?>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Menunggu" <?= $data['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                <option value="Disetujui" <?= $data['status'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                <option value="Ditolak" <?= $data['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="file">file</label>
                        <input type="file" class="form-control" id="file" name="file" value="<?= $data['nik']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('templates/footer.php');
?>