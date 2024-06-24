<?php
include '../../../koneksi.php';

// Ambil ID artikel dari parameter URL
$id_artikel = $_GET['id_artikel'];

// Query untuk menghapus artikel berdasarkan ID
$sql = "DELETE FROM artikel WHERE id_artikel = $id_artikel";

// Eksekusi query
if (mysqli_query($conn, $sql)) {
    // Jika penghapusan berhasil, redirect ke halaman artikel dengan pesan sukses
    header("Location: artikel.php?status=success&message=Data berhasil dihapus");
    exit();
} else {
    // Jika terjadi kesalahan, redirect ke halaman artikel dengan pesan kesalahan
    header("Location: artikel.php?status=error&message=" . mysqli_error($conn));
    exit();
}

// Tutup koneksi
mysqli_close($conn);
?>
