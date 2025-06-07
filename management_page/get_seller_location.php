<?php
include '../koneksi.php';

header('Content-Type: application/json');

// Cek apakah 'id_toko' ada di URL
if (!isset($_GET['id_toko']) || empty($_GET['id_toko'])) {
    echo json_encode(['error' => 'ID Toko tidak disertakan.']);
    exit();
}

// Ambil id_toko dari URL dan pastikan tipenya integer untuk keamanan
$idToko = intval($_GET['id_toko']);

// Buat query SQL menggunakan Prepared Statement untuk mencegah SQL Injection
$sql = "SELECT latlng FROM seller WHERE id = ?";

// Siapkan statement
$stmt = $koneksi->prepare($sql);
if ($stmt === false) {
    echo json_encode(['error' => 'Gagal mempersiapkan statement: ' . $koneksi->error]);
    exit();
}

// Ikat parameter 'idToko' ke placeholder '?'
// 'i' berarti tipenya adalah integer
$stmt->bind_param('i', $idToko);

// Eksekusi query
$stmt->execute();

// Dapatkan hasilnya
$result = $stmt->get_result();

// Cek jika ada baris data yang ditemukan
if ($result->num_rows > 0) {
    // Ambil baris data sebagai array asosiatif
    $row = $result->fetch_assoc();
    
    // Kirim data 'latlng' dalam format JSON
    // JavaScript Anda akan menerima objek seperti: { "latlng": "-6.200000,106.816666" }
    echo json_encode(['latlng' => $row['latlng']]);
    
} else {
    // Jika tidak ada data yang ditemukan, kirim pesan error
    echo json_encode(['error' => 'Lokasi untuk toko dengan ID ' . $idToko . ' tidak ditemukan.']);
}

// Tutup statement dan koneksi
$stmt->close();
$koneksi->close();
?>