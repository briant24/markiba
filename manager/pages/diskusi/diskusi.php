<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Markiba</title>
    <link rel="stylesheet" href="../../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../node_modules/jqvmap/dist/jqvmap.min.css" />
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="shortcut icon" href="../../images/Markiba.png" />
</head>

<body>
    <div class="container-scroller">
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
                        <i class="mdi mdi-account-circle" style="font-size: 18pt; margin-right: 8px; color: #B66DFF"></i>
                        <span style="color: #B66DFF"><?php echo $_SESSION['nama']; ?></span>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <?php
            $active_page = 'diskusi';
            ?>
            <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
            <script src="../../vendors/js/vendor.bundle.base.js"></script>
            <script src="../../vendors/js/vendor.bundle.addons.js"></script>
            <script src="../../js/off-canvas.js"></script>
            <script src="../../js/misc.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('.btnEditDiskusi').click(function () {
                        var idDiskusi = $(this).data('id_diskusi');
                        var isiDiskusi = $(this).data('isi_diskusi');
                        $('#editIdDiskusi').val(idDiskusi);
                        $('#editIsiDiskusi').val(isiDiskusi);
                        $('#modalEditDiskusi').modal('show');
                    });

                    var status = "<?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?>";
                    var message = "<?php echo isset($_GET['message']) ? $_GET['message'] : ''; ?>";
                    if (status === 'success') {
                        alert(message);
                    } else if (status === 'error') {
                        alert('Terjadi kesalahan: ' + message);
                    }
                });
                $(document).ready(function () {
                    $('.btnTambahDiskusi').click(function () {
                        var idBuku = $(this).data('id_buku');
                        $('#idBuku').val(idBuku);
                        $('#modalTambahDiskusi').modal('show');
                    });

                    var status = "<?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?>";
                    var message = "<?php echo isset($_GET['message']) ? $_GET['message'] : ''; ?>";
                    if (status === 'success') {
                        alert(message);
                    } else if (status === 'error') {
                        alert('Terjadi kesalahan: ' + message);
                    }
                });

                // Ajax untuk memuat ulang bagian tabel setelah edit
                function reloadTable() {
                    $("#tableContainer").load(location.href + " #tableContainer");
                }

                // Ajax untuk submit form edit diskusi
                $('#formEditDiskusi').submit(function (event) {
                    event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        success: function (response) {
                            $('#modalEditDiskusi').modal('hide');
                            reloadTable(); // Memuat ulang tabel setelah berhasil
                            alert('Diskusi berhasil diupdate');
                        },
                        error: function () {
                            alert('Terjadi kesalahan saat menyimpan perubahan');
                        }
                    });
                });
                $(function() {
                $("#includeHtml").load("../layout/sidebar.html");
                });
            </script>
            <div id="includeHtml"></div>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            Diskusi
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Diskusi</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Daftar Diskusi</li>
                            </ol>
                        </nav>
                    </div>

                    <?php
                    include '../../../koneksi.php';
                    $sql = "SELECT 
                            buku.id_buku,
                            buku.judul_buku,
                            buku.nama_penulis,
                            buku.tahun_terbit,
                            buku.gambar,
                            buku.sinopsis,
                            kategori.nama_kategori,
                            diskusi.id_diskusi,
                            diskusi.isi_diskusi,
                            COUNT(komentar_diskusi.id_komentar) AS jumlah_komentar
                            FROM buku
                            LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori
                            LEFT JOIN diskusi ON buku.id_buku = diskusi.id_buku
                            LEFT JOIN komentar_diskusi ON diskusi.id_diskusi = komentar_diskusi.id_diskusi
                            GROUP BY buku.id_buku, diskusi.id_diskusi
                            ORDER BY buku.id_buku ASC, diskusi.id_diskusi ASC;";
                    $result = mysqli_query($conn, $sql);
                    ?>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title">Daftar Diskusi</h4>
                                            <p class="card-description">Data diskusi dari tabel buku, diskusi, dan
                                                komentar</p>
                                        </div>
                                        <div class="text-right">
                                            <a href="export_diskusi.php" class="btn btn-success btn-sm mdi mdi-file-excel">Download Data</a>
                                        </div>
                                    </div>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul Buku</th>
                                                <th>Diskusi</th>
                                                <th>Komentar</th>
                                                <th>Ulasan</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result) {
                                                $no = 0;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $no++;
                                                    echo "<tr>";
                                                    echo "<td>" . $no . "</td>";
                                                    echo "<td>" . $row['judul_buku'] . "</td>";
                                                    if (!empty($row['isi_diskusi'])) {
                                                        echo "<td>" . $row['isi_diskusi'] . "</td>";
                                                    } else {
                                                        echo "<td>-</td>";
                                                    }
                                                    echo "<td>" . $row['jumlah_komentar'] . "</td>";
                                                    $reviewButton = "<a href='../../../detail_ulasan.php?id_buku=" . $row['id_buku'] . "' class='btn btn-info btn-sm'>Lihat Diskusi</a>";
                                                    $downloadButton = "<a href='export_diskusi_by_book.php?id_buku=". $row['id_buku']."' class='btn btn-success btn-sm mdi mdi-file-excel'></a>";
                                                    echo "<td>" . $reviewButton . "</td>";
                                                    echo "<td>" . $downloadButton . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>Error: " . mysqli_error($conn) . "</td></tr>";
                                            }
                                            mysqli_close($conn);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                                2017 <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap Dash</a>. All
                                rights reserved.</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &
                                made with <i class="mdi mdi-heart text-danger"></i></span>
                        </div>
                    </footer>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Diskusi -->
        <div class="modal fade" id="modalTambahDiskusi" tabindex="-1" role="dialog"
            aria-labelledby="modalTambahDiskusiLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahDiskusiLabel">Tambah Diskusi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="proses_tambah_diskusi.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" id="idBuku" name="idBuku">
                            <input type="hidden" id="idAdmin" name="idAdmin"
                                value="<?php echo $_SESSION['user_id']; ?>">
                            <div class="form-group">
                                <label for="isiDiskusi">Isi Diskusi</label>
                                <textarea class="form-control" id="isiDiskusi" name="isiDiskusi" rows="3"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Diskusi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Diskusi -->
        <div class="modal fade" id="modalEditDiskusi" tabindex="-1" role="dialog"
            aria-labelledby="modalEditDiskusiLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditDiskusiLabel">Edit Diskusi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formEditDiskusi" action="proses_edit_diskusi.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" id="editIdDiskusi" name="editIdDiskusi">
                            <div class="form-group">
                                <label for="editIsiDiskusi">Isi Diskusi</label>
                                <textarea class="form-control" id="editIsiDiskusi" name="editIsiDiskusi" rows="3"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
