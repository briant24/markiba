<?php
include '../../../koneksi.php'; // Your database connection

// Fetch data from the admin table
$sql = "SELECT * FROM admin WHERE role='Admin'"; // Replace with your table and query
$result = mysqli_query($conn, $sql);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    echo '<table class="table table-bordered table-hover">';
    echo '<thead class="thead-dark"><tr><th>ID</th><th>Nama</th><th>Username</th></tr></thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['id_admin'] . '</td>';
        echo '<td>' . $row['nama_admin'] . '</td>';
        echo '<td>' . $row['username'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p class="text-center">No admins found.</p>';
}

// Close the database connection
mysqli_close($conn);
?>
