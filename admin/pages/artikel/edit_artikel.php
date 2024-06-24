<?php
session_start();

// Include your database connection file
include '../../../koneksi.php';

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect to the login page
    exit();
}

// Check if the article ID is provided in the URL
if (!isset($_GET['id_artikel'])) {
    header("Location: artikel.php?status=error&message=Article ID not provided");
    exit();
}

// Get the article ID from the URL
$id_artikel = $_GET['id_artikel'];

// Fetch article details from the database
$sql = "SELECT * FROM artikel WHERE id_artikel = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $id_artikel);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if the article exists
if ($row = mysqli_fetch_assoc($result)) {
    // Retrieve values for form fields
    $judul_artikel = $row['judul_artikel'];
    $sumber = $row['sumber'];
    $penulis = $row['penulis'];
    $tanggal = $row['tanggal'];
    $isi_artikel = $row['isi_artikel'];
    $gambar = $row['gambar'];

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Redirect with an error message if the article is not found
    header("Location: artikel.php?status=error&message=Article not found");
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
              <span style="color: #B66DFF"><?php echo $_SESSION['nama_admin']; ?></span>
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
      $active_page = 'artikel';
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
              Edit Artikel
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Artikel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Artikel</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Data Artikel</h4>
                        <p class="card-description">
                            Formulir untuk mengedit data artikel
                        </p>
                        <form action="proses_edit_artikel.php" method="post" enctype="multipart/form-data">
                            <!-- Add a hidden input field to store the article ID -->
                            <input type="hidden" name="id_artikel" value="<?php echo $id_artikel; ?>">

                            <!-- Your existing form fields go here with values populated from PHP variables -->
                            <div class="form-group">
                                <label for="judul_artikel">Judul Artikel</label>
                                <input type="text" class="form-control" id="judul_artikel" name="judul_artikel" value="<?php echo $judul_artikel; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="sumber">Sumber</label>
                                <input type="text" class="form-control" id="sumber" name="sumber" value="<?php echo $sumber; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="penulis">Penulis</label>
                                <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $penulis; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="isi_artikel">Isi Artikel</label>
                                <textarea class="form-control" id="isi_artikel" name="isi_artikel" rows="30" required><?php echo $isi_artikel; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar Artikel</label>
                                <input type="file" name="gambar" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                            <a href="artikel.php" class="btn btn-light">Cancel</a>
                        </form>
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
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/file-upload.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
