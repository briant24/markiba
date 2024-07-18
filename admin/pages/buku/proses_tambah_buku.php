<?php
// Include file koneksi
include '../../../koneksi.php';

// Tangkap data dari form
$judul_buku = mysqli_real_escape_string($conn, $_POST['judul_buku']);
$nama_penulis = mysqli_real_escape_string($conn, $_POST['nama_penulis']);
$tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
$id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
$jenis_buku = mysqli_real_escape_string($conn, $_POST['jenis_buku']);
$sinopsis = mysqli_real_escape_string($conn, $_POST['sinopsis']);
$isbn = mysqli_real_escape_string($conn, $_POST['ISBN']);
$penerbit = mysqli_real_escape_string($conn, $_POST['id_penerbit']);
$klasifikasi = mysqli_real_escape_string($conn, $_POST['klasifikasi']);

// Tangkap data file gambar
$gambar = $_FILES['gambar']['tmp_name'];
$gambar_content = addslashes(file_get_contents($gambar));

// Query SQL untuk menambah data buku
$sql = "INSERT INTO buku (ISBN, judul_buku, nama_penulis, tahun_terbit, id_kategori, gambar, sinopsis, jenis_buku, klasifikasi, penerbit) 
        VALUES ('$isbn', '$judul_buku', '$nama_penulis', '$tahun_terbit', '$id_kategori', '$gambar_content', '$sinopsis', '$jenis_buku', '$klasifikasi', '$penerbit')";

// Eksekusi query
if (mysqli_query($conn, $sql)) {
    // Jika berhasil, redirect ke halaman daftar buku dengan status success
    header("Location: buku.php?status=success&message=Data berhasil ditambahkan");
    exit();
} else {
    // Jika terjadi kesalahan, redirect ke halaman buku dengan status error dan pesan kesalahan
    header("Location: buku.php?status=error&message=" . urlencode(mysqli_error($conn)));
    exit();
}

// Tutup koneksi
mysqli_close($conn);
?>
