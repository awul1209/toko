<?php
include '../koneksi.php';

$receiver_id = $_GET['receiver_id'];

$sql = "SELECT user_id, COUNT(*) AS unread_count FROM chats 
        WHERE seller_id='$receiver_id' AND penerima_tipe='seller' AND is_read = 0 
        GROUP BY user_id";

$stmt = $koneksi->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[$row['user_id']] = $row['unread_count'];
}

echo json_encode($notifications);
?>
