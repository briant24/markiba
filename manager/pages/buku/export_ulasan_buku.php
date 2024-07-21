<?php
include '../../../koneksi.php';
require_once('../../../vendor/autoload.php'); // Sesuaikan dengan lokasi autoload.php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$id = $_GET['id']; // ID buku yang ingin diekspor ulasannya
$html = '';

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Waktu');
$sheet->setCellValue('C1', 'Nama User');
$sheet->setCellValue('D1', 'Judul Buku');
$sheet->setCellValue('E1', 'Rating');
$sheet->setCellValue('F1', 'Jawaban Ulasan');

// Query data ulasan buku
$query = "SELECT ulasan.*, users.nama_user, buku.judul_buku 
          FROM ulasan 
          INNER JOIN users ON ulasan.username = users.username 
          INNER JOIN buku ON ulasan.id_buku = buku.id_buku 
          WHERE ulasan.id_buku = $id";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $rowNumber = 2; // Mulai dari baris kedua
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . $rowNumber, $rowNumber - 1);
        $sheet->setCellValue('B' . $rowNumber, $row['tanggal']);
        $sheet->setCellValue('C' . $rowNumber, $row['nama_user']);
        $sheet->setCellValue('D' . $rowNumber, $row['judul_buku']);
        $sheet->setCellValue('E' . $rowNumber, $row['rating']);
        $jawaban = '';
        for ($i = 1; $i <= 5; $i++) {
            $jawaban .= $row['jawab_' . $i];
            if ($i < 5) {
                $jawaban .= ', ';
            }
        }
        $sheet->setCellValue('F' . $rowNumber, $jawaban);

        $rowNumber++;
    }
} else {
    $sheet->setCellValue('A2', 'Data tidak ditemukan.');
}

// Mengatur lebar kolom otomatis
foreach(range('A','F') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Menambahkan filter
$sheet->setAutoFilter('A1:F1');

// Mengatur format untuk judul kolom
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DDDDDD']]
];

$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

// Set judul file Excel
$filename = 'Ulasan_Buku_' . $id . '_' . date('Ymd') . '.xlsx';

// Set header untuk download file (mime type)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Menulis Spreadsheet ke file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Tutup koneksi
mysqli_close($conn);
?>
