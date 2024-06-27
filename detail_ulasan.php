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
                      <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="section-heading mt-4">
                                <h2>Forum <em>Diskusi</em></h2>
                            </div>
                            <?php
                            $sql_diskusi = "SELECT diskusi.* , admin.nama_admin 
                            FROM diskusi 
                            INNER JOIN admin
                            ON diskusi.id_admin = admin.id_admin
                            WHERE id_buku = $id_buku ORDER BY waktu DESC";
                            $result_diskusi = mysqli_query($conn, $sql_diskusi);

                            if (mysqli_num_rows($result_diskusi) > 0) {
                              while ($row_diskusi = mysqli_fetch_assoc($result_diskusi)) {
                                  $id_diskusi = $row_diskusi['id_diskusi'];
                                  echo '<div class="card mt-3">';
                                  echo '<div class="card-body">';
                                  echo '<div style="display: flex; justify-content: space-between; align-items: flex-start;">';
                                  echo '<div>';
                                  echo '<p class="card-text" style="color:#000000;"><strong>' . nl2br($row_diskusi['isi_diskusi']) . '</strong></p>';
                                  echo '<p class="card-text"><small class="text-muted">Waktu: ' . $row_diskusi['waktu'] . '</small></p>';
                                  echo '<div style="display: flex; justify-content: space-between; align-items: flex-start;">';
                                  echo '<div style="display: flex; align-items: center;">';
                                  $sql_check_suka = "SELECT COUNT(*) AS sudah_suka FROM suka_diskusi WHERE id_diskusi = $id_diskusi AND id_user = $_SESSION[user_id];";
                                  $result_check_suka = mysqli_query($conn, $sql_check_suka);
                                  $row_check_suka = mysqli_fetch_assoc($result_check_suka);
                                  $sudah_suka = $row_check_suka['sudah_suka'];
                                  if ($sudah_suka > 0) {
                                      echo '<span class="font-weight-normal mr-2 suka-link" style=" font-size: 14px; color: #00008B; margin-right:10px;">Sudah Disukai</span>';
                                  } else {
                                      echo '<span class="font-weight-normal mr-2 suka-link" style="font-size: 14px; color: black; cursor: pointer; margin-right: 10px;" data-id-diskusi="' . $id_diskusi . '" user-id="' . $_SESSION['user_id'] . '" tipe-suka="diskusi">Suka</span>';
                                  }
                                  echo '<span class="font-weight-normal mr-2 balas-link" style="font-size: 14px; color: black; cursor: pointer;" data-id="' . $id_diskusi . '" tipe-komentar="diskusi">Balas</span>';
                                  echo '</div>';
                                  $sql_hitung_suka = "SELECT COUNT(*) AS jumlah_suka FROM suka_diskusi WHERE id_diskusi= $id_diskusi";
                                  $result_hitung_suka = mysqli_query($conn, $sql_hitung_suka);
                                  $row_hitung_suka = mysqli_fetch_assoc($result_hitung_suka);
                                  $jumlah_suka = $row_hitung_suka['jumlah_suka'];
                                  if ($jumlah_suka == 0) {
                                      echo '<span class="font-weight-normal mr-2 suka-link" style=" font-size: 14px; color: #6006E6; margin-right:10px;">0 Suka</span>';
                                  } else {
                                      echo '<span class="font-weight-normal mr-2 suka-link" style=" font-size: 14px; color: #6006E6; margin-right:10px;"> '. $jumlah_suka .' Suka</span>';
                                  }  
                                  echo '</div>';
                                  echo '</div>';
                                  echo '<div>';
                                  echo '<p class="card-text"><strong>' . nl2br($row_diskusi['nama_admin']) . '</strong></p>';
                                  echo '</div>';
                                  echo '</div>';
                                  $sql_komentar = "SELECT komentar_diskusi.*, users.nama_user
                                  FROM komentar_diskusi
                                  INNER JOIN users
                                  on komentar_diskusi.id_user = users.id 
                                  WHERE komentar_diskusi.id_diskusi = '$id_diskusi' ORDER BY komentar_diskusi.waktu ASC";
                                  $result_komentar = mysqli_query($conn, $sql_komentar);
                                  if (mysqli_num_rows($result_komentar) > 0) {
                                      echo '<div class="mt-3">';
                                      while ($row_komentar = mysqli_fetch_assoc($result_komentar)) {
                                          echo '<div class="card mt-3">';
                                          echo '<div class="card-body">';
                                          echo '<span class="card-title font-weight-normal" style="font-size: 14px; color:#935AEC">' . $row_komentar['nama_user'] . '</span>';
                                          echo '<p class="card-text" style="color:black;">' . nl2br($row_komentar['isi_komentar']) . '</p>';
                                          echo '<p class="card-text"><small class="text-muted">Waktu: ' . $row_komentar['waktu'] . '</small></p>';
                                          echo '<div style="display: flex; justify-content: space-between; align-items: flex-start;">';
                                          echo '<div style="display: flex; align-items: center;">';
                                          $id_komentar = $row_komentar['id_komentar'];
                                          $sql_check_suka = "SELECT COUNT(*) AS sudah_suka FROM suka_komentar WHERE id_komentar = $id_komentar AND id_user = $_SESSION[user_id];";
                                          $result_check_suka = mysqli_query($conn, $sql_check_suka);
                                          $row_check_suka = mysqli_fetch_assoc($result_check_suka);
                                          $sudah_suka = $row_check_suka['sudah_suka'];
                                          if ($sudah_suka > 0) {
                                              echo '<span class="font-weight-normal mr-2 suka-link" style=" font-size: 14px; color: #00008B; margin-right:10px;">Sudah Disukai</span>';
                                          } else {
                                              echo '<span class="font-weight-normal mr-2 suka-link" style="font-size: 14px; color: black; cursor: pointer; margin-right: 10px;" data-id-diskusi="' . $id_komentar . '" user-id="' . $_SESSION['user_id'] . '" tipe-suka="komentar">Suka</span>';
                                          }  
                                          echo '<span class="font-weight-normal mr-2 balas-link" style="font-size: 14px; color: black; cursor: pointer;" data-id="' . $id_komentar . '" tipe-komentar="komentar">Balas</span>';
                                          echo '</div>';
                                          $sql_hitung_suka = "SELECT COUNT(*) AS jumlah_suka FROM suka_komentar WHERE id_komentar= $id_komentar";
                                          $result_hitung_suka = mysqli_query($conn, $sql_hitung_suka);
                                          $row_hitung_suka = mysqli_fetch_assoc($result_hitung_suka);
                                          $jumlah_suka = $row_hitung_suka['jumlah_suka'];
                                          if ($jumlah_suka == 0) {
                                              echo '<span class="font-weight-normal mr-2 suka-link" style=" font-size: 14px; color: #6006E6; margin-right:10px;">0 Suka</span>';
                                          } else {
                                              echo '<span class="font-weight-normal mr-2 suka-link" style=" font-size: 14px; color: #6006E6; margin-right:10px;"> '. $jumlah_suka .' Suka</span>';
                                          }  
                                          echo '</div>';
                                          $sql_sub_komentar = "SELECT sub_komentar.*, users.nama_user
                                          FROM sub_komentar
                                          INNER JOIN users
                                          on sub_komentar.id_user = users.id 
                                          WHERE sub_komentar.id_komentar = '$id_komentar' ORDER BY sub_komentar.waktu ASC";
                                          $result_sub_komentar = mysqli_query($conn, $sql_sub_komentar);
                                          if (mysqli_num_rows($result_sub_komentar) > 0) {
                                            echo '<div class="mt-3">';
                                            while ($row_sub_komentar = mysqli_fetch_assoc($result_sub_komentar)) {
                                                echo '<div class="card mt-3">';
                                                echo '<div class="card-body">';
                                                echo '<span class="card-title font-weight-normal" style="font-size: 14px; color:#935AEC">' . $row_komentar['nama_user'] . '</span>';
                                                echo '<p class="card-text" style="color:black;">' . nl2br($row_sub_komentar['isi_komentar']) . '</p>';
                                                echo '<p class="card-text"><small class="text-muted">Waktu: ' . $row_sub_komentar['waktu'] . '</small></p>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                            echo '</div>';
                                          }
                                          echo '</div>';
                                          echo '</div>';
                                      }
                                  } else {
                                      echo '<p>Belum ada komentar.</p>';
                                  }                                  
                                  echo '</div>';
                                  echo '</div>';
                              }
                            } else {
                              echo '<p>Tidak ada diskusi untuk buku ini.</p>';
                            }
                            ?>
                        </div>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function() {
    $('.suka-link').click(function() {
        var idDiskusi = $(this).attr('data-id-diskusi');
        var idUser = $(this).attr('user-id');
        var tipeSuka = $(this).attr('tipe-suka');
        console.log(idDiskusi, idUser, tipeSuka);
        var sukaLink = $(this); // Simpan elemen tombol suka
        $.ajax({
            type: 'POST',
            url: 'proses_suka.php',
            data: {
              id_diskusi: idDiskusi,
              id_user: idUser,
              tipe: tipeSuka
            },
            success: function(response) {
                // Handle success response
                console.log('Berhasil menambah suka.');
                // Ubah tampilan tombol menjadi "Sudah Disukai"
                location.reload();
            },
            error: function(xhr, status, error) {
                // Handle error response jika diperlukan
                console.error('Gagal menambah suka: ' + error);
            }
        });
    });
  });
  </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const balasLinks = document.querySelectorAll('.balas-link');
        const modalBalas = new bootstrap.Modal(document.getElementById('modalBalas'));
        
        balasLinks.forEach(link => {
            link.addEventListener('click', function() {
                const idDiskusi = this.getAttribute('data-id');
                const tipeKomentar = this.getAttribute('tipe-komentar');
                document.getElementById('id_diskusi').value = idDiskusi;
                document.getElementById('tipe_komentar').value = tipeKomentar;
                modalBalas.show(); // Tampilkan modal
            });
        });

        // Tambahkan event listener untuk form submit
        const formKomentar = document.getElementById('formKomentar');
        formKomentar.addEventListener('submit', function(event) {
            event.preventDefault(); // Menghentikan pengiriman form bawaan

            // Ambil data dari form
            const formData = new FormData(formKomentar);

            // Kirim data menggunakan AJAX
            $.ajax({
                url: 'proses_komentar.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Sukses: lakukan apa yang diperlukan (misalnya, sembunyikan modal, reset form, dll.)
                    modalBalas.hide();
                    formKomentar.reset();
                    alert('Komentar berhasil dikirim!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Error handling
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim komentar.');
                }
            });
        });
    });
</script>

  <!-- Modal Balas -->
  <div class="modal fade" id="modalBalas" tabindex="-1" aria-labelledby="modalBalasLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalBalasLabel">Balas Diskusi</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <!-- Form komentar disini -->
                  <form id="formKomentar" action="proses_komentar.php" method="POST">
                      <div class="mb-3">
                          <label for="komentar" class="form-label">Komentar:</label>
                          <textarea class="form-control" id="isi_komentar" name="isi_komentar"></textarea>
                      </div>
                      <!-- Tambahan: mungkin perlu input hidden untuk id_diskusi -->
                      <input type="hidden" id="id_diskusi" name="id_diskusi" value="">
                      <input type="hidden" id="tipe_komentar" name="tipe_komentar" value="">
                      <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
</body>
</html>