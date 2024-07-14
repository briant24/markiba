<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect to the login page
    exit();
}

// Ambil ID buku yang akan diedit dari parameter URL
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Fetch data buku dari database berdasarkan ID
    include '../../../koneksi.php';
    $sql = "SELECT * FROM buku WHERE id_buku = $id_buku";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Error: " . mysqli_error($conn);
        exit();
    }
} 
else {
    // Redirect jika parameter ID tidak ditemukan
    header("Location: account.php");
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
      $active_page = 'buku';
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
              Edit Buku
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Data Buku</h4>
                        <p class="card-description">
                            Formulir untuk mengedit data buku
                        </p>
                        <form action="proses_edit_buku.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="judul_buku">Judul Buku</label>
                                <input type="text" class="form-control" id="judul_buku" name="judul_buku" placeholder="Judul Buku" required value="<?php echo $row['judul_buku']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="nama_penulis">Nama Penulis</label>
                                <input type="text" class="form-control" id="nama_penulis" name="nama_penulis" placeholder="Nama Penulis" required value="<?php echo $row['nama_penulis']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tahun_terbit">Tahun Terbit</label>
                                <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" placeholder="Tahun Terbit" required value="<?php echo $row['tahun_terbit']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="id_kategori">Kategori</label>
                                <select class="form-control" id="id_kategori" name="id_kategori" required>
                                    <?php
                                    include '../../../koneksi.php';
                                    // Ambil data kategori dari tabel kategori
                                    $sql_kategori = "SELECT id_kategori, nama_kategori FROM kategori";
                                    $result_kategori = mysqli_query($conn, $sql_kategori);

                                    // Tampilkan opsi kategori
                                    while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
                                        $selected = ($row_kategori['id_kategori'] == $row['id_kategori']) ? 'selected' : '';
                                        echo "<option value='" . $row_kategori['id_kategori'] . "' $selected>" . $row_kategori['nama_kategori'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar Buku</label>
                                <input type="file" name="gambar" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sinopsis">Sinopsis</label>
                                <textarea class="form-control" id="sinopsis" name="sinopsis" rows="4" required><?php echo $row['sinopsis']; ?></textarea>
                            </div>
                            <input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
                            <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                            <a href="buku.php" class="btn btn-light">Cancel</a>
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
