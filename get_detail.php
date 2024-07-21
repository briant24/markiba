<?php

include 'koneksi.php';
$id = $_POST['id'];
$tipe = $_POST['tipe'];
$html = '';
include 'list_question.php';
if ($tipe === ' Ulasan') {
    $query = "SELECT ulasan.*, users.nama_user, buku.judul_buku FROM ulasan INNER JOIN users ON ulasan.username = users.username INNER JOIN buku ON ulasan.id_buku = buku.id_buku WHERE id_ulasan = $id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $html .= '<h5>Pertanyaan dan Jawaban:</h5>';
        $html .= '<ul>';
        $html .= '<li><strong>Waktu :</strong> ' . $row['tanggal'] . '</li>';
        $html .= '<li><strong>Nama :</strong> ' . $row['nama_user'] . '</li>';
        $html .= '<li><strong>Rating :</strong> ' . $row['rating'] . '</li>';
        foreach ($questions as $index => $question) {
            $html .= '<li><strong>Soal :</strong> ' . $question . '</li>';
            $html .= '<strong>Jawaban :</strong> ' . $row['jawab_' . ($index +1)] ;
            $html .= '<br>';
        }
        $html .= '</ul>';
    } else {
        $html .= 'Data tidak ditemukan.';
    }
} elseif ($tipe === ' Komentar') {
    $query = "SELECT * FROM komentar_diskusi WHERE id_komentar = $id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $html .= '<h5>Pertanyaan dan Jawaban:</h5>';
        $html .= '<ul>';
        $html .= '<li><strong>Isi Komentar:</strong> ' . $row['isi_komentar'] . '</li>';
        $html .= '</ul>';
    } else {
        $html .= 'Data tidak ditemukan.';
    }
}

echo $html;
?>
