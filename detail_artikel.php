<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <title>Markiba</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-tale-seo-agency.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
  <!--

TemplateMo 582 Tale SEO Agency

https://templatemo.com/tm-582-tale-seo-agency

-->
  <link rel="shortcut icon" href="assets/images/Markiba.png" />
</head>
<?php
$activePage = 'artikel';
include 'header.php';
?>
<body>

  <!-- ***** Preloader Start ***** -->
  <!-- <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div> -->
  <!-- ***** Preloader End ***** -->
  <?php
if (isset($_GET['id_artikel'])) {
    // Get the value of id_artikel from the URL
    $id_artikel = $_GET['id_artikel'];

    include 'koneksi.php';
    // Query SQL to retrieve article details
    $sql = "SELECT id_artikel, judul_artikel, tanggal, penulis, isi_artikel, gambar
            FROM artikel
            WHERE id_artikel = $id_artikel";

    $result = mysqli_query($conn, $sql);

    // Check if there are results
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
    
      echo '<div class="happy-clients section">';
      echo '  <div class="container">';
      echo '    <div class="row">';
      echo '      <div class="col-lg-12">';
      echo '        <div class="section-heading mt-5">';
      echo '          <h2>' . $row['judul_artikel'] . '<em></em></h2>';
      echo '          <div class="line-dec"></div>';
      echo '          <h6>By ' . $row['penulis']. ' | ' . $row['tanggal'] . '</h6>';
      echo '        </div>';
      echo '      </div>';
      echo '      <div class="col-lg-12">';
      echo '        <div class="article-details">';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['gambar']) . '" alt="' . $row['judul_artikel'] . '" style="width: 100%; height: 600px; object-fit: cover; margin-bottom: 50px">';
        echo '<p style="color: black">' . nl2br($row['isi_artikel']) . '</p>';
    } else {
        echo "<p>No article found with the specified ID.</p>";
    }

    echo '        </div>';
    echo '      </div>';
    echo '    </div>';
    echo '  </div>';
    echo '</div>';
}
?>


  <footer>
    <div class="container mt-5" style="">
      <div class="col-lg-12">
        <p>Copyright © 2023 <a href="#">Markiba</a>
        </p>
      </div>
    </div>
  </footer>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>

</body>

</html>