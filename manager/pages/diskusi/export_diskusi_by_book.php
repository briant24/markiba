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
$sheet->setCellValue('C1', 'Waktu');
$sheet->setCellValue('D1', 'Nama');
$sheet->setCellValue('E1', 'Isi Komentar');

// Query untuk mengambil judul diskusi, komentar, dan subkomentar
$sql = "SELECT diskusi.id_diskusi AS id, diskusi.isi_diskusi AS judul_diskusi,
komentar_diskusi.waktu AS waktu, users.nama_user AS nama, komentar_diskusi.isi_komentar 
AS isi_komentar FROM diskusi INNER JOIN komentar_diskusi ON diskusi.id_diskusi = komentar_diskusi.id_diskusi 
INNER JOIN users ON komentar_diskusi.id_user = users.id";

$result = mysqli_query($conn, $sql);

if ($result) {
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . ($no + 1), $no);
        $sheet->setCellValue('B' . ($no + 1), $row['judul_diskusi']);
        $sheet->setCellValue('C' . ($no + 1), $row['waktu']);
        $sheet->setCellValue('D' . ($no + 1), $row['nama']);
        $sheet->setCellValue('E' . ($no + 1), $row['isi_komentar']);
        $no++;
    }
}

// Mengatur lebar kolom otomatis
foreach(range('A','E') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
// Menambahkan filter
$sheet->setAutoFilter('A1:E1');

// Mengatur format untuk judul kolom
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DDDDDD']]
];

$sheet->getStyle('A1:E1')->applyFromArray($headerStyle);
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
