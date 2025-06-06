<?php

ob_start();

require_once '../../vendor/autoload.php';
include '../../../koneksi.php';
$role=$_GET['role'];
$id=$_GET['id'];
if($role == 'admin'){
    if(!empty($_GET['dari']) && !empty($_GET['sampai'])){
        $dari=$_GET['dari'];
        $sampai=$_GET['sampai'];
        $data_transaksi=mysqli_query($koneksi,"SELECT pesanan.created_at as tgl_p, user.alamat,transaksi.id as id_transaksi,transaksi.created_at,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,user.email,user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id 
        JOIN user ON user.id = pesanan.user_id 
        JOIN seller ON seller.id = produk.seller_id
        JOIN transaksi ON transaksi.pesanan_id=pesanan.id
        WHERE pesanan.status='selesai' AND DATE(transaksi.created_at) BETWEEN '$dari' AND '$sampai'");
    }else{
        $data_transaksi=mysqli_query($koneksi,"SELECT pesanan.created_at as tgl_p, user.alamat,transaksi.id as id_transaksi,transaksi.created_at,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,user.email,user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id 
        JOIN user ON user.id = pesanan.user_id 
        JOIN seller ON seller.id = produk.seller_id
        JOIN transaksi ON transaksi.pesanan_id=pesanan.id
        WHERE pesanan.status='selesai'");
    }

}else{
    if(!empty($_GET['dari']) && !empty($_GET['sampai'])){
        $dari=$_GET['dari'];
        $sampai=$_GET['sampai'];
        $data_transaksi=mysqli_query($koneksi,"SELECT pesanan.created_at as tgl_p, user.alamat,transaksi.id as id_transaksi,transaksi.created_at,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,user.email,user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id 
        JOIN user ON user.id = pesanan.user_id 
        JOIN seller ON seller.id = produk.seller_id
        JOIN transaksi ON transaksi.pesanan_id=pesanan.id
        WHERE pesanan.status='selesai' AND seller.id='$id' AND DATE(transaksi.created_at) BETWEEN '$dari' AND '$sampai'");
    }else{
        $data_transaksi=mysqli_query($koneksi,"SELECT pesanan.created_at as tgl_p, user.alamat,transaksi.id as id_transaksi,transaksi.created_at,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,user.email,user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id 
        JOIN user ON user.id = pesanan.user_id 
        JOIN seller ON seller.id = produk.seller_id
        JOIN transaksi ON transaksi.pesanan_id=pesanan.id
        WHERE pesanan.status='selesai'AND seller.id='$id'");
    }
}




// Buat instance MPDF dengan mode Landscape
$mpdf = new \Mpdf\Mpdf([
    'orientation' => 'L' // L = Landscape, P = Portrait (default)
]);
$periode_text = ($dari && $sampai) ? "<strong>Periode:</strong> $dari - $sampai" : "<strong>Periode:</strong> All";
// Konten HTML untuk laporan
$html = "
    <h2 style='text-align: center;'>Laporan Transaksi</h2>
     <p>$periode_text</p>
    <hr>
    <table border='1' width='100%' cellspacing='0' cellpadding='5'>
        <thead>
            <tr style='background-color: #f2f2f2;'>
                <th>No</th>
                <th>Tgl Pesan - Tgl Diterima</th>
                <th>User</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Transaksi</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>";



    $no = 1;
    foreach ($data_transaksi as $data) {
        $html .= "
            <tr>
                <td>$no</td>
                <td>{$data['tgl_p']} - {$data['created_at']}</td>
                <td>{$data['email']}</td>
                <td>{$data['produk']}</td>
                <td>{$data['quantity']}</td>
                <td>Rp " . number_format($data['price'], 0, ',', '.') . "</td>
                <td>{$data['metode']}</td>
            </tr>";
        $no++;

}

$html .= "
        </tbody>
    </table>
";

// Tambahkan HTML ke MPDF dan cetak PDF
$mpdf->WriteHTML($html);
$mpdf->Output('Laporan_Transaksi.pdf', 'I'); // 'I' = Inline (langsung tampil di browser)
?>
?>
