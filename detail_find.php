<?php
include 'koneksi.php';

// Get search parameters from query string
$sJudul = isset($_GET['sJudul']) ? $_GET['sJudul'] : '';
$sPenulis = isset($_GET['sPenulis']) ? $_GET['sPenulis'] : '';
$sTahun = isset($_GET['sTahun']) ? $_GET['sTahun'] : '';
$sPenerbit = isset($_GET['sPenerbit']) ? $_GET['sPenerbit'] : '';

// Build the query based on the search parameters
$query = "SELECT buku.*, AVG(ulasan.rating) AS avg_rating FROM buku 
          LEFT JOIN ulasan ON buku.id_buku = ulasan.id_buku 
          WHERE 1=1";

if ($sJudul != '') {
    $query .= " AND buku.judul_buku LIKE '%$sJudul%'";
}
if ($sPenulis != '') {
    $query .= " AND buku.nama_penulis LIKE '%$sPenulis%'";
}
if ($sTahun != '') {
    $query .= " AND buku.tahun_terbit = '$sTahun'";
}
if ($sPenerbit != '') {
    $query .= " AND buku.penerbit LIKE '%$sPenerbit%'";
}
$query .= " GROUP BY buku.id_buku";

// Pagination setup
$results_per_page = 6;
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
$start_from = ($page - 1) * $results_per_page;

// Add LIMIT to the query
$query .= " LIMIT $start_from, $results_per_page";
$result = mysqli_query($conn, $query);
?>
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
$activePage = '';
include 'header.php';
?>
<body>
  <div class="happy-clients section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading mt-4">
            <h2>Cari Buku <em></em></h2>
            <div class="line-dec"></div>
          </div>
        </div>

        <?php
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
            if ($row['avg_rating'] !== null) {
                echo '<p class="mx-3 pt-4" style="color: #000000">Rating: ' . round($row['avg_rating'], 2) . ' / 5</p>';
                echo '<div class="mx-3 mt-0 pt-0" style="">';
                // Menampilkan bintang berdasarkan nilai rating
                for ($i = 1; $i <= 5; $i++) {
                    echo ($i <= round($row['avg_rating'])) ? '<span style="color: #FFD700;">★</span>' : '<span>☆</span>';
                }
                echo '</div>';
            } else {
                echo '<p class="mx-3 pt-4" style="color: #000000">Belum ada rating</p>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }

          // Pagination links
          $query_count = "SELECT COUNT(DISTINCT buku.id_buku) AS total FROM buku 
                          LEFT JOIN ulasan ON buku.id_buku = ulasan.id_buku 
                          WHERE 1=1";
          if ($sJudul != '') {
              $query_count .= " AND buku.judul_buku LIKE '%$sJudul%'";
          }
          if ($sPenulis != '') {
              $query_count .= " AND buku.nama_penulis LIKE '%$sPenulis%'";
          }
          if ($sTahun != '') {
              $query_count .= " AND buku.tahun_terbit = '$sTahun'";
          }
          if ($sPenerbit != '') {
              $query_count .= " AND buku.penerbit LIKE '%$sPenerbit%'";
          }

          $result_count = mysqli_query($conn, $query_count);
          $row_count = mysqli_fetch_assoc($result_count);
          $total_pages = ceil($row_count["total"] / $results_per_page);

          echo '<div class="col-lg-12">';
          echo '<div class="pagination">';
          for ($i = 1; $i <= $total_pages; $i++) {
              echo '<a class="' . ($i == $page ? 'active' : '') . '" href="?sJudul=' . $sJudul . '&sPenulis=' . $sPenulis . '&sTahun=' . $sTahun . '&sPenerbit=' . $sPenerbit . '&page=' . $i . '">' . $i . '</a>';
          }
          echo '</div>';
          echo '</div>';
        } else {
          echo '<div class="col-lg-12">';
          echo 'Tidak ada buku yang ditemukan.';
          echo '</div>';
        }
        mysqli_close($conn);
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
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
