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
      $active_page = 'account';
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
