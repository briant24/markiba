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
    .category-item {
      position: relative;
      width: 350px;
      text-align: center;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
      margin-bottom: 40px;
    }

    .category-item:hover {
      transform: scale(1.05);
    }

    .category-item img {
      max-width: 100%;
      height: auto;
      border-radius: 6px;
    }

    .category-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(138, 43, 226, 0.7);
      border-radius: 6px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .category-item:hover .category-overlay {
      opacity: 1;
    }

    .category-overlay h5 {
      color: #fff;
      margin: 0;
    }
  </style>

</head>

<body>
<?php
$activePage = 'kategori';
include 'header.php';
?>
  
  <div class="happy-clients section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading mt-4">
            <h2>Kategori <em>Buku</em></h2>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="row">
          <?php
          // Include the database connection file
          include 'koneksi.php';

          // Fetch categories from the database
          $sql = "SELECT * FROM kategori";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $gambar = base64_encode($row['gambar']);
          ?>
            
            <div class="col-md-4">
              <a href="ulasan_kategori.php?id_kategori=<?php echo $row['id_kategori']; ?>">
                <div class="category-item mx-auto">
                  <img style="height: 200px; object-fit: cover; border-radius: 0px" src="data:image/jpeg;base64, <?php echo $gambar; ?>" alt="<?php echo $row['nama_kategori']; ?>">
                  <div class="category-overlay">
                    <h5><?php echo $row['nama_kategori']; ?></h5>
                  </div>
                  <h5 class="mt-3 text-black"><?php echo $row['nama_kategori']; ?></h5>
                </div>
              </a>
            </div>
          <?php
            }
          } else {
            echo "0 results";
          }

          // Close connection
          $conn->close();
          ?>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
