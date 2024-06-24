<?php
// Include file koneksi
include '../../../koneksi.php';

// Tangkap data dari form
$judul_buku = $_POST['judul_buku'];
$nama_penulis = $_POST['nama_penulis'];
$tahun_terbit = $_POST['tahun_terbit'];
$id_kategori = $_POST['id_kategori'];
$sinopsis = $_POST['sinopsis'];

// Tangkap data file gambar
$gambar = $_FILES['gambar']['tmp_name'];
$gambar_content = addslashes(file_get_contents($gambar));

// Query SQL untuk menambah data buku
$sql = "INSERT INTO buku (judul_buku, nama_penulis, tahun_terbit, id_kategori, gambar, sinopsis) 
        VALUES ('$judul_buku', '$nama_penulis', '$tahun_terbit', '$id_kategori', '$gambar_content', '$sinopsis')";

// Eksekusi query
if (mysqli_query($conn, $sql)) {
    // Jika berhasil, redirect ke halaman daftar buku dengan status success
    header("Location: buku.php?status=success&message=Data berhasil ditambahkan");
    exit();
} else {
    // Jika terjadi kesalahan, redirect ke halaman buku dengan status error dan pesan kesalahan
    header("Location: buku.php?status=error&message=" . mysqli_error($conn));
    exit();
}

// Tutup koneksi
mysqli_close($conn);
?>
