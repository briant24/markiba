<?php
$keyword = $_POST['keyword'];
if (empty($keyword) || is_null($keyword)) {
    echo "";
} else {
    $hasil = queryDatabase($keyword);
    $html = "";
    if (empty($hasil)) {
        $html = "<p>Tidak ada hasil ditemukan</p>";
    } else {
        foreach($hasil as $row) {
            $html .= "<p data-id='" . $row['id_buku'] . "'>" . $row['judul_buku'] . " - " . $row['nama_penulis'] . "</p>";
        }
    }
    echo $html;
}

function queryDatabase($keyword){
    include 'koneksi.php';
    // prepared statement untuk mencegah SQL injection
    $sql = "SELECT * FROM buku WHERE nama_penulis LIKE ? OR judul_buku LIKE ?";
    $keyword = "%$keyword%";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $keyword, $keyword);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $rows;
}
?>
