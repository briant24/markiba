<?php
// Include koneksi
include '../../../koneksi.php';
require_once('../../../vendor/autoload.php'); // Sesuaikan path autoload.php sesuai struktur proyek Anda
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Judul Buku');
$sheet->setCellValue('C1', 'Isi Diskusi');
$sheet->setCellValue('D1', 'Jumlah Suka');
$sheet->setCellValue('E1', 'Jumlah Komentar');
$sheet->setCellValue('F1', 'Jumlah Subkomentar');

// Query data
$sql = "SELECT 
        buku.judul_buku,
        diskusi.isi_diskusi,
        COUNT(suka_diskusi.id_diskusi) AS jumlah_suka,
        COUNT(komentar_diskusi.id_komentar) AS jumlah_komentar,
        SUM(CASE WHEN sub_komentar.id_komentar IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_subkomentar
        FROM buku
        LEFT JOIN diskusi ON buku.id_buku = diskusi.id_buku
        LEFT JOIN suka_diskusi ON diskusi.id_diskusi = suka_diskusi.id_diskusi
        LEFT JOIN komentar_diskusi ON diskusi.id_diskusi = komentar_diskusi.id_diskusi
        LEFT JOIN sub_komentar ON komentar_diskusi.id_komentar = sub_komentar.id_komentar
        GROUP BY buku.id_buku, diskusi.id_diskusi
        ORDER BY buku.id_buku ASC, diskusi.id_diskusi ASC";

$result = mysqli_query($conn, $sql);

if ($result) {
    $rowNumber = 2; // Mulai dari baris kedua
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . $rowNumber, $rowNumber - 1);
        $sheet->setCellValue('B' . $rowNumber, $row['judul_buku']);
        $sheet->setCellValue('C' . $rowNumber, $row['isi_diskusi']);
        $sheet->setCellValue('D' . $rowNumber, $row['jumlah_suka']);
        $sheet->setCellValue('E' . $rowNumber, $row['jumlah_komentar']);
        $sheet->setCellValue('F' . $rowNumber, $row['jumlah_subkomentar']);
        $rowNumber++;
    }
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
$filename = 'data_diskusi_' . date('Ymd') . '.xlsx';

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