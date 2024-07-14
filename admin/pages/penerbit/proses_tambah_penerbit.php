<?php
// Include your database connection file
include '../../../koneksi.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $judul_artikel = $_POST["judul_penerbit"];
    $sumber = $_POST["tentang"];
    $penulis = $_POST["alamat"];
    // Insert data into the database using prepared statement
    $sql = "INSERT INTO penerbit (nama_penerbit, tentang, alamat) 
            VALUES ('$judul_artikel', '$sumber', '$penulis')";

    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, redirect ke halaman daftar artikel dengan status success
        header("Location: penerbit.php?status=success&message=Data berhasil ditambahkan");
        exit();
    } else {
        // Jika terjadi kesalahan, redirect ke halaman artikel dengan status error dan pesan kesalahan
        header("Location: penerbit.php?status=error&message=" . mysqli_error($conn));
        exit();
    }

} else {
    // Redirect to the article page if the form is not submitted
    header("Location: penerbit.php");
    exit();
}

// Close the database connection (if needed)
mysqli_close($conn);
?>
