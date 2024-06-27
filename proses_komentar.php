<?php
// pastikan ada koneksi ke database sebelumnya
include "koneksi.php"; // sesuaikan dengan nama file koneksi Anda
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isi_komentar = $_POST['isi_komentar'];
    $id_diskusi = $_POST['id_diskusi'];
    $id_user = $_SESSION['user_id'];
    $tipe = $_POST['tipe_komentar'];

    // Lakukan sanitasi input untuk mencegah SQL Injection
    $isi_komentar = mysqli_real_escape_string($conn, $isi_komentar);
    $id_diskusi = mysqli_real_escape_string($conn, $id_diskusi);

    if($tipe=="diskusi"){
        $sql = "INSERT INTO komentar_diskusi (id_diskusi, isi_komentar, id_user) VALUES ('$id_diskusi', '$isi_komentar', '$id_user')";
    }else{
        $sql = "INSERT INTO sub_komentar (id_komentar, isi_komentar, id_user) VALUES ('$id_diskusi', '$isi_komentar', '$id_user')";
    }
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array('status' => 'success'));
        exit();
    } else {
        echo json_encode(array('status' => 'failed'));
    }

    mysqli_close($conn);
}
?>
