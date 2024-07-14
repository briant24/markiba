<?php
include '../../../koneksi.php';

// Ambil ID artikel dari parameter URL
$id_artikel = $_GET['id_penerbit'];

// Query untuk menghapus artikel berdasarkan ID
$sql = "DELETE FROM penerbit WHERE id = $id_artikel";

// Eksekusi query
if (mysqli_query($conn, $sql)) {
    // Jika penghapusan berhasil, redirect ke halaman artikel dengan pesan sukses
    header("Location: penerbit.php?status=success&message=Data berhasil dihapus");
    exit();
} else {
    // Jika terjadi kesalahan, redirect ke halaman artikel dengan pesan kesalahan
    header("Location: penerbit.php?status=error&message=" . mysqli_error($conn));
    exit();
}

// Tutup koneksi
mysqli_close($conn);
?>
