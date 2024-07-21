<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect to the login page
    exit();
}

include '../../../koneksi.php';

// Set halaman default jika tidak ada parameter GET
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5; // Jumlah buku per halaman
$offset = ($current_page - 1) * $records_per_page;

// Query SQL untuk menampilkan data buku dengan limit dan offset
$sql = "SELECT ulasan.rating, ulasan.id_ulasan, buku.judul_buku, users.nama_user, ulasan.tanggal, ulasan.status
        FROM ulasan
        INNER JOIN buku ON ulasan.id_buku = buku.id_buku
        INNER JOIN users ON ulasan.username = users.username
        LIMIT $records_per_page OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Hitung total halaman
$sql_count = "SELECT COUNT(DISTINCT ulasan.id_ulasan) AS total FROM ulasan";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_pages = ceil($row_count['total'] / $records_per_page);

mysqli_close($conn);
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="index.php"><img src="../../images/Markiba.png" alt="logo"
                        style="width: 50px; height: 50px; margin-right:20px" /><span class="text-primary"
                        style="font-weight: bold">MARKIBA<span></a>
                <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../../images/Markiba.png"
                        alt="logo" style="width: 50px; height: 50px; margin-left: 20px" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown" style="display: flex; align-items: center;">
                        <i class="mdi mdi-account-circle"
                            style="font-size: 18pt; margin-right: 8px; color: #B66DFF"></i>
                        <span style="color: #B66DFF"><?php echo $_SESSION['nama']; ?></span>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
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
                            Ulasan
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Ulasan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Daftar Ulasan</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title">Daftar Ulasan</h4>
                                            <p class="card-description">Daftar ulasan yang diberikan user.</p>
                                        </div>
                                        <div class="text-right">
                                        </div>
                                    </div>
                                    <?php if (mysqli_num_rows($result) > 0) : ?>
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
                                                <th>Nama</th>
                                                <th>Rating</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $start_number = ($current_page - 1) * $records_per_page + 1; // Hitung nomor buku awal

                                            $no = $start_number;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . $no . "</td>";
                                                echo "<td>" . $row['judul_buku'] . "</td>";
                                                echo "<td>" . $row['nama_user'] . "</td>";
                                                echo "<td>" . $row['rating'] . "</td>";
                                                echo "<td>
                                                    <button class='btn btn-info btn-sm view-detail-btn mdi mdi-information-outline' data-id='" .$row['id_ulasan']. "'></button>
                                                    <button class='btn btn-danger btn-sm delete-btn mdi mdi-delete-circle' data-id='" .$row['id_ulasan']. "'></button>
                                                </td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else : ?>
                    <p class="text-center">Tidak ada ulasan yang tersedia.</p>
                    <?php endif; ?>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="pagination justify-content-center">
                                <?php
                                // Tombol halaman sebelumnya
                                if ($current_page > 1) {
                                    echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page - 1) . "'>&laquo;</a></li>";
                                }

                                // Tombol halaman
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<li class='page-item " . ($i == $current_page ? 'active' : '') . "'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                                }

                                // Tombol halaman berikutnya
                                if ($current_page < $total_pages) {
                                    echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page + 1) . "'>&raquo;</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright
                            © 2017 <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap
                                Dash</a>. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="mdi mdi-heart text-danger"></i></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
        <!-- Modal untuk menampilkan pertanyaan dan jawaban -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="detailModalLabel">Detail Ulasan</h5>
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
    <script>
    $(document).ready(function() {
        $('.view-detail-btn').click(function() {
            var id = $(this).data('id');
            var tipe = (' Ulasan');
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
    <script>
    $(document).ready(function() {
        // Ketika tombol delete diklik
        $('.delete-btn').click(function() {
            var id = $(this).data('id');

            // Tampilkan konfirmasi SweetAlert
            Swal.fire({
                title: 'Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'deleteUlasanUser.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Ulasan telah dihapus.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus ulasan.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
    </script>

</body>

</html>
