<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection
    include 'koneksi.php';

    // Collect review data
    $id_buku = $_POST['id_buku']; // Assuming you pass the book ID from the form
    $isi_ulasan = $_POST['isi_ulasan'];
    $rating = $_POST['rating'];
    $username = $_SESSION['username'];
    $sesi = $_SESSION['is_admin'];
    $pic='';
    if($sesi){
        $pic='admin';
    }else{
        $pic='user';
    }

    // Insert review details into the 'ulasan' table
    $sql_ulasan = "INSERT INTO ulasan (id_buku, isi_ulasan, rating, username, pic) VALUES ('$id_buku', '$isi_ulasan', '$rating', '$username', '$pic')";
    $result_ulasan = mysqli_query($conn, $sql_ulasan);

    if ($result_ulasan) {
        // Redirect to the book list page with success message
        header("Location: detail_ulasan.php?id_buku=$id_buku");
        exit();
    } else {
        // Show an error message if review insertion fails
        header("Location: buku.php?status=error&message=" . mysqli_error($conn));
        exit();
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If the request method is not POST, redirect to the home page
    header("Location: ../../index.php");
    exit();
}
?>
