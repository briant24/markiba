<?php
session_start();

include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id_admin = $_POST['id_admin'];
    $nama_admin = mysqli_real_escape_string($conn, $_POST['nama_admin']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // Validate form data (you can add more validation as needed)
    if (empty($nama_admin) || empty($username)) {
        // Redirect with an error message if required fields are empty
        header("Location: account.php?status=error&message=Nama Admin dan Username harus diisi");
        exit();
    }

    // Update the admin's profile information in the database
    $sql_update = "UPDATE admin SET nama_admin='$nama_admin', username='$username' WHERE id_admin=$id_admin";

    if (mysqli_query($conn, $sql_update)) {
        // Redirect to the profile edit page with a success message
        header("Location: account.php?status=success&message=Profil berhasil diperbarui");
        exit();
    } else {
        // Redirect with an error message if the update fails
        header("Location: account.php?status=error&message=Terjadi kesalahan. Silakan coba lagi");
        exit();
    }
} else {
    // If the form is not submitted using POST method, redirect to the edit profile page
    header("Location: account.php");
    exit();
}
?>
