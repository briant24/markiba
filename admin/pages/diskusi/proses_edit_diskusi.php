<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../../../koneksi.php';

    $idDiskusi = $_POST['editIdDiskusi'];
    $isiDiskusi = $_POST['editIsiDiskusi'];

    $sql = "UPDATE diskusi SET isi_diskusi = '$isiDiskusi' WHERE id_diskusi = '$idDiskusi'";

    if (mysqli_query($conn, $sql)) {
        $status = 'success';
        $message = 'Diskusi berhasil diupdate';
    } else {
        $status = 'error';
        $message = 'Terjadi kesalahan saat mengupdate diskusi: ' . mysqli_error($conn);
    }
    mysqli_close($conn);

    header("Location: diskusi.php?status=$status&message=" . urlencode($message));
    exit();
} else {
    header("Location: diskusi.php");
    exit();
}
?>
