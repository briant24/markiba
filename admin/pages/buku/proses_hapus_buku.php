<?php
include '../../../koneksi.php';

// Ambil ID buku dari parameter URL
$id_buku = $_GET['id'];

// Query untuk menghapus buku berdasarkan ID
$sql = "DELETE FROM buku WHERE id_buku = $id_buku";

// Eksekusi query
if (mysqli_query($conn, $sql)) {
    // Jika penghapusan berhasil, redirect ke halaman buku dengan pesan sukses
    header("Location: buku.php?status=success&message=Data berhasil dihapus");
    exit();
} else {
    // Jika terjadi kesalahan, redirect ke halaman buku dengan pesan kesalahan
    header("Location: buku.php?status=error&message=" . mysqli_error($conn));
    exit();
}

// Tutup koneksi
mysqli_close($conn);
?>
