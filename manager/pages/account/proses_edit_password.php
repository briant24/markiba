<?php
session_start();
include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id_admin = $_POST['id_admin'];
    $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Validate form data
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        header("Location: edit_password.php?id_admin=$id_admin&status=error&message=Semua kolom harus diisi.");
        exit();
    }

    // Verify the old password (you should enhance this validation)
    // For example, you might fetch the current hashed password from the database and compare it
    // For educational purposes, I'm assuming a simple comparison
    $username = $_SESSION['username'];
    $sql_check_password = "SELECT * FROM admin WHERE username = '$username' AND password = '$old_password'";
    $result_check_password = mysqli_query($conn, $sql_check_password);

    if (!$result_check_password || mysqli_num_rows($result_check_password) !== 1) {
        header("Location: edit_password.php?id_admin=$id_admin&status=error&message=Password lama tidak benar.");
        exit();
    }

    // Check if the new password matches the confirmation
    if ($new_password !== $confirm_password) {
        header("Location: edit_password.php?id_admin=$id_admin&status=error&message=Password baru dan konfirmasi password tidak sesuai.");
        exit();
    }

    // Update the admin's password in the database
    $sql_update_password = "UPDATE admin SET password = '$new_password' WHERE id_admin = $id_admin";
    $result_update_password = mysqli_query($conn, $sql_update_password);

    if ($result_update_password) {
        header("Location: account.php?id_admin=$id_admin&status=success&message=Password berhasil diperbarui.");
        exit();
    } else {
        header("Location: edit_password.php?id_admin=$id_admin&status=error&message=Terjadi kesalahan saat memperbarui password.");
        exit();
    }
} else {
    // If the form is not submitted using POST method, redirect to the edit profile page
    header("Location: edit_password.php?id_admin=$id_admin");
    exit();
}
?>
