<?php
session_start();

include('koneksi.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $profile_data = array(
            'nama_user' => $row['nama_user'],
            'photo_blob' => base64_encode($row['photo']),
            'tanggal_lahir' => $row['tgl_lahir']
        );
        header('Content-Type: application/json');
        echo json_encode($profile_data);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'Profil pengguna tidak ditemukan'));
    }
} else {
    http_response_code(403);
    echo json_encode(array('message' => 'Unauthorized'));
}

$conn->close();
?>
