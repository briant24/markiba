<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect to the login page
    exit();
}

$id_buku = isset($_GET['id_buku']) ? $_GET['id_buku'] : '';
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

  <!-- Custom CSS for star rating -->
  <style>
    .star-rating {
      direction: rtl;
      font-size: 2em;
    }
    .star-rating input[type="radio"] {
      display: none;
    }
    .star-rating label {
      color: #ddd;
      font-size: 2em;
      cursor: pointer;
    }
    .star-rating input[type="radio"]:checked ~ label {
      color: #f5c518;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label {
      color: #f5c518;
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
              Tambah Buku
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Ulasan Buku</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Ulasan Buku</h4>
                        <p class="card-description">
                            Formulir untuk menambah ulasan buku
                        </p>
                        <form action="proses_tambah_ulasan.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
                            <!-- New field for adding review -->
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="5 stars">☆</label>
                                    <input type="radio" id="star4" name="rating" value="4" required /><label for="star4" title="4 stars">☆</label>
                                    <input type="radio" id="star3" name="rating" value="3" required /><label for="star3" title="3 stars">☆</label>
                                    <input type="radio" id="star2" name="rating" value="2" required /><label for="star2" title="2 stars">☆</label>
                                    <input type="radio" id="star1" name="rating" value="1" required /><label for="star1" title="1 star">☆</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="isi_ulasan">Ulasan</label>
                                <textarea class="form-control" id="isi_ulasan" name="isi_ulasan" rows="30" placeholder="Tambah ulasan" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                            <a href="buku.php" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <!-- ... (your existing footer code) ... -->
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
