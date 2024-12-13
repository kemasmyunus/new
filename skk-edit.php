<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); //memanggil file koneksi

$id = $_GET['id'];

// Fetch existing data based on the ID
$query = "SELECT * FROM skk WHERE id = '$id'";
$result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_skk = $_POST['no_skk'];
    $id_user = $_POST['id_user'];
    $nama2 = $_POST['nama2'];
    $jk = $_POST['jk'];
    $jk2 = $_POST['jk2'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    $agama2 = $_POST['agama2'];
    $nik = $_POST['nik'];
    $nik2 = $_POST['nik2'];
    $alamat = $_POST['alamat'];
    $alamat2 = $_POST['alamat2'];
    $hubungan = $_POST['hubungan'];
    $status = $_POST['status'];
    $sebab = $_POST['sebab'];
    $hari = $_POST['hari'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $tempat = $_POST['tempat'];
    $file = $_POST['file'];

    $query = "UPDATE skk SET no_skk='$no_skk', id_user='$id_user', nama2='$nama2', jk='$jk', jk2='$jk2', tgl_lahir='$tgl_lahir',  agama='$agama', agama2='$agama2',  nik='$nik', alamat='$alamat',  nik2='$nik2', alamat2='$alamat2',  status='$status', sebab='$sebab', hari='$hari', tanggal='$tanggal',  waktu='$waktu',tempat='$tempat',file='$file' WHERE id='$id'";

    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    if ($result) {
        echo "<script>alert('Data berhasil diubah.');window.location='skk-index.php';</script>";
    } else {
        echo "<script>alert('Data gagal diubah.');window.location='skk-edit.php?id=$id';</script>";
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Surat Keterangan Kematian</h1>
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
                        <label for="no_skk">No SKK</label>
                        <input type="text" class="form-control" id="no_skk" name="no_skk" value="<?= $data['no_skk']; ?>" required>
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

                    <?php } ?>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?= $data['nik']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <select class="form-control" id="jk" name="jk" required>
                            <option value="Laki-Laki" <?= $data['jk'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                            <option value="Perempuan" <?= $data['jk'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
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
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required><?= $data['alamat']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nama2">Nama</label>
                        <input type="text" class="form-control" id="nama2" name="nama2" value="<?= $data['nama2']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nik2">NIK</label>
                        <input type="text" class="form-control" id="nik2" name="nik2" value="<?= $data['nik2']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jk2">Jenis Kelamin</label>
                        <select class="form-control" id="jk2" name="jk2" required>
                            <option value="Laki-Laki" <?= $data['jk2'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                            <option value="Perempuan" <?= $data['jk2'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tmp.&/Tgl.lahir</label>
                        <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= $data['tgl_lahir']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="agama2">Agama</label>
                        <select class="form-control" id="agama2" name="agama2" required>
                            <option value="Islam" <?= $data['agama2'] == 'Islam' ? 'selected' : '' ?>>Islam</option>
                            <option value="Kristen" <?= $data['agama2'] == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                            <option value="Katolik" <?= $data['agama2'] == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                            <option value="Hindu" <?= $data['agama2'] == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                            <option value="Buddha" <?= $data['agama2'] == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                            <option value="Konghucu" <?= $data['agama2'] == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="alamat2">Alamat</label>
                        <textarea class="form-control" id="alamat2" name="alamat2" required><?= $data['alamat2']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hubungan">Hubungan Dengan Alm/Almh</label>
                        <input type="text" class="form-control" id="hubungan" name="hubungan" value="<?= $data['hubungan']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="sebab">Sebab</label>
                        <input type="text" class="form-control" id="sebab" name="sebab" value="<?= $data['sebab']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hari">Hari</label>
                        <input type="text" class="form-control" id="hari" name="hari" value="<?= $data['hari']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $data['tanggal']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu">Waktu</label>
                        <input type="text" class="form-control" id="waktu" name="waktu" value="<?= $data['waktu']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tempat">Tempat</label>
                        <input type="text" class="form-control" id="tempat" name="tempat" value="<?= $data['tempat']; ?>" required>
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