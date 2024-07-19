<?php
include '../../../koneksi.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $tipe = $_POST['tipe'];

    if($tipe === "Ulasan"){
        $table = 'ulasan';
        $id_column = 'id_ulasan';
    }else if($tipe === "Komentar"){
        $table = 'komentar_diskusi';
        $id_column = 'id_komentar';
    } else {
        echo 'error';
        exit();
    }

    $sql = "UPDATE $table SET status = '$status' WHERE $id_column = $id";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    }else{
        echo 'error';
    }

}

mysqli_close($conn);
?>
