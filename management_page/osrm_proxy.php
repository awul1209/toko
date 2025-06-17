<?php
// Atur header agar browser tahu ini adalah JSON
header('Content-Type: application/json');

// Ambil path lengkap yang diminta oleh browser (contoh: /marketplace/.../osrm_proxy.php/driving/...)
$requestUri = $_SERVER['REQUEST_URI'];

// Cari posisi nama file proxy kita di dalam URL
$scriptName = 'osrm_proxy.php';
$scriptNamePosition = strpos($requestUri, $scriptName);

$osrmPathAndQuery = '';
// Jika nama file ditemukan, ambil semua teks SETELAHNYA
if ($scriptNamePosition !== false) {
    $osrmPathAndQuery = substr($requestUri, $scriptNamePosition + strlen($scriptName));
} else {
    // Jika tidak ditemukan karena alasan aneh, kirim error
    http_response_code(400);
    echo json_encode(['error' => 'Tidak bisa mem-parse request URI untuk proxy.']);
    exit();
}

// Periksa jika path kosong, yang berarti permintaan tidak valid
if (empty($osrmPathAndQuery)) {
    http_response_code(400);
    echo json_encode(['error' => 'Permintaan ke proxy tidak memiliki path OSRM.']);
    exit();
}

// Bangun URL OSRM yang benar dari path yang sudah diekstrak
// Contoh $osrmPathAndQuery: /driving/113.92,...;-6.99,...?overview=false...
$osrmUrl = 'http://router.project-osrm.org/route/v1' . $osrmPathAndQuery;

// Gunakan cURL untuk meneruskan permintaan
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $osrmUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Tangani jika cURL gagal (misal, tidak ada koneksi internet)
if(curl_errno($ch)){
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'cURL Error: ' . curl_error($ch)]);
    curl_close($ch);
    exit();
}

curl_close($ch);

// Kembalikan status HTTP dan konten yang sama persis seperti yang diberikan OSRM
http_response_code($httpcode);
echo $response;
?>