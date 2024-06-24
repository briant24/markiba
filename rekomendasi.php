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
    .review-box {
      border: 1px solid #ddd;
      border-radius: 10px;
      margin-bottom: 20px;
      overflow: hidden;
    }

    .review-box img {
      max-width: 100%;
      height: auto;
      object-fit: cover;
    }

    .review-content {
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
      color: #5701E3;
    }

    span {
        font-size: 24px; /* Sesuaikan ukuran font sesuai kebutuhan */
    }

    span[style*="color: transparent"] {
        display: inline-block;
        width: 2em;
        overflow: hidden;
    }
  </style>
</head>

<?php
$activePage = 'rekomendasi';
include 'header.php';
?>

<body>
  <div class="happy-clients section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading mt-4">
            <h2>Rekomendasi Buku <em></em></h2>
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

        // Query SQL to retrieve book reviews from the database
        $sql = "SELECT buku.id_buku, buku.judul_buku, buku.nama_penulis, buku.gambar, ulasan.rating
        FROM buku
        LEFT JOIN ulasan ON buku.id_buku = ulasan.id_buku WHERE ulasan.rating = 5
        LIMIT $start_from, $results_per_page";
        $result = mysqli_query($conn, $sql);
        
        // Check if there are results
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-lg-4">';
            echo '<div class="review-box">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['gambar']) . '" alt="' . $row['judul_buku'] . '" style="width: 100%; height: 600px; object-fit: cover;">';
            
            // Menampilkan nilai rating dan bintangnya
            echo '<div class="row">';
            echo '<div class="col-lg-7">';
            echo '<h4 class="mt-4 mx-3">';
            echo '<a style="color: #000; text-decoration: none;" href="detail_ulasan.php?id_buku=' . $row['id_buku'] . '">';
            echo $row['judul_buku'];
            echo '</a>';
            echo '</h4>';
            
            
            echo '<p class="mx-3 mb-4 mt-1" style="color: #000000">Penulis: ' . $row['nama_penulis'] . '</p>';
            echo '</div>';

            echo '<div class="col-lg-5 text-end">';
            // Menampilkan nilai rating dan bintangnya
            echo '<p class="mx-3 pt-4" style="color: #000000">Rating: ' . $row['rating'] . ' / 5</p>';
            echo '<div class="mx-3 mt-0 pt-0" style="">';
            // Menampilkan bintang berdasarkan nilai rating
            for ($i = 1; $i <= 5; $i++) {
                echo ($i <= $row['rating']) ? '<span style="color: #FFD700;">★</span>' : '<span>☆</span>';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }      

          // Pagination links
          $sql = "SELECT COUNT(buku.id_buku) AS total
          FROM buku
          LEFT JOIN ulasan ON buku.id_buku = ulasan.id_buku
          WHERE ulasan.rating = 5";
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
          echo 'No book reviews found.';
          echo '</div>';
        }
        ?>
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
