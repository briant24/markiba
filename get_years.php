<?php
include 'koneksi.php';

$sql = "SELECT DISTINCT tahun_terbit FROM buku ORDER BY tahun_terbit DESC";
$result = mysqli_query($conn, $sql);

$years = [];
while ($row = mysqli_fetch_assoc($result)) {
  $years[] = $row['tahun_terbit'];
}

header('Content-Type: application/json');
echo json_encode($years);
?>
