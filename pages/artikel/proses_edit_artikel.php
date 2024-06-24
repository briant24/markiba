<?php
include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the edit article form
    $id_artikel = $_POST['id_artikel'];
    $judul_artikel = $_POST['judul_artikel'];
    $sumber = $_POST['sumber'];
    $penulis = $_POST['penulis'];
    $tanggal = $_POST['tanggal'];
    $isi_artikel = $_POST['isi_artikel'];

    // Process image if provided
    if ($_FILES['gambar']['size'] > 0) {
        $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
        $query = "UPDATE artikel SET gambar='$gambar' WHERE id_artikel='$id_artikel'";
        mysqli_query($conn, $query);
    }

    // Update article data in the database
    $query = "UPDATE artikel SET
                judul_artikel='$judul_artikel',
                sumber='$sumber',
                penulis='$penulis',
                tanggal='$tanggal',
                isi_artikel='$isi_artikel'
              WHERE id_artikel='$id_artikel'";

    if (mysqli_query($conn, $query)) {
        header("Location: artikel.php?id_artikel=$id_artikel&status=success&message=Data berhasil diupdate");
        exit();
    } else {
        header("Location: artikel.php?id_artikel=$id_artikel&status=error&message=" . mysqli_error($conn));
        exit();
    }
}

mysqli_close($conn);
?>
