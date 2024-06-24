<?php
session_start();
include '../../../koneksi.php';

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect to the login page
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $about_content = mysqli_real_escape_string($conn, $_POST['about_content']);

    // Update About Us content in the database
    $sql_update_about = "UPDATE about SET deskripsi = '$about_content' WHERE id_abt = 1";

    if (mysqli_query($conn, $sql_update_about)) {
        // Redirect to the about.php page with a success message
        header("Location: about.php?status=success&message=About Us content has been updated successfully");
        exit();
    } else {
        // Redirect to the about.php page with an error message
        header("Location: about.php?status=error&message=Error updating About Us content");
        exit();
    }
} else {
    // If the request method is not POST, redirect to the about.php page
    header("Location: about.php");
    exit();
}
?>
