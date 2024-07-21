<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <title>Markiba</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-tale-seo-agency.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
  <link rel="shortcut icon" href="assets/images/Markiba.png" />
  <style>
    .star-rating {
        direction: rtl; /* Right-to-left to show stars from right to left */
        display: table;
        font-size: 1.5em;
        margin-top: -10px;
    }
    .star-rating input[type="radio"] {
        display: none; /* Hide the actual radio buttons */
    }
    .star-rating label {
        color: #ddd; /* Default color of stars */
        font-size: 2em;
        cursor: pointer;
    }
    .star-rating input[type="radio"]:checked ~ label {
        color: #f5c518; /* Color of stars when checked */
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #f5c518; /* Color of stars on hover */
    }
</style>

</head>
<?php
$activePage = 'ulasan';
include 'header.php';
if (!isset($_SESSION['username'])) {
  header("Location: auth/login.php"); // Redirect to the login page
  exit();
}
$id_buku = $_GET['id_buku'];
?>
<body>
<div class="row">
<div class="happy-clients section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading mt-4">
            <h2>Ulasan Buku<em></em></h2>
            <div class="line-dec"></div>
          </div>
        </div>
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
                            <select class="form-control" id="isi_ulasan" name="isi_ulasan">
                            <?php
                            $ulasan_options = [
                                "Buku yang sangat inspiratif dan menggugah.",
                                "Ceritanya menarik dan alurnya bagus.",
                                "Bahasanya mudah dipahami dan sangat informatif.",
                                "Buku yang sangat membantu untuk memahami topik ini.",
                                "Sangat direkomendasikan untuk dibaca."
                            ];

                            foreach ($ulasan_options as $ulasan) {
                                echo "<option value=\"$ulasan\">$ulasan</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div>
                            <br>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="detail_ulasan.php?id_buku=<?php echo $id_buku ?>" class="btn btn-warning">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
  <footer>
    <div class="container mt-5" style="">
      <div class="col-lg-12">
        <p>Copyright © 2023 <a href="#">Markiba</a></p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>

</body>

</html>
