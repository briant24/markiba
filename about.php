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
$activePage = 'about';
include 'header.php';
?>
<body>
  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 align-self-center">
          <div class="caption  header-text">
            <h6>MARKIBA</h6>
            <div class="line-dec"></div>
            <h4>Discover More <em>About Us</em></h4>
            <p>Dengan markiba, kita dapat mengeksplorasi dunia baru melalui buku.</p>
          </div>
        </div>
        <div class="col-lg-5 align-self-center">
          <img src="assets/images/book.jpg" alt="">
        </div>
      </div>
    </div>
  </div>

  <div class="video-info section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 align-self-center">
                <div class="section-heading">
                    <!-- <h2>Detailed Information On What We Do</h2>
                    <div class="line-dec"></div> -->

                    <?php
                    // Assuming you have a database connection
                    include 'koneksi.php';

                    // Fetch content from the 'about' table
                    $sql = "SELECT * FROM about";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are results
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $about_description = $row['deskripsi'];

                        // Format content with line breaks, bold, and headers
                        $about_description = nl2br($about_description); // Convert newlines to <br>
                        $about_description = preg_replace('/\*([^\*]+)\*/', '<strong>$1</strong>', $about_description);
                        $about_description = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $about_description);

                        // Display the processed content
                        echo '<div style="color: white">' . $about_description . '</div>';
                    } else {
                        echo "No content found.";
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>

                </div>
            </div>
        </div>
    </div>
  </div>

  <footer>
    <div class="container">
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