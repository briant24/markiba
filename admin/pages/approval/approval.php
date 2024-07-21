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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
      $active_page = 'approval';
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
              Daftar Approval
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Approval</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Approval</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h4 class="card-title">Daftar Approval</h4>
                      <p class="card-description">Data Approval</p>
                    </div>
                  </div>
                  <?php
                  include '../../../koneksi.php';

                  // Query SQL untuk menampilkan data Ulasan
                  $sql = "SELECT ulasan.id_ulasan AS id, users.nama_user AS nama,
                  buku.judul_buku AS judul, ulasan.tanggal AS tanggal, ulasan.status AS status,
                  'Lihat Detail' AS isi, 'Ulasan' AS tipe FROM ulasan 
                  INNER JOIN users ON ulasan.username = users.username INNER JOIN buku 
                  on ulasan.id_buku = buku.id_buku
                  UNION
                  SELECT komentar_diskusi.id_komentar AS id, users.nama_user AS nama,
                  diskusi.isi_diskusi AS judul, komentar_diskusi.waktu AS tanggal, komentar_diskusi.status AS status,
                  komentar_diskusi.isi_komentar AS isi, 'Komentar' AS tipe FROM komentar_diskusi
                  INNER JOIN users ON komentar_diskusi.id_user = users.id INNER JOIN diskusi
                  on komentar_diskusi.id_diskusi = diskusi.id_diskusi";
                  $result_artikel = mysqli_query($conn, $sql);
                  ?>
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
                        <th>User</th>
                        <th>Buku / Diskusi</th>
                        <th>Isi</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($result_artikel) {
                        $no = 0;
                        while ($row_artikel = mysqli_fetch_assoc($result_artikel)) {
                            $status_class = '';
                            $status_text = '';
                            $status = $row_artikel['status'];
                            switch ($status) {
                                case 'accept':
                                    $status_class = 'badge-success';
                                    $status_text = 'Approved';
                                    break;
                                case 'reject':
                                    $status_class = 'badge-danger';
                                    $status_text = 'Rejected';
                                    break;
                                default:
                                    $status_class = 'badge-warning';
                                    $status_text = 'Pending';
                                    break;
                            }
                          $no++;
                          echo "<tr>";
                          echo "<td>" . $no . "</td>";
                          echo "<td>" . $row_artikel['nama'] . "</td>";
                          echo "<td>" . $row_artikel['judul'] . "</td>";
                          echo "<td>" . $row_artikel['isi'] . "</td>";
                          echo "<td>" . $row_artikel['tanggal'] . "</td>";
                          echo "<td>" . $row_artikel['tipe'] . "</td>";
                          echo "<td><span class='badge $status_class'>$status_text</span></td>";
                          echo "<td>
                                    <button class='btn btn-info btn-sm view-detail-btn' data-id='" .$row_artikel['id']. "' data-tipe=' " . $row_artikel['tipe'] ."'>i</button>
                                    <button class='btn btn-success btn-sm approve-btn' data-id='" . $row_artikel['id'] . "' data-tipe='" . $row_artikel['tipe'] . "'>Approve</button>
                                    <button class='btn btn-danger btn-sm reject-btn' data-id='" . $row_artikel['id'] . "' data-tipe='" . $row_artikel['tipe'] . "'>Reject</button>
                                </td>";
                          echo "</tr>";
                        }
                      } else {
                        echo "Error: " . mysqli_error($conn);
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal untuk menampilkan pertanyaan dan jawaban -->
          <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="detailModalLabel">Detail Pertanyaan dan Jawaban</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div id="questionList"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
$(document).ready(function() {
    $('.approve-btn').click(function() {
        var id = $(this).data('id');
        var tipe = $(this).data('tipe');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan approve " + tipe.toLowerCase() + " ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Approve',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 'accept', tipe);
            }
        });
    });

    $('.reject-btn').click(function() {
        var id = $(this).data('id');
        var tipe = $(this).data('tipe');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan menolak " + tipe.toLowerCase() + " ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Reject',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 'reject', tipe);
            }
        });
    });

    function updateStatus(id, status, tipe) {
        $.ajax({
            url: 'change_status.php',
            type: 'POST',
            data: {
                id: id,
                status: status,
                tipe: tipe
            },
            success: function(response) {
                console.log(response);
                if (response === 'success') {
                    Swal.fire(
                        'Berhasil!',
                        'Status sudah ter-update.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Gagal saat update status.',
                        'error'
                    );
                }
            },
            error: function() {
                Swal.fire(
                    'Error!',
                    'An error occurred.',
                    'error'
                );
            }
        });
    }
});
</script>
<script>
$(document).ready(function() {
    $('.view-detail-btn').click(function() {
        var id = $(this).data('id');
        var tipe = $(this).data('tipe');
        $.ajax({
            url: '../../../get_detail.php',
            type: 'POST',
            data: {
                id: id,
                tipe: tipe
            },
            success: function(response) {
                $('#questionList').html(response);
                $('#detailModal').modal('show');
                console.log(response);
            },
            error: function() {
                alert('Terjadi kesalahan saat memuat detail.');
            }
        });
    });
});
</script>




</body>

</html>
