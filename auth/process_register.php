<?php
// Include database connection file
include '../koneksi.php';

// Collect form data
$username = mysqli_real_escape_string($conn, $_POST['username']);
$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
$profilePicName = '';
// Hash password before saving to database (for security)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
if ($_FILES['profilePic']['size'] > 0) {
    $profilePicTmpName = $_FILES['profilePic']['tmp_name'];
    // Read the uploaded file content
    $profilePicContent = addslashes(file_get_contents($profilePicTmpName)); // Escape special characters
    // Insert user data including profile picture as blob
    $insert_query = "INSERT INTO users (username, email, nama_user, password, tgl_lahir, photo) 
                     VALUES ('$username', '$email', '$fullname', '$hashed_password', '$birthdate', '$profilePicContent')";
    if (mysqli_query($conn, $insert_query)) {
        echo "<script>
                if (confirm('Registrasi Berhasil.')) {
                  window.location.href = 'login.php';
                } else {
                  window.location.href = 'register.php'; // Redirect to registration page again if Cancel is clicked
                }
              </script>";
    } else {
        // Error handling for database query
        echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Error: Foto profil tidak diunggah.";
}
// Close database connection
mysqli_close($conn);
?>