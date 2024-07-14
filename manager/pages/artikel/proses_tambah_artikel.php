<?php
// Include your database connection file
include '../../../koneksi.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $judul_artikel = $_POST["judul_artikel"];
    $sumber = $_POST["sumber"];
    $penulis = $_POST["penulis"];
    $tanggal = $_POST["tanggal"];
    $isi_artikel = $_POST["isi_artikel"];

    // Tangkap data file gambar
    $gambar = $_FILES['gambar']['tmp_name'];
    $gambar_content = addslashes(file_get_contents($gambar));

    // Insert data into the database using prepared statement
    $sql = "INSERT INTO artikel (judul_artikel, sumber, penulis, tanggal, isi_artikel, gambar) 
            VALUES ('$judul_artikel', '$sumber', '$penulis', '$tanggal', '$isi_artikel', '$gambar_content')";

    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, redirect ke halaman daftar artikel dengan status success
        header("Location: artikel.php?status=success&message=Data berhasil ditambahkan");
        exit();
    } else {
        // Jika terjadi kesalahan, redirect ke halaman artikel dengan status error dan pesan kesalahan
        header("Location: artikel.php?status=error&message=" . mysqli_error($conn));
        exit();
    }

} else {
    // Redirect to the article page if the form is not submitted
    header("Location: artikel.php");
    exit();
}

// Close the database connection (if needed)
mysqli_close($conn);
?>
