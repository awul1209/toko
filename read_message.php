<?php
include 'koneksi.php';

$user_id = $_POST['user_id'];  // ID user yang membaca pesan
$seller_id = $_POST['seller_id']; // ID seller yang mengirim pesan

$sql = "UPDATE chats SET is_read = 1 WHERE user_id = ? AND seller_id = ? AND is_read = 0";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ii", $user_id, $seller_id);
$stmt->execute();

echo json_encode(["status" => "success"]);
?>
