<?php
header('Content-Type: application/json');
include '../koneksi.php';

$idUser = intval($_GET['id_user']);

// Query untuk mengambil kolom 'alamat' dari tabel 'user'
$sql = "SELECT alamat FROM user WHERE id = ?";
$stmt = $koneksi->prepare($sql);
if ($stmt === false) {
    echo json_encode(['error' => 'Gagal mempersiapkan statement: ' . $koneksi->error]);
    exit();
}

$stmt->bind_param('i', $idUser);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Kirim data 'alamat' dalam format JSON
    echo json_encode(['address' => $row['alamat']]);
} else {
    // Jika user tidak ditemukan, kirim pesan error
    echo json_encode(['error' => 'User dengan ID ' . $idUser . ' tidak ditemukan.']);
}

$stmt->close();
$koneksi->close();


?>