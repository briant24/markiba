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
    span {
        font-size: 40px; /* Sesuaikan ukuran font sesuai kebutuhan */
    }

    span[style*="color: transparent"] {
        display: inline-block;
        width: 2em;
        overflow: hidden;
    }
  </style>
</head>
<?php
$activePage = 'ulasan';
include 'header.php';
?>
<body>
  <div class="happy-clients section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading mt-4">
            <h2>Ulasan <em>Buku</em></span></h2>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="naccs">
            <div class="tabs">
              <div class="row">
                <div class="col-lg-12">
                  <ul class="nacc">
                    <li class="active">
                      <div>
                        <div class="row">
                          <?php
                          if (isset($_GET['id_buku'])) {
                              // Get the value of id_buku from the URL
                              $id_buku = $_GET['id_buku'];

                              include 'koneksi.php';
                              // Query SQL untuk mengambil data buku dan ulasan
                              $sql = "SELECT buku.id_buku, buku.judul_buku, buku.nama_penulis, buku.tahun_terbit, buku.gambar, 
                              buku.sinopsis, kategori.nama_kategori,
                              AVG(ulasan.rating) AS rating_rata
                              FROM buku
                              INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori
                              LEFT JOIN ulasan ON buku.id_buku = ulasan.id_buku
                              WHERE buku.id_buku = $id_buku
                              GROUP BY buku.id_buku";

                              $result = mysqli_query($conn, $sql);

                              // Check if there are results
                              if (mysqli_num_rows($result) > 0) {
                              $row = mysqli_fetch_assoc($result);
                              echo '<div class="col-lg-5 align-self-center text-center">';
                              echo '<img src="data:image/jpeg;base64,' . base64_encode($row['gambar']) . '" alt="' . $row['judul_buku'] . '" style="width: 100%; object-fit: cover;">';

                              if (!is_null($row['rating_rata'])) {
                                echo '<p class="mx-3 pt-4" style="color: #000000; font-size: 14pt;">Rating: ' . number_format($row['rating_rata'], 1) . ' / 5</p>';
                                echo '<div class="mx-3 mt-0 pt-0">';
                                $average_rating = round($row['rating_rata']);
                                for ($i = 1; $i <= 5; $i++) {
                                    echo ($i <= $average_rating) ? '<span style="color: #FFD700;">★</span>' : '<span>☆</span>';
                                }
                                echo '</div>';
                            } else {
                                echo '<p class="mx-3 pt-4" style="color: #000000; font-size: 14pt;">Rating: Belum ada rating</p>';
                            }
                            
                              echo '<a href="tambah_ulasan.php?id_buku=' . $row['id_buku'] . '" class="btn mt-3" style="background-color: #6006E6; color: #ffffff;">Tambah Ulasan</a>';
                              echo '</div>';

                              echo '<div class="col-lg-7 px-5 py-5">';
                              echo '<h4>' . $row['judul_buku'] . '</h4>';
                              echo '<div class="line-dec"></div>';

                              // Use nl2br to preserve line breaks in sinopsis
                              echo '<p style="color: #000000">' . nl2br($row['sinopsis']) . '</p><br/>';

                              echo '<p style="color: #000000">Penulis: ' . $row['nama_penulis'] . '</p>';
                              echo '<p style="color: #000000">Tahun Terbit: ' . $row['tahun_terbit'] . '</p>';
                              echo '<p style="color: #000000">Kategori: ' . $row['nama_kategori'] . '</p>';
                              echo '</div>'; // penutup div class="col-lg-7"
                              } else {
                              echo "No book found with the specified ID.";
                              }
                          }
                          ?>
                        </div>
                      </div>
                      <div>
                        <br>
                        <?php 
                            echo '<div class="row mt-4">';
                            echo '<div class="col-lg-12">';
                            echo '<div class="section-heading">';
                            echo '<h2>Kata <em>Mereka</em></h2>';
                            echo '</div>';
                            // Query SQL untuk mengambil ulasan-ulasan
                            $sql_ulasan = "SELECT *
                            FROM ulasan
                            WHERE id_buku = $id_buku
                            ORDER BY tanggal DESC";
                            $result_ulasan = mysqli_query($conn, $sql_ulasan);
                            echo '<div class="row mt-4">';
                            if (mysqli_num_rows($result_ulasan) > 0) {
                            while ($row_ulasan = mysqli_fetch_assoc($result_ulasan)) {
                            echo '<div class="col-lg-6">';
                            echo '<div class="card mt-3" style="background-color: #f0f0f0;">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $row_ulasan['username'] . '</h5>';
                            echo '<p class="card-text">' . nl2br($row_ulasan['isi_ulasan']) . '</p>';
                            echo '<p class="card-text">Rating: ' . $row_ulasan['rating'] . ' / 5</p>';
                            echo '<p class="card-text"><small class="text-muted">Waktu: ' . $row_ulasan['tanggal'] . '</small></p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            }
                            } else {
                            echo '<div class="col-lg-12">';
                            echo '<p>Tidak ada ulasan untuk buku ini.</p>';
                            echo '</div>';
                            }
                            echo '</div>';
                            echo '</div>'; // penutup div class="col-lg-12"
                            echo '</div>'; // penutup div class="row"
                        ?>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
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