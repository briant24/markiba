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
<style>
  /* Modal custom styles */
  .modal-dialog {
    max-width: 80%; /* Adjust the size of the modal */
  }
  .modal-content {
    border-radius: 0.5rem; /* Rounded corners for the modal */
  }
  .table {
    margin-bottom: 0; /* Remove bottom margin from the table */
  }
  .thead-dark th {
    background-color: #343a40; /* Dark background for the table header */
    color: white; /* White text color for the table header */
  }
  .table-bordered {
    border: 1px solid #dee2e6; /* Border color for the table */
  }
  .table-hover tbody tr:hover {
    background-color: #f1f1f1; /* Highlight row on hover */
  }
  .modal-header{
    display: block !important;
  }
</style>

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
                <li class="breadcrumb-item active" aria-current="page">Account Details</li>
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
                  <h4 class="card-title">Manager Details</h4>
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
                                <th>ID Manager</th>
                                <td><?php echo $row_admin['id_admin']; ?></td>
                              </tr>
                              <tr>
                                <th>Nama Manager</th>
                                <td><?php echo $row_admin['nama_admin']; ?></td>
                              </tr>
                              <tr>
                                <th>Username</th>
                                <td><?php echo $row_admin['username']; ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top:10px;">
                          <div>
                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#adminListModal">List Admin</a>
                          </div>
                          <div class="text-right">
                            <a href="edit_account.php" class="btn btn-success btn-sm">Edit Profile</a>
                            <a href="edit_password.php" class="btn btn-info btn-sm">Change Password</a>
                          </div>
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
  <!-- Modal -->
  <div class="modal fade" id="adminListModal" tabindex="-1" aria-labelledby="adminListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="adminListModalLabel">Daftar Admin</h5>
          
        </div>
        <div class="modal-body text-center">
          <div id="adminListContainer">
            
          </div>
        </div>
      </div>
    </div>
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
   <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  $(document).ready(function() {
    // Event listener for opening the modal
    $('#adminListModal').on('show.bs.modal', function (e) {
      // Perform AJAX request when the modal is shown
      $.ajax({
        url: 'get_admin_list.php', // URL to your server-side script
        method: 'GET',
        success: function(response) {
          $('#adminListContainer').html(response);
        },
        error: function() {
          $('#adminListContainer').html('Failed to load data.');
        }
      });
    });
  });
  </script>


  <!-- End custom js for this page-->
</body>

</html>
