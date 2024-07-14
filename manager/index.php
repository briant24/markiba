<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['is_admin'])) {
    header("Location: /markiba/auth/login.php"); // Redirect to the login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Markiba</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/Markiba.png" />
  <?php
  include '../koneksi.php';
  $selected_month = isset($_GET['month']) ? intval($_GET['month']) : null;
  $query = "SELECT DATE(waktu) AS tanggal, COUNT(*) AS jumlah_pengunjung FROM pengunjung";
  if ($selected_month) {
      $query .= " WHERE MONTH(waktu) = $selected_month";
  }
  $query .= " GROUP BY DATE(waktu)";
  // Execute the query
  $result = $conn->query($query);

  $data = array();
  while ($row = $result->fetch_assoc()) {
      $data[] = $row;
  }
  $totalPengunjung = 0;
  foreach ($data as $item) {
    $totalPengunjung += $item['jumlah_pengunjung'];
  }

  // Mengubah data menjadi format JSON
  $data_json = json_encode($data);

  // Menutup koneksi ke database
  $conn->close();
  ?>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php"><img src="images/Markiba.png" alt="logo" style="width: 50px; height: 50px; margin-right:20px"/><span class="text-primary" style="font-weight: bold">MARKIBA<span></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="images/Markiba.png" alt="logo" style="width: 50px; height: 50px; margin-left: 20px"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown" style="display: flex; align-items: center;">
              <i class="mdi mdi-account-circle" style="font-size: 18pt; margin-right: 8px; color: #B66DFF"></i>
              <span style="color: #B66DFF"><?php echo $_SESSION['nama']; ?></span>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
    <?php
      $active_page = 'index';
    ?>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
        $(function() {
          $("#includeHtml").load("pages/layout/sidebar.html");
        });
    </script>
    <div id="includeHtml"></div>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Dashboard
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>
          <?php
                          // Ambil parameter status dan pesan dari URL
                          $status = isset($_GET['status']) ? $_GET['status'] : '';
                          $message = isset($_GET['message']) ? $_GET['message'] : '';

                          // Tampilkan alert berdasarkan status
                          if ($status === 'success') {
                              echo "<script>alert('$message')</script>";
                          } elseif ($status === 'error') {
                              echo "<script>alert('Terjadi kesalahan: $message')</script>";
                          }
                        ?>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <h4 class="card-title">Grafik Pengunjung</h4>
                    <div style="text-align: center;">
                      <label for="monthSelect">Pilih Bulan:</label>
                        <select id="monthSelect">
                          <option value="">Semua Bulan</option>
                          <?php
                            $months = [
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ];
                            foreach ($months as $monthNumber => $monthName) {
                                $selected = ($selected_month == $monthNumber) ? 'selected' : '';
                                echo "<option value='$monthNumber' $selected>$monthName</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  <div style="width: 800px; margin: 0 auto;">
                      <canvas id="grafik"></canvas>
                  </div>
                  <div style="text-align: center; margin-top: 20px;">
                      <p><strong>Total Pengunjung</strong></p>
                      <div id="totalPengunjung"><?php echo $totalPengunjung ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2017 <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap Dash</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->

  <script>
        // Ambil data dari PHP dan konversi menjadi objek JavaScript
        var data_php = <?php echo $data_json; ?>;
        
        // Pisahkan tanggal dan jumlah_pengunjung dari objek data
        var tanggal = data_php.map(function(item) {
            return item.tanggal;
        });

        var jumlah_pengunjung = data_php.map(function(item) {
            return item.jumlah_pengunjung;
        });

        // Buat grafik menggunakan Chart.js
        var ctx = document.getElementById('grafik').getContext('2d');
        var grafik = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tanggal,
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: jumlah_pengunjung,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna isi batang
                    borderColor: 'rgba(54, 162, 235, 1)', // Warna garis batang
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        $(document).ready(function() {
            $('#monthSelect').change(function() {
                var selectedMonth = $(this).val();
                if (selectedMonth === '') {
                    // Jika memilih "Semua Bulan", redirect tanpa parameter bulan
                    window.location.href = window.location.pathname;
                } else {
                    // Redirect ke halaman yang sama dengan bulan yang dipilih sebagai parameter GET
                    window.location.href = window.location.pathname + '?month=' + selectedMonth;
                }
            });
        });
    </script>
</body>

</html>
