<?php
include '../../../koneksi.php';

// Check if the id parameter is set
if (isset($_GET['id'])) {
    $id_kategori = $_GET['id'];

    // Hapus data kategori dari database
    $query = "DELETE FROM kategori WHERE id_kategori='$id_kategori'";

    if (mysqli_query($conn, $query)) {
        header("Location: kategori.php?status=success&message=Data kategori berhasil dihapus.");
        exit();
    } else {
        header("Location: kategori.php?status=error&message=" . mysqli_error($conn));
        exit();
    }
} else {
    header("Location: kategori.php?status=error&message=ID kategori tidak valid.");
    exit();
}

mysqli_close($conn);
?>
