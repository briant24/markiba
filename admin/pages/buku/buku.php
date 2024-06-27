<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect to the login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Markiba</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../node_modules/jqvmap/dist/jqvmap.min.css" />
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/Markiba.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php"><img src="../../images/Markiba.png" alt="logo" style="width: 50px; height: 50px; margin-right:20px"/><span class="text-primary" style="font-weight: bold">MARKIBA<span></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../../images/Markiba.png" alt="logo" style="width: 50px; height: 50px; margin-left: 20px"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown" style="display: flex; align-items: center;">
              <i class="mdi mdi-account-circle" style="font-size: 18pt; margin-right: 8px; color: #B66DFF"></i>
              <span style="color: #B66DFF"><?php echo $_SESSION['nama']; ?></span>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
    <?php
      $active_page = 'buku';
    ?>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
        $(function() {
          $("#includeHtml").load("../layout/sidebar.html");
        });
    </script>
    <div id="includeHtml"></div>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Buku
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar buku</li>
              </ol>
            </nav>
          </div>
          <?php
            include '../../../koneksi.php';

            // Query SQL untuk menampilkan data buku dengan join pada tabel kategori dan ulasan
            $sql = "SELECT DISTINCT buku.id_buku, buku.judul_buku, buku.nama_penulis, buku.tahun_terbit, buku.gambar, 
                    buku.sinopsis, kategori.nama_kategori,
                    MAX(ulasan.isi_ulasan) AS isi_ulasan, MAX(ulasan.rating) AS rating
                    FROM buku
                    INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori
                    LEFT JOIN ulasan ON buku.id_buku = ulasan.id_buku
                    GROUP BY buku.id_buku";
            $result = mysqli_query($conn, $sql);
          ?>
          <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">Daftar Buku</h4>
                                <p class="card-description">Data buku dari tabel buku, kategori, dan ulasan</p>
                            </div>
                            <div class="text-right">
                                <a href="tambah_buku.php" class="btn btn-primary btn-sm">Tambah Buku</a>
                            </div>
                        </div>
                        <?php
                          // Ambil parameter status dan pesan dari URL
                          $status = isset($_GET['status']) ? $_GET['status'] : '';
                          $message = isset($_GET['message']) ? $_GET['message'] : '';

                          // Tampilkan alert berdasarkan status
                          if ($status === 'success') {
                              echo "<script>alert('$message')</script>";
                          } elseif ($status === 'error') {
                              echo "<script>alert('Terjadi kesalahan: $message')</script>";
                          }
                        ?>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Judul Buku</th>
                              <th>Nama Penulis</th>
                              <th>Tahun Terbit</th>
                              <th>Gambar</th>
                              <th>Kategori</th>
                              <th>Rating</th>
                              <th>Aksi</th>
                              <th>Ulasan</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              // Periksa hasil query
                              if ($result) {
                                $no = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                  $no++;
                                  echo "<tr>";
                                  echo "<td>" . $no . "</td>";
                                  echo "<td>" . $row['judul_buku'] . "</td>";
                                  echo "<td>" . $row['nama_penulis'] . "</td>";
                                  echo "<td>" . $row['tahun_terbit'] . "</td>";
                                  echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['gambar']) . "' alt='Gambar' style='width: 50px; height: auto; border-radius: 0px'></td>";
                                  echo "<td>" . $row['nama_kategori'] . "</td>";
                                  echo "<td>" . $row['rating'] . "</td>";
                                  $reviewButton = '';
                                      if (!empty($row['isi_ulasan'])) {
                                          // If there is a review, show "Edit Ulasan" button
                                          $reviewButton = "<a href='../../../detail_ulasan.php?id_buku=" . $row['id_buku'] . "' class='btn btn-info btn-sm'>Lihat Ulasan</a>";
                                      } else {
                                          // If there is no review, show "Tambah Ulasan" button
                                          $reviewButton = "<a href='tambah_ulasan.php?id_buku=" . $row['id_buku'] . "' class='btn btn-primary btn-sm'>Tambah Ulasan</a>";
                                  }
                                  echo "
                                      <td>
                                        <a href='edit_buku.php?id=" . $row['id_buku'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='proses_hapus_buku.php?id=" . $row['id_buku'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus?\")'>Hapus</a>
                                        <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#detailModal$no'>
                                          Detail
                                        </button>
                                        
                                        </td>
                                      ";
                                  echo "<td>" . $reviewButton . "</td>";
                                  
                                  echo "</tr>";
                            
                                  // Modal for each row
                                  echo "<div class='modal fade mt-5' id='detailModal$no' tabindex='-1' role='dialog' aria-labelledby='detailModalLabel$no' aria-hidden='true'>
                                          <div class='modal-dialog modal-lg' role='document'>
                                            <div class='modal-content'>
                                              <div class='modal-header'>
                                                <h5 class='modal-title' id='detailModalLabel$no'>Detail Buku</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                  <span aria-hidden='true'>&times;</span>
                                                </button>
                                              </div>
                                              <div class='modal-body'>
                                                <p><strong>Judul Buku:</strong> {$row['judul_buku']}</p>
                                                <p><strong>Nama Penulis:</strong> {$row['nama_penulis']}</p>
                                                <p><strong>Tahun Terbit:</strong> {$row['tahun_terbit']}</p>
                                                <p><strong>Sinopsis:</strong> {$row['sinopsis']}</p>
                                                <p><strong>Kategori:</strong> {$row['nama_kategori']}</p>
                                                <p><strong>Rating:</strong> {$row['rating']}</p>
                                                <p><strong>Ulasan:</strong> {$row['isi_ulasan']}</p>
                                              </div>
                                              <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>";
                                }
                              } else {
                                echo "Error: " . mysqli_error($conn);
                              }

                              // Tutup koneksi
                              mysqli_close($conn);
                            ?>
                          </tbody>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2017 <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap Dash</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
