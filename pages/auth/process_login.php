<?php
// Include file koneksi
include '../../../koneksi.php';

// Tangkap data dari form
$username = mysqli_real_escape_string($conn, $_POST['username']); // Sanitize user input
$password = mysqli_real_escape_string($conn, $_POST['password']); // Sanitize user input

// Use prepared statements to prevent SQL injection
$sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Periksa hasil query
if ($result) {
    // Periksa jumlah baris yang ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Login berhasil
        session_start();

        // Simpan informasi pengguna dalam session
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama'] = $user['nama_admin']; 
        $_SESSION['id_admin'] = $user['id_admin']; // Adjust with your actual column name

        // Redirect to the dashboard or home page
        header("Location: ../../index.php");
        exit();
    } else {
        // Login gagal
        header("Location: login.php?error=InvalidCredentials");
        exit();
    }
} else {
    // Terjadi kesalahan pada query
    echo "Error: " . mysqli_error($conn);
}

// Tutup koneksi
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
