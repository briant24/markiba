<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect to the login page
    exit();
}

include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $id_buku = $_POST['id_buku'];
    $isi_ulasan = $_POST['isi_ulasan'];
    $rating = $_POST['rating'];

    // Perform the update query
    $sql = "UPDATE ulasan SET isi_ulasan = '$isi_ulasan', rating = '$rating' WHERE id_buku = $id_buku";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the book page after successful update
        header("Location: buku.php?id_buku=$id_buku");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Redirect if the form is not submitted using POST method
    header("Location: buku.php");
    exit();
}
?>
