<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipe = $_POST['tipe'];
    $id_diskusi = $_POST['id_diskusi'];
    $id_user = $_POST['id_user'];
    include 'koneksi.php';
    if($tipe=="diskusi"){
        $sql_update_suka = "INSERT INTO suka_diskusi(id_diskusi, id_user) VALUES($id_diskusi, $id_user)";
    }else{
        $sql_update_suka = "INSERT INTO suka_komentar(id_komentar, id_user) VALUES($id_diskusi, $id_user)";
    }
    if (mysqli_query($conn, $sql_update_suka)) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Gagal menambah suka.'));
    }
    mysqli_close($conn);
}
?>
