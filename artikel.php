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
  <style>
    .article-box {
        border: 1px solid #ddd;
        border-radius: 10px;
        /* padding: 15px; */
        margin-bottom: 20px;
        overflow: hidden;
    }

    .article-box img {
        max-width: 100%;
        height: auto;
    }

    .articel-text {
        padding: 15px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        padding: 10px;
        margin: 0 5px;
        border: 1px solid #ddd;
        text-decoration: none;
        color: #333;
        transition: background-color 0.3s;
    }

    .pagination a:hover {
        background-color: #f4f4f4;
    }

    .pagination .active {
        background-color: #4CAF50;
        color: white;
    }

    a:hover {
        color: #5701E3; /* Change to the desired hover color */
    }
  </style>
  
</head>
<?php
$activePage = 'artikel';
include 'header.php';
?>
<body>
  <div class="happy-clients section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading mt-4">
            <h2>Artikel <em></em></h2>
            <div class="line-dec"></div>
          </div>
        </div>

        <?php
        include 'koneksi.php';

        // Pagination setup
        $results_per_page = 6;
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $start_from = ($page - 1) * $results_per_page;

        // Query SQL to retrieve articles from the database
        $sql = "SELECT id_artikel, judul_artikel, tanggal, penulis, gambar FROM artikel LIMIT $start_from, $results_per_page";
        $result = mysqli_query($conn, $sql);

        // Check if there are results
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-lg-4">';
                echo '<div class="article-box">';
                
                // Outputting the BLOB image
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['gambar']) . '" alt="' . $row['judul_artikel'] . '" style="width: 100%; height: 300px; object-fit: cover;">';
                
                echo '<h4 class="mt-4 mx-3"><a style="color: #000; text-decoration: none;" href="detail_artikel.php?id_artikel=' . $row['id_artikel'] . '">' . $row['judul_artikel'] . '</a></h4>';
                echo '<p class="mx-3" style="color: #000000">Tanggal: ' . $row['tanggal'] . '</p>';
                echo '<p class="mx-3 mb-4" style="color: #000000">Penulis: ' . $row['penulis'] . '</p>';
                // You can add more information as needed

                echo '</div>';
                echo '</div>';
            }

            // Pagination links
            $sql = "SELECT COUNT(id_artikel) AS total FROM artikel";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $total_pages = ceil($row["total"] / $results_per_page);

            echo '<div class="col-lg-12">';
            echo '<div class="pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a class="' . ($i == $page ? 'active' : '') . '" href="?page=' . $i . '">' . $i . '</a>';
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="col-lg-12">';
            echo 'No articles found.';
            echo '</div>';
        }
        ?>
      </div>
    </div>
  </div>

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