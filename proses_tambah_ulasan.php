<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection
    include 'koneksi.php';

    // Collect review data
    $id_buku = $_POST['id_buku']; // Assuming you pass the book ID from the form
    $jawaban1 = $_POST['answers'][0];
    $jawaban2 = $_POST['answers'][1];
    $jawaban3 = $_POST['answers'][2];
    $jawaban4 = $_POST['answers'][3];
    $jawaban5 = $_POST['answers'][4];
    $rating = $_POST['rating'];
    $username = $_SESSION['username'];

    // Insert review details into the 'ulasan' table
    $sql_ulasan = "INSERT INTO ulasan (id_buku, jawab_1, jawab_2, jawab_3, jawab_4, jawab_5, rating, username) VALUES ('$id_buku', '$jawaban1', '$jawaban2', '$jawaban3', '$jawaban4', '$jawaban5', '$rating', '$username')";
    $result_ulasan = mysqli_query($conn, $sql_ulasan);

    if ($result_ulasan) {
        $_SESSION['tambah_ulasan'] = 'success';
        header("Location: detail_ulasan.php?id_buku=$id_buku");
        exit();
    } else {
        $_SESSION['tambah_ulasan'] = 'failed';
        header("Location: detail_ulasan.php?id_buku=$id_buku");
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
