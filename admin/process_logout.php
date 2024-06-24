<?php
// Mulai sesi
session_start();

// Hancurkan semua variabel sesi
$_SESSION = array();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman lain yang diinginkan
header("Location: ../auth/login.php");
exit();
?>
