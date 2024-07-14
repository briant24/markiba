<?php
include '../../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    // Handle file upload
    if ($_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_content = addslashes(file_get_contents($gambar_tmp));
        $query = "UPDATE kategori SET nama_kategori='$nama_kategori', gambar='$gambar_content' WHERE id_kategori='$id_kategori'";
    } else {
        // If no new image is uploaded, update only the category name
        $query = "UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id_kategori'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: kategori.php?status=success&message=Kategori berhasil diupdate.");
        exit();
    } else {
        header("Location: kategori.php?status=error&message=Gagal mengupdate kategori.");
        exit();
    }
} else {
    header("Location: kategori.php?status=error&message=Metode request tidak valid.");
    exit();
}
?>
