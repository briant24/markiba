<?php
include '../../../koneksi.php';

// Load PHPExcel library
require_once('../../../vendor/autoload.php'); // Adjust the path based on your project structure
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Judul Buku');
$sheet->setCellValue('C1', 'Nama Penulis');
$sheet->setCellValue('D1', 'Tahun Terbit');
$sheet->setCellValue('E1', 'Kategori');
$sheet->setCellValue('F1', 'Rating');
$sheet->setCellValue('G1', 'Sinopsis');

// Query data buku
$sql = "SELECT DISTINCT buku.id_buku, buku.judul_buku, buku.nama_penulis, buku.tahun_terbit, 
               buku.sinopsis, kategori.nama_kategori,
               MAX(ulasan.isi_ulasan) AS isi_ulasan, MAX(ulasan.rating) AS rating
        FROM buku
        INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori
        LEFT JOIN ulasan ON buku.id_buku = ulasan.id_buku
        GROUP BY buku.id_buku";
$result = mysqli_query($conn, $sql);

if ($result) {
    $rowNumber = 2; // Mulai dari baris kedua
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . $rowNumber, $rowNumber - 1);
        $sheet->setCellValue('B' . $rowNumber, $row['judul_buku']);
        $sheet->setCellValue('C' . $rowNumber, $row['nama_penulis']);
        $sheet->setCellValue('D' . $rowNumber, $row['tahun_terbit']);
        $sheet->setCellValue('E' . $rowNumber, $row['nama_kategori']);
        $sheet->setCellValue('F' . $rowNumber, $row['rating']);
        $sheet->setCellValue('G' . $rowNumber, $row['sinopsis']);

        $rowNumber++;
    }
}
// Mengatur lebar kolom otomatis
foreach(range('A','H') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
// Menambahkan filter
$sheet->setAutoFilter('A1:H1');

// Mengatur format untuk judul kolom
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DDDDDD']]
];

$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);


// Set judul file Excel
$filename = 'Daftar Buku ' . date('Ymd') . '.xlsx';

// Set header untuk download file (mime type)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Menulis Spreadsheet ke file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Tutup koneksi
mysqli_close($conn);
