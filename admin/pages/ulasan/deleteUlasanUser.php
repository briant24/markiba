<?php
include '../../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql_delete = "DELETE FROM ulasan WHERE id_ulasan = $id";
    if (mysqli_query($conn, $sql_delete)) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_close($conn);
}
?>
