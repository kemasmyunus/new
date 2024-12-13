<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #242423 !important;">
  <a href="#" class="brand-link">
    <img src="assets/img/logo-desa.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8; width: 30px; height: 50px;">
    <span class="brand-text font-weight-bold" style="font-size: 19px; color: #ffffff; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">Kelurahan Surgi Mufti</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <?php if ($_SESSION['level'] == 'pelanggan') { ?>
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block ">Selamat Datang</a>
          <small style="color: #d6a92d;"><?= $_SESSION['nama']; ?></small>
        </div>
      </div>
    <?php } ?>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="index.php" class="nav-link ">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <?php if ($_SESSION['level'] == 'pimpinan') { ?>
          <li class="nav-item">
            <a href="tanda-tangan.php" class="nav-link">
              <i class="nav-icon fas fa-pen-nib"></i>
              <p>Tanda Tangan</p>
            </a>
          </li>
        <?php } ?>
        <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pimpinan') {?>
          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-folder"></i>
              <p>Data Master<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="profil-desa-index.php" class="nav-link ">
                  <i class="far fa-folder nav-icon"></i>
                  <p>Profil Desa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="jabatan-desa-index.php" class="nav-link ">
                  <i class="far fa-folder nav-icon"></i>
                  <p>Jabatan Desa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pegawai-index.php" class="nav-link ">
                  <i class="far fa-folder nav-icon"></i>
                  <p>Pegawai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="tugas-index.php" class="nav-link ">
                  <i class="far fa-folder nav-icon"></i>
                  <p>Tugas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="presensi-index.php" class="nav-link ">
                  <i class="far fa-folder nav-icon"></i>
                  <p>Presensi</p>
                </a>
              </li>
            </ul>
          </li>
        <?php } ?>
        <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pimpinan') {?>
          <li class="nav-item">
            <a href="penduduk-index.php" class="nav-link ">
              <i class="nav-icon fas fa-file"></i>
              <p>Data Penduduk</p>
            </a>
          </li>
        <?php } ?>
        <?php if ($_SESSION['level'] == 'pelanggan') { ?>
          <!-- Profil Menu -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Profil<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="profil-edit.php" class="nav-link">
                  <i class="far fa-edit nav-icon"></i>
                  <p>Edit Profil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="profil-delete.php" class="nav-link" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                  <i class="far fa-trash-alt nav-icon"></i>
                  <p>Hapus Akun</p>
                </a>
              </li>
            </ul>
          </li>
        <?php } ?>
        <?php if (($_SESSION['level'] == 'admin') || ($_SESSION['level'] == 'pelanggan')|| ($_SESSION['level'] == 'pimpinan')) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-folder"></i>
              <p>Surat <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="sk-index.php" class="nav-link ">
                  <i class="fa fa-envelope nav-icon"></i>
                  <p>Keterangan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="skkl-index.php" class="nav-link ">
                  <i class="fa fa-envelope nav-icon"></i>
                  <p>Keterangan Kelahiran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="skbb-index.php" class="nav-link ">
                  <i class="fa fa-envelope nav-icon"></i>
                  <p>Keterangan Berkelakuan Baik</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="skd-index.php" class="nav-link ">
                  <i class="fa fa-envelope nav-icon"></i>
                  <p>Keterangan Domisili</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="skm-index.php" class="nav-link ">
                  <i class="fa fa-envelope nav-icon"></i>
                  <p>Keterangan Tidak Mampu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sku-index.php" class="nav-link ">
                  <i class="fa fa-envelope nav-icon"></i>
                  <p>Keterangan Usaha</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="skk-index.php" class="nav-link ">
                  <i class="fa fa-envelope nav-icon"></i>
                  <p>Keterangan Kematian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="skbm-index.php" class="nav-link ">
                  <i class="fa fa-envelope nav-icon"></i>
                  <p>Keterangan Belum Menikah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="skbmr-index.php" class="nav-link ">
                  <i class="fa fa-envelope nav-icon"></i>
                  <p>Keterangan Belum Memiliki Rumah</p>
                </a>
              </li>
            </ul>
          </li>
        <?php } ?>


        <?php if ($_SESSION['level'] == 'admin'||$_SESSION['level'] == 'pimpinan') { ?>
          <li class="nav-item">
            <a href="laporan-index.php" class="nav-link ">
              <i class="nav-icon fas fa-file"></i>
              <p>Laporan</p>
            </a>
          </li>
        <?php } ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<style>
  .main-sidebar {
    background-color: #fafa23 !important;
    /* Sidebar background color */
  }

  .nav-link {
    color: #000000;
    /* Default text color for links */
  }

  .nav-link.active {
    background-color: #d6a92d;
    /* Background color when active */
    color: #000000;
    /* Text color when active */
  }

  .nav-link:hover {
    background-color: #d6a92d;
    /* Background color on hover */
    color: #000000;
    /* Text color on hover */
  }

  .brand-text {
    color: #121111;
    /* Text color for the brand name */
  }

  /* Custom Styles */
  .nav-link.active {
    background-color: #d6a92d;
    /* Darker background color when active */
    color: #f0f0f0;
    /* Lighter text color when active */
  }

  .nav-link:hover {
    background-color: #d6a92d;
    /* Darker background color on hover */
    color: #f0f0f0;
    /* Lighter text color on hover */
  }

  .nav-link {
    color: #000000;
    /* Default text color for links */
    font-size: 12px;
    /* Menurunkan ukuran font pada link */
  }

  .nav-link.active {
    background-color: #d6a92d;
    /* Background color when active */
    color: #f0f0f0;
    /* Text color when active */
    font-size: 15px;
    /* Ukuran font saat aktif */
  }
</style>