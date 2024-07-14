<?php
include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir edit buku
    $id_buku = $_POST['id_buku'];
    $judul_buku = $_POST['judul_buku'];
    $nama_penulis = $_POST['nama_penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $id_kategori = $_POST['id_kategori'];
    $sinopsis = $_POST['sinopsis'];

    // Proses gambar
    if ($_FILES['gambar']['size'] > 0) {
        $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
        $query = "UPDATE buku SET gambar='$gambar' WHERE id_buku='$id_buku'";
        mysqli_query($conn, $query);
    }

    // Update data buku ke database
    $query = "UPDATE buku SET
                judul_buku='$judul_buku',
                nama_penulis='$nama_penulis',
                tahun_terbit='$tahun_terbit',
                id_kategori='$id_kategori',
                sinopsis='$sinopsis'
              WHERE id_buku='$id_buku'";

    if (mysqli_query($conn, $query)) {
        header("Location: buku.php?status=success&message=Data berhasil diupdate");
        exit();
    } else {
        header("Location: buku.php?status=error&message=" . mysqli_error($conn));
        exit();
    }
}

mysqli_close($conn);
?>
