<?php
include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir tambah kategori
    $nama_kategori = $_POST['nama_kategori'];

    // Query SQL untuk menambah data kategori
    $sql = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";

    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, redirect ke halaman kategori atau halaman lain yang diinginkan
        header("Location: kategori.php?status=success&message=Data kategori berhasil ditambahkan.");
        exit();
    } else {
        // Jika terjadi kesalahan, redirect dengan pesan kesalahan
        header("Location: kategori.php?status=error&message=" . mysqli_error($conn));
        exit();
    }
}

// Tutup koneksi
mysqli_close($conn);
?>
