<?php
include '../../../koneksi.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir edit kategori
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    // Update data kategori ke database
    $query = "UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id_kategori'";

    if (mysqli_query($conn, $query)) {
        header("Location: kategori.php?status=success&message=Data kategori berhasil diupdate.");
        exit();
    } else {
        header("Location: kategori.php?status=error&message=" . mysqli_error($conn));
        exit();
    }
}

mysqli_close($conn);
?>
