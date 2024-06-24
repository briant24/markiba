<?php
session_start();
include '../../../koneksi.php';

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect to the login page
    exit();
}

// Fetch about us content from the database
$sql_about = "SELECT * FROM about";
$result_about = mysqli_query($conn, $sql_about);

if ($result_about && mysqli_num_rows($result_about) > 0) {
    $row_about = mysqli_fetch_assoc($result_about);
    $about_description = $row_about['deskripsi'];
} else {
    $about_description = "Deskripsi About Us belum tersedia.";
}

// Format content with line breaks, bold, and headers
$about_description = nl2br($about_description); // Convert newlines to <br>

// Bold text: *text*
$about_description = preg_replace('/\*([^\*]+)\*/', '<strong>$1</strong>', $about_description);

// Headers: ### Header
$about_description = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $about_description);
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

    <style>
    .card-description-box {
        border: 1px solid #ccc; /* Set your desired border properties */
        padding: 15px; /* Add padding for better appearance */
        margin-top: 15px; /* Add margin to separate from other elements */
    }

    .card-description {
        /* Add any additional styles for the content inside the box if needed */
    }
</style>
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
          <li class="nav-item active">
            <a class="nav-link" href="../about/about.php">
              <span class="menu-title">About Us</span>
              <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
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
                            About Us
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">About Us</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Kelola Konten About Us</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="card-title">Kelola Konten About Us</h4>
                                        <a href="edit_about.php" class="btn btn-primary btn-sm">Edit Konten</a>
                                    </div>
                                    <div class="card-description-box">
                                        <div class="card-description">
                                            <?php echo $about_description; ?>
                                        </div>
                                    </div>
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
