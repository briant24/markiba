<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}

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
$sheet->setCellValue('B1', 'Judul Diskusi');
$sheet->setCellValue('C1', 'Isi Komentar');
$sheet->setCellValue('D1', 'Isi Subkomentar');

// Query untuk mengambil judul diskusi, komentar, dan subkomentar
$sql = "SELECT 
            diskusi.id_diskusi,
            diskusi.isi_diskusi AS judul_diskusi,
            komentar_diskusi.isi_komentar AS isi_komentar,
            sub_komentar.isi_komentar AS isi_subkomentar
        FROM diskusi
        LEFT JOIN komentar_diskusi ON diskusi.id_diskusi = komentar_diskusi.id_diskusi
        LEFT JOIN sub_komentar ON komentar_diskusi.id_komentar = sub_komentar.id_komentar
        ORDER BY diskusi.id_diskusi, komentar_diskusi.id_komentar, sub_komentar.id_sub";

$result = mysqli_query($conn, $sql);

if ($result) {
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . ($no + 1), $no);
        $sheet->setCellValue('B' . ($no + 1), $row['judul_diskusi']);
        $sheet->setCellValue('C' . ($no + 1), $row['isi_komentar']);
        $sheet->setCellValue('D' . ($no + 1), $row['isi_subkomentar']);
        $no++;
    }
}

// Mengatur lebar kolom otomatis
foreach(range('A','D') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
// Menambahkan filter
$sheet->setAutoFilter('A1:D1');

// Mengatur format untuk judul kolom
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DDDDDD']]
];

$sheet->getStyle('A1:D1')->applyFromArray($headerStyle);
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
