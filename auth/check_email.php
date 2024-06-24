<?php
include '../koneksi.php'; // Sesuaikan dengan nama file koneksi dan struktur koneksi Anda

// Ambil nilai email dari POST request
$email = mysqli_real_escape_string($conn, $_POST['email']);

// Query untuk memeriksa keunikan email
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

// Jika email sudah ada dalam database, kirimkan 'taken', jika tidak kirimkan 'available'
if (mysqli_num_rows($result) > 0) {
    echo 'taken';
} else {
    echo 'available';
}

// Tutup koneksi database
mysqli_close($conn);
?>
