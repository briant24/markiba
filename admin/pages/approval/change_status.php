<?php
include '../../../koneksi.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Prepare the SQL statement
    $sql = "UPDATE ulasan SET status = ? WHERE id_ulasan = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters and execute
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
