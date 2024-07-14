<?php
include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_artikel = $_POST['id_penerbit'];
    $judul_artikel = $_POST["judul_penerbit"];
    $sumber = $_POST["tentang"];
    $penulis = $_POST["alamat"];

    $query = "UPDATE penerbit SET
                nama_penerbit='$judul_artikel',
                tentang='$sumber',
                alamat='$penulis'
              WHERE id='$id_artikel'";

    if (mysqli_query($conn, $query)) {
        header("Location: penerbit.php?id_penerbit=$id_artikel&status=success&message=Data berhasil diupdate");
        exit();
    } else {
        header("Location: penerbit.php?id_penerbit=$id_artikel&status=error&message=" . mysqli_error($conn));
        exit();
    }
}

mysqli_close($conn);
?>
