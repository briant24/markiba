<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <title>Markiba</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/templatemo-tale-seo-agency.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
  
  <!--

TemplateMo 582 Tale SEO Agency

https://templatemo.com/tm-582-tale-seo-agency

-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="assets/images/Markiba.png" />
</head>
<style>
#searchResults {
    position: absolute;
    top: 100%;
    left: 0;
    width: calc(100% - 2px); /* Penyesuaian untuk border yang tipis */
    background-color: #fff;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 10;
    max-height: 200px; /* Mengurangi tinggi maksimum hasil pencarian */
    overflow-y: auto;
    display: none; /* Awalnya sembunyikan hasil pencarian */
}

#searchResults p {
    padding: 8px 10px; /* Mengurangi padding pada paragraf */
    margin: 0;
    color: #5B03E4;
    border-bottom: 1px solid #eee;
    font-size: 14px;
    cursor: pointer;
}

#searchResults p:last-child {
    border-bottom: none;
}

.search-box button {
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 65px; /* Lebar ikon pencarian */
    background-color: transparent;
    border: none;
    cursor: pointer;
  }
  .search-box button i {
    font-size: 25px; /* Ukuran ikon */
    color: #fff; /* Warna ikon */
  }

</style>
<?php 
$activePage = 'home';
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

  <div class="main-banner" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <div class="caption header-text">
            <h6>Markiba</h6>
            <div class="line-dec"></div>
            <h4>Selamat Datang di<em> <br/>Mari Kita Baca!</em></h4>
            <p>Dengan markiba, kita dapat mengeksplorasi dunia baru melalui buku.</p>
            <div class="box">
            <input type="checkbox" id="check">
            <div class="search-box">
              <form action="find.php" method="POST">
                <input type="text" id="keyword" name="keyword" placeholder="Type here...">
                <label for="submit-button" class="icon">
                  <button type="submit" id="submit-button">
                    <i class="fas fa-search"></i>
                  </button>
                </label>
                <div id="searchResults"></div>
              </form>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="services section" id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h2>Temukan berbagai jenis<em> genre!</em></h2>
                            <div class="line-dec"></div>
                            <p>Tersedia banyak pilihan kategori dan genre buku, ayo temukan favoritmu.</p>
                            <a href="kategori.php" class=""><button class="btn btn-primary mt-4" style="background-color: #5B03E4; border: none"> Explore More</button></a>
                        </div>
                    </div>

                    <?php
                        // Assuming you have a database connection
                        include 'koneksi.php';

                        // Fetch top 4 categories from the database
                        $sql = "SELECT * FROM kategori LIMIT 4";
                        $result = mysqli_query($conn, $sql);

                        // Check if there are results
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="service-item">
                                        <div class="icon">
                                            <img src="assets/images/icon-book.jpg" alt="category icon" class="templatemo-feature">
                                        </div>
                                        <h4>
                                            <a href="ulasan_kategori.php?category=<?php echo $row['nama_kategori']; ?>" style="color: #5B03E4">
                                                <?php echo $row['nama_kategori']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                    <?php
                            }
                        } else {
                            echo "No categories found.";
                        }

                        // Close the database connection
                        mysqli_close($conn);
                    ?>

                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="projects section" id="projects">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h2>Baca ulasan<em> terbaru!</em></h2>
                    <div class="line-dec"></div>
                    <a href="ulasan.php" class="" ><button class="btn btn-primary" style="background-color: #5B03E4; border: none"> Explore More</button></a>
                </div>
            </div>
        </div>
      </div>
      <?php
      // Assuming you have a database connection
      include 'koneksi.php';

      // Fetch 6 latest books from the database
      $sql = "SELECT * FROM buku ORDER BY id_buku DESC LIMIT 6";
      $result = mysqli_query($conn, $sql);

      // Check if there are results
      if (mysqli_num_rows($result) > 0) {
      ?>
      <div class="container-fluid">
          <div class="row">
              <div class="col-lg-12">
                  <div class="owl-features owl-carousel">
                      <?php
                      // Loop through each project and display it
                      while ($row = mysqli_fetch_assoc($result)) {
                          // Assuming 'gambar' column contains the BLOB data
                          $imageData = base64_encode($row['gambar']);
                          $imageSrc = "data:image/png;base64,{$imageData}";
                      ?>
                          <div class="item">
                              <!-- Add style to set fixed dimensions -->
                              <img style="width: 100%; height: 550px; object-fit: cover;" src="<?php echo $imageSrc; ?>" alt="<?php echo $row['judul_buku']; ?>">
                              <div class="down-content">
                                  <h4><?php echo $row['judul_buku']; ?></h4>
                                  <p><?php echo $row['nama_penulis']; ?></p>
                                  <a href="detail_ulasan.php?id_buku=<?php echo $row['id_buku']; ?>"><i class="fa fa-eye"></i></a>
                              </div>
                          </div>
                      <?php
                      }
                      ?>
                  </div>
              </div>
          </div>
      </div>
      <?php
      } else {
          echo "No books found.";
      }

      // Close the database connection
      mysqli_close($conn);
      ?>
  </div>

  <div class="projects section" id="projects">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h2>Rekomendasi<em> Untuk anda baca!</em></h2>
                    <div class="line-dec"></div>
                    <a href="rekomendasi.php" class="" ><button class="btn btn-primary" style="background-color: #5B03E4; border: none"> Explore More</button></a>
                </div>
            </div>
        </div>
      </div>

      <?php
      // Assuming you have a database connection
      include 'koneksi.php';

      // Fetch 6 latest books from the database
      $sql = "SELECT buku.id_buku, buku.judul_buku, buku.nama_penulis, buku.gambar, ulasan.rating
      FROM buku
      LEFT JOIN ulasan ON buku.id_buku = ulasan.id_buku WHERE ulasan.rating = 5 ORDER BY buku.id_buku DESC";
      $result = mysqli_query($conn, $sql);
      
      // Check if there are results
      if (mysqli_num_rows($result) > 0) {
      ?>
      <div class="container-fluid">
          <div class="row">
              <div class="col-lg-12">
                  <div class="owl-features owl-carousel">
                      <?php
                      // Loop through each project and display it
                      while ($row = mysqli_fetch_assoc($result)) {
                          // Assuming 'gambar' column contains the BLOB data
                          $imageData = base64_encode($row['gambar']);
                          $imageSrc = "data:image/png;base64,{$imageData}";
                          
                      ?>
                          <div class="item">
                              <!-- Add style to set fixed dimensions -->
                              <img style="width: 100%; height: 550px; object-fit: cover;" src="<?php echo $imageSrc; ?>" alt="<?php echo $row['judul_buku']; ?>">
                              <div class="down-content">
                                  <h4><?php echo $row['judul_buku']; ?></h4>
                                  <p><?php echo $row['nama_penulis']; ?></p>
                                  <?php for ($i = 1; $i <= 5; $i++) {
                                  echo ($i <= $row['rating']) ? '<span style="color: #FFD700;">★</span>' : '<span>☆</span>';
                                  }?>
                                  <a href="detail_ulasan.php?id_buku=<?php echo $row['id_buku']; ?>"><i class="fa fa-eye"></i></a>
                              </div>
                          </div>
                      <?php
                      }
                      ?>
                  </div>
              </div>
          </div>
      </div>
      <?php
      } else {
          echo "No books found.";
      }

      // Close the database connection
      mysqli_close($conn);
      ?>
  </div>

  <div class="infos section" id="infos">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="main-content">
            <div class="row">
              <div class="col-lg-6">
                <div class="left-image">
                  <img src="assets/images/left-infos.jpg" alt="">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="section-heading">
                  <h2>Ayo jadi bagian dari peningkatan <em>kegemaran membaca</em> di Indonesia!</h2>
                  <div class="line-dec"></div>
                  <p>Tahukah kamu? Tingkat Kegemaran Membaca (TGM) Masyarakat Indonesia terus meningkat per tahun 2021? Berdasarkan dari data Perpustakaan Nasional (Perpunas) Saat ini Indonesia sudah masuk ke dalam TGM Kategori tinggi loh!</p>
                </div>
                <div class="skills">
                  <div class="skill-slide marketing">
                    <div class="fill"></div>
                    <h6>2021</h6>
                    <span>59,52%</span>
                  </div>
                  <div class="skill-slide digital">
                    <div class="fill"></div>
                    <h6>2022</h6>
                    <span>63.9%</span>
                  </div>
                  <div class="skill-slide media">
                    <div class="fill"></div>
                    <h6>2023</h6>
                    <span>?</span>
                  </div>
                </div>
                <p class="more-info">Jadi, sudah siapkah kamu untuk terus menjadi bagian dari peningkatan TGM di Indonesia?
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>Copyright © 2023 <a href="#">MARKIBA</a>
        </p>
      </div>
    </div>
  </footer>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>
  <script>
        $(document).ready(function(){
            $("#keyword").on("input", function(){
                var keyword = $(this).val();
                if (keyword.length >= 2) {
                    $.ajax({
                        url: "search.php",
                        method: "POST",
                        data: {keyword: keyword},
                        success: function(data){
                            $("#searchResults").html(data);
                            $("#searchResults").css("display", "block");
                        }
                    });
                } else {
                    $("#searchResults").css("display", "none");
                }
            });
            $(document).on("click", function(e) {
            if (!$(e.target).closest('.search-container').length) {
                $("#searchResults").css("display", "none");
            }
            });
            $(".search-container").on("click", function(e) {
              e.stopPropagation();
            });
            $(document).on("click", "#searchResults p", function(){
              var id_buku = $(this).attr("data-id");
              window.location.href = "detail_ulasan.php?id_buku=" + id_buku;
            });
          });
  </script>

</body>

</html>
