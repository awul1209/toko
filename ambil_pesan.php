<?php
include 'koneksi.php';

$user_id = $_GET['user_id'];
$seller_id = $_GET['seller_id'];

// Menggunakan prepared statement untuk query yang lebih aman
$query = "SELECT * FROM chats WHERE (user_id=? AND seller_id=?) OR (user_id=? AND seller_id=?) ORDER BY waktu_kirim ASC";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "iiii", $user_id, $seller_id, $seller_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$messages = array();
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
