<?php
include '../koneksi.php'; // Sesuaikan dengan nama file koneksi dan struktur koneksi Anda

// Ambil nilai username dari POST request
$username = mysqli_real_escape_string($conn, $_POST['username']);

// Query untuk memeriksa keunikan username
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// Jika username sudah ada dalam database, kirimkan 'taken', jika tidak kirimkan 'available'
if (mysqli_num_rows($result) > 0) {
    echo 'taken';
} else {
    echo 'available';
}

// Tutup koneksi database
mysqli_close($conn);
?>
