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
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../../index.php">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../buku/buku.php">
              <span class="menu-title">Buku</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="kategori.php">
              <span class="menu-title">Kategori Buku</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../artikel/artikel.php">
              <span class="menu-title">Artikel</span>
              <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../about/about.php">
              <span class="menu-title">About Us</span>
              <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="../account/account.php">
              <span class="menu-title">Account</span>
              <i class="mdi mdi-table-large menu-icon"></i>
            </a>
          </li>
          <li class="nav-item sidebar-actions">
            <span class="nav-link">
              <a class="btn btn-block btn-lg btn-gradient-primary mt-1" href="../auth/process_logout.php">Logout</a>
            </span>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Account Information
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Admin Details</li>
              </ol>
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
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Admin Details</h4>
                  <?php
                    include '../../../koneksi.php';

                    // Retrieve admin details from the database
                    $username = $_SESSION['username'];
                    $sql_admin = "SELECT * FROM admin WHERE username = '$username'";
                    $result_admin = mysqli_query($conn, $sql_admin);

                    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
                        $row_admin = mysqli_fetch_assoc($result_admin);
                        ?>
                        <div class="table-responsive">
                          <table class="table">
                            <tbody>
                              <tr>
                                <th>ID Admin</th>
                                <td><?php echo $row_admin['id_admin']; ?></td>
                              </tr>
                              <tr>
                                <th>Nama Admin</th>
                                <td><?php echo $row_admin['nama_admin']; ?></td>
                              </tr>
                              <tr>
                                <th>Username</th>
                                <td><?php echo $row_admin['username']; ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="text-right">
                          <a href="edit_account.php" class="btn btn-success btn-sm">Edit Profile</a>
                          <a href="edit_password.php" class="btn btn-info btn-sm">Change Password</a>
                        </div>
                        <?php
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
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
