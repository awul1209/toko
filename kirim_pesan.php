<?php
include 'koneksi.php';

if (isset($_POST['pesan'])) {
    $user_id = $_POST['user_id'];
    $seller_id = $_POST['seller_id'];
    $pesan = $_POST['pesan'];
    $pengirim_tipe = $_POST['pengirim_tipe'];
    $penerima_tipe = $_POST['penerima_tipe'];
    $gambar = '';

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = $target_file;
        }
    }

    $query = "INSERT INTO chats (user_id, seller_id, pesan, gambar, pengirim_tipe, penerima_tipe, waktu_kirim) VALUES ('$user_id', '$seller_id', '$pesan', '$gambar', '$pengirim_tipe', '$penerima_tipe', NOW())";
    $result = mysqli_query($koneksi, $query);

    $log_message = "User ID: $user_id, Seller ID: $seller_id, Pesan: $pesan, Gambar: $gambar, Query: $query, Result: " . ($result ? "Success" : "Failure") . "\n";
    file_put_contents('log.txt', $log_message, FILE_APPEND);

    if ($result) {
        echo "Pesan berhasil dikirim.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>