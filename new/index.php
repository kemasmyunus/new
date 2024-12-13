<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Ensure this is included to establish the database connection
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Admin Dashboard -->
  <?php if ($_SESSION['level'] == 'admin'||$_SESSION['level'] == 'pimpinan') { ?>
    <section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="card bg-gradient-success mb-3 text-center">
            <div class="card-header bg-white text-dark">
              <h4 class="text-center">Pegawai Terbaik</h4>
            </div>
            <div class="card-body text-white">
              <?php
              // Cast 'point' as an integer in the SQL query
              $query = "SELECT *, CAST(point AS SIGNED) AS int_point FROM pegawai ORDER BY int_point DESC LIMIT 1";
              if ($result = mysqli_query($koneksi, $query)) {
                $row = mysqli_fetch_assoc($result);
                $performance_category = $row['int_point'] >= 80 ? 'Kinerja Terbaik' : 'Kinerja Cukup Baik';
                echo "
                <i class='fas fa-trophy fa-4x mb-3'></i>
                <h1 class='display-4 mb-0'>{$row['nama']}</h1>
                <p class='lead'>NIP: {$row['nip']}</p>
                <p class='lead'>Jabatan: {$row['jabatan']}</p>
                <p class='lead'>Point: {$row['int_point']}</p>
                <h2 class='mb-0'>$performance_category</h2>";
              } else {
                echo "Error: " . mysqli_error($koneksi);
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Dashboard Cards for Admin -->
        <?php
        $cards = [
          'Surat Keterangan' => 'sk',
          'Surat Keterangan Berkelakuan Baik' => 'skbb',
          'Surat Keterangan Domisili' => 'skd',
          'Surat Keterangan Tidak Mampu' => 'skm',
          'Surat Keterangan Usaha' => 'sku',
          'Surat Keterangan Kematian' => 'skk',
          'Surat Keterangan Belum Menikah' => 'skbm',
          'Surat Keterangan Belum Memiliki Rumah' => 'skbmr'
        ];

        foreach ($cards as $title => $table) {
          $query = "SELECT COUNT(*) as count FROM $table";
          if ($result = mysqli_query($koneksi, $query)) {
            $row = mysqli_fetch_assoc($result);
            $count = $row['count'];
            echo "
            <div class='col-md-4'>
              <div class='card bg-gradient-primary mb-3 text-center'>
                <div class='card-header bg-white text-dark'>
                  <h4 class='text-center'>$title</h4>
                </div>
                <div class='card-body text-white'>
                  <i class='fas fa-envelope fa-4x mb-3'></i>
                  <h1 class='display-4 mb-0'>$count</h1>
                  <p class='lead'>Jumlah</p>
                </div>
              </div>
            </div>";
          } else {
            echo "Error: " . mysqli_error($koneksi);
          }
        }
        ?>
      </div>



      <!-- Best Performing Employee Section -->
     

    </section>
  <?php } ?>

  <!-- Customer Dashboard -->
  <?php if ($_SESSION['level'] == 'pelanggan') {
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
  ?>
    <section class="content">
      <div class="row">
        <!-- Dashboard Cards for Customer -->
        <?php
        $cards = [
          'Surat Keterangan' => 'sk',
          'Surat Keterangan Berkelakuan Baik' => 'skbb',
          'Surat Keterangan Domisili' => 'skd',
          'Surat Keterangan Tidak Mampu' => 'skm',
          'Surat Keterangan Usaha' => 'sku',
          'Surat Keterangan Kematian' => 'skk',
          'Surat Keterangan Belum Menikah' => 'skbm',
          'Surat Keterangan Belum Memiliki Rumah' => 'skbmr'
        ];

        foreach ($cards as $title => $table) {
          $query = "SELECT COUNT(*) as count FROM $table WHERE id_user = '$user_id'";
          if ($result = mysqli_query($koneksi, $query)) {
            $row = mysqli_fetch_assoc($result);
            $count = $row['count'];
            echo "
            <div class='col-md-4'>
              <div class='card bg-gradient-primary mb-3 text-center'>
                <div class='card-header bg-white text-dark'>
                  <h4 class='text-center'>$title</h4>
                </div>
                <div class='card-body text-white'>
                  <i class='fas fa-envelope fa-4x mb-3'></i>
                  <h1 class='display-4 mb-0'>$count</h1>
                  <p class='lead'>Jumlah</p>
                </div>
              </div>
            </div>";
          } else {
            echo "Error: " . mysqli_error($koneksi);
          }
        }
        ?>
      </div>
    </section>
  <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
include('templates/footer.php');
?>

<style>
  /* Enhanced styles.css */
  .card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  }

  .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 10px 20px;
  }

  .card-body {
    padding: 20px;
  }

  .list-group-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    border: none;
    background-color: #f8f9fa;
    margin-bottom: 10px;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .list-group-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .badge {
    background: linear-gradient(45deg, #1e90ff, #00bfff);
  }

  .item-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 15px;
  }

  .content-header h1,
  .content .card h2 {
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
  }

  .fa-envelope {
    margin-bottom: 10px;
  }
</style>