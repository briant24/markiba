<?php
// Include file koneksi
include '../koneksi.php';

// Tangkap data dari form
$username = mysqli_real_escape_string($conn, $_POST['username']); // Sanitize user input
$password = mysqli_real_escape_string($conn, $_POST['password']); // Sanitize user input

// Cek ke tabel admin
$sql_admin = "SELECT * FROM admin WHERE username = ?";
$stmt_admin = mysqli_prepare($conn, $sql_admin);
mysqli_stmt_bind_param($stmt_admin, "s", $username);
mysqli_stmt_execute($stmt_admin);
$result_admin = mysqli_stmt_get_result($stmt_admin);

// Cek ke tabel user (saya asumsikan tabelnya bernama users)
$sql_user = "SELECT * FROM users WHERE username = ?";
$stmt_user = mysqli_prepare($conn, $sql_user);
mysqli_stmt_bind_param($stmt_user, "s", $username);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);

// Periksa hasil query untuk admin
if ($result_admin) {
    // Periksa jumlah baris yang ditemukan
    if (mysqli_num_rows($result_admin) == 1) {
        // Ambil data admin
        $admin = mysqli_fetch_assoc($result_admin);

        // Verifikasi password untuk admin (tanpa hash)
        if ($password == $admin['password']) {
            // Login berhasil sebagai admin
            session_start();

            // Simpan informasi admin dalam session
            $_SESSION['user_id'] = $admin['id_admin']; // Sesuaikan dengan nama kolom yang tepat
            $_SESSION['username'] = $admin['username'];
            $_SESSION['nama'] = $admin['nama_admin'];
            $_SESSION['usia'] = 9999;
            $_SESSION['is_admin'] = true;

            // Redirect ke halaman dashboard admin
            header("Location: ../admin/index.php");
            exit();
        }
    }
}

// Periksa hasil query untuk user
if ($result_user) {
    // Periksa jumlah baris yang ditemukan
    if (mysqli_num_rows($result_user) == 1) {
        // Ambil data user
        $user = mysqli_fetch_assoc($result_user);

        // Verifikasi password untuk user (dengan password_hash)
        if (password_verify($password, $user['password'])) {
            // Login berhasil sebagai user
            session_start();
            $tanggal_lahir = $user['tgl_lahir'];
            $umur = DateTime::createFromFormat('Y-m-d', $tanggal_lahir)
            ->diff(new DateTime('today'))
            ->y;


            // Simpan informasi user dalam session
            $_SESSION['user_id'] = $user['id']; // Sesuaikan dengan nama kolom yang tepat
            $_SESSION['username'] = $user['username'];
            $_SESSION['usia'] = $umur;
            $_SESSION['nama'] = $user['nama_user'];
            $_SESSION['is_admin'] = false;

            // Redirect ke halaman dashboard user
            header("Location: ../index.php");
            exit();
        }
    }
}

// Jika tidak ada yang cocok (login gagal)
header("Location: login.php?error=InvalidCredentials");
exit();

// Tutup koneksi
mysqli_stmt_close($stmt_admin);
mysqli_stmt_close($stmt_user);
mysqli_close($conn);
?>
