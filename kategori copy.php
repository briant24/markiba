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

<body>

  <header class="header-area header-sticky" style="top: 0px;">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <a href="index.php" class="logo">
              <img src="assets/images/Markiba3.png" alt="" style="width: 250px;" />
            </a>
            <ul class="nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="">Kategori</a></li>
              <li><a href="ulasan.php">Ulasan</a></li>
              <li class=""><a href="about.php">About Us</a></li>
              <li class=""><a href="artikel.php">Artikel</a></li>
              <li class=""><a href="admin/pages/auth/login.php">Login</a></li>
            </ul>
            <a class='menu-trigger'>
              <span>Menu</span>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </header>

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
            <h2>Ulasan Buku <em></em></h2>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-3">
            <h3 class="mb-3">Filter by Category:</h3>
            <form>
                <select class="form-select mb-4" id="categoryFilter" onchange="applyCategoryFilter()">
                <option value="" selected>All Categories</option>
                <?php
                include 'koneksi.php';

                // Fetch categories from the database
                $categorySql = "SELECT DISTINCT nama_kategori FROM kategori";
                $categoryResult = mysqli_query($conn, $categorySql);

                if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                    while ($category = mysqli_fetch_assoc($categoryResult)) {
                    echo '<option value="' . $category['nama_kategori'] . '">' . $category['nama_kategori'] . '</option>';
                    }
                }
                ?>
                </select>
            </form>
            </div>

            <script>
                function applyCategoryFilter() {
                    var selectedCategory = document.getElementById("categoryFilter").value;

                    // Redirect to the current page with the selected category as a parameter
                    window.location.href = "?category=" + selectedCategory;
                }
            </script>
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

        // Initialize category filter
        $categoryFilter = "";
        if (isset($_GET['category'])) {
          $categoryFilter = mysqli_real_escape_string($conn, $_GET['category']);
          $categoryFilter = " AND kategori.nama_kategori = '$categoryFilter'";
        }

        // Query SQL to retrieve book reviews from the database with category filter
        $sql = "SELECT buku.id_buku, buku.judul_buku, buku.nama_penulis, buku.gambar
                    FROM buku
                    INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori
                    WHERE 1 $categoryFilter
                    LIMIT $start_from, $results_per_page";

        $result = mysqli_query($conn, $sql);

        // Check if there are results
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            // Output the book information
            echo '<div class="col-lg-4">';
            echo '<div class="review-box">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['gambar']) . '" alt="' . $row['judul_buku'] . '" style="width: 100%; height: 600px; object-fit: cover;">';
            echo '<div class="review-content">';
            echo '<h4 class=""><a style="color: #000; text-decoration: none;" href="detail_ulasan.php?id_buku=' . $row['id_buku'] . '">' . $row['judul_buku'] . '</a></h4>';
            echo '<p>' . $row['nama_penulis'] . '</p>';
            // Add more details as needed
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }

          // Pagination links
          $sql = "SELECT COUNT(DISTINCT buku.id_buku) AS total
                        FROM buku
                        INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori
                        WHERE 1 $categoryFilter";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          $total_pages = ceil($row["total"] / $results_per_page);

          echo '<div class="col-lg-12">';
          echo '<div class="pagination">';
          for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a class="' . ($i == $page ? 'active' : '') . '" href="?category=' . $categoryFilter . '&page=' . $i . '">' . $i . '</a>';
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
