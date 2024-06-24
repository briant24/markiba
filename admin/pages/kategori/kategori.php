<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect to the login page
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
  <link rel="stylesheet" href="../../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../node_modules/jqvmap/dist/jqvmap.min.css" />
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/Markiba.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php"><img src="../../images/Markiba.png" alt="logo" style="width: 50px; height: 50px; margin-right:20px"/><span class="text-primary" style="font-weight: bold">MARKIBA<span></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../../images/Markiba.png" alt="logo" style="width: 50px; height: 50px; margin-left: 20px"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <i class="mdi mdi-account-circle"></i>
                <span class="availability-status online"></span>             
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black">Admin</p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-logout mr-2 text-primary"></i>
                Signout
              </a>
            </div>
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
      $active_page = 'kategori';
    ?>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
        $(function() {
          $("#includeHtml").load("../layout/sidebar.html");
        });
    </script>
    <div id="includeHtml"></div>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Kategori Buku
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kategori Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Kategori</li>
              </ol>
            </nav>
          </div>
          <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">Daftar Kategori Buku</h4>
                                <p class="card-description">Data kategori buku</p>
                            </div>
                            <div class="text-right">
                                <a href="tambah_kategori.php" class="btn btn-primary btn-sm">Tambah Kategori Buku</a>
                            </div>
                        </div>
                          <?php
                          include '../../../koneksi.php';

                          // Query SQL untuk menampilkan data kategori
                          $sql_kategori = "SELECT * FROM kategori";
                          $result_kategori = mysqli_query($conn, $sql_kategori);
                          ?>
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
                          <table class="table">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if ($result_kategori) {
                                $no = 0;
                                while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
                                  $no++;
                                  echo "<tr>";
                                  echo "<td>" . $no . "</td>";
                                  echo "<td>" . $row_kategori['nama_kategori'] . "</td>";
                                  echo "<td><img src='data:image/jpeg;base64," . base64_encode($row_kategori['gambar']) . "' alt='Gambar' style='width: 150px; height: 100px; border-radius: 0px'></td>";
                                  echo "<td>
                                      <a href='edit_kategori.php?id=" . $row_kategori['id_kategori'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                      <a href='proses_hapus_kategori.php?id=" . $row_kategori['id_kategori'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus?\")'>Hapus</a>
                                    </td>";
                                  echo "</tr>";
                                }
                              } else {
                                echo "Error: " . mysqli_error($conn);
                              }
                              ?>
                            </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
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
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
