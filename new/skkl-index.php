<?php
include('koneksi.php'); // Include connection file

$query = "SELECT skkl.id, skkl.no_skkl, users.nama, skkl.tgl_lahir, skkl.nama_anak, skkl.jenis_kelamin, skkl.status FROM skkl JOIN users ON skkl.id_user = users.id ORDER BY skkl.id DESC";
$result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

include('templates/header.php');
include('templates/sidebar.php');
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Surat Keterangan Kelahiran (SKKL)</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Surat Keterangan Kelahiran</h3>
                <a href="skkl-tambah.php" class="btn btn-primary btn-sm float-right">Tambah Surat Kelahiran</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No SKKL</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Nama Anak</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $row['no_skkl']; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['tgl_lahir']; ?></td>
                            <td><?= $row['nama_anak']; ?></td>
                            <td><?= $row['jenis_kelamin']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td>
                                <a href="surat-skkl.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm" target="_blank">Cetak</a>
                                <a href="skkl-edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <!-- Delete button -->
                                <a href="skkl-hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php include('templates/footer.php'); ?>
