<?php
session_start();

if (!isset($_SESSION['is_admin'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../../../koneksi.php';
    
    $idBuku = $_POST['idBuku'];
    $idAdmin = $_POST['idAdmin'];
    $isiDiskusi = $_POST['isiDiskusi'];
    
    $sql = "INSERT INTO diskusi (id_buku, id_admin, isi_diskusi) VALUES ('$idBuku', '$idAdmin', '$isiDiskusi')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Diskusi berhasil ditambahkan.";
        $status = "success";
    } else {
        $message = "Gagal menambahkan diskusi: " . mysqli_error($conn);
        $status = "error";
    }
    
    mysqli_close($conn);
    
    header("Location: diskusi.php?status=$status&message=" . urlencode($message));
    exit();
} else {
    header("Location: diskusi.php");
    exit();
}
?>
