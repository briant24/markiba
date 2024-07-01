<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <title>Markiba</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-tale-seo-agency.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
  <link rel="shortcut icon" href="assets/images/Markiba.png" />
  <style>
    .category-list {
      list-style: none;
      padding: 0;
    }

    .category-item {
      display: inline-block;
      margin-right: 10px;
      cursor: pointer;
    }

    .category-item:hover {
      text-decoration: underline;
    }

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
  </style>
</head>
<?php
$activePage = 'ulasan';
include 'header.php';
?>
<body>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script>
    // JavaScript for category filter
    $(document).ready(function () {
      $(".category-item").click(function () {
        var selectedCategory = $(this).data("category");

        // Redirect to the current page with the selected category as a parameter
        window.location.href = "?category=" + selectedCategory;
      });
    });
  </script>

  <div class="happy-clients section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading mt-4">
            <h2>Ulasan Buku</h2>
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
        $id_kategori = $_GET['id_kategori'];
        
        // Query SQL to retrieve unique book reviews from the database with category and id_kategori filters
        $sql = "SELECT DISTINCT buku.id_buku, buku.judul_buku, buku.nama_penulis, buku.gambar, AVG(ulasan.rating) AS rating_rata
        FROM buku
        INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori
        LEFT JOIN ulasan ON buku.id_buku = ulasan.id_buku
        WHERE buku.id_kategori = '$id_kategori'
        GROUP BY buku.id_buku
        LIMIT $start_from, $results_per_page";

        $result = mysqli_query($conn, $sql);

        // Check if there are results
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-lg-4">';
            echo '<div class="review-box">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['gambar']) . '" alt="' . $row['judul_buku'] . '" style="width: 100%; height: 600px; object-fit: cover;">';
            
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
            if ($row['rating_rata'] !== null) {
              echo '<p class="mx-3 pt-4" style="color: #000000">Rating: ' . number_format($row['rating_rata'], 1) . ' / 5</p>';
              echo '<div class="mx-3 mt-0 pt-0" style="">';
              
              // Menampilkan bintang berdasarkan nilai rating rata-rata
              $average_rating = round($row['rating_rata']); // Bulatkan rating rata-rata
              for ($i = 1; $i <= 5; $i++) {
                echo ($i <= $average_rating) ? '<span style="color: #FFD700;">★</span>' : '<span>☆</span>';
              }
              echo '</div>';
            } else {
              echo '<p class="mx-3 pt-4" style="color: #000000">Rating: Belum ada ulasan</p>';
            }
            echo '</div>';
            echo '</div>';
            
            echo '</div>';
            echo '</div>';
          } 

          $sql = "SELECT COUNT(id_buku) AS total FROM buku WHERE id_kategori = '$id_kategori'";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          $total_pages = ceil($row["total"] / $results_per_page);

          echo '<div class="col-lg-12">';
          echo '<div class="pagination">';
          for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a class="' . ($i == $page ? 'active' : '') . '" href="?page=' . $i . '&id_kategori=' . $id_kategori . '">' . $i . '</a>';
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
