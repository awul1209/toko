<?php
include 'koneksi.php';
// Menangani kategori yang dipilih
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Query berdasarkan kategori
if ($kategori) {
    $query_produk = mysqli_query($koneksi, "
        SELECT 
            seller.nama_toko, 
            seller.id, 
            produk.id , 
            produk.produk, 
            produk.deskripsi, 
            produk.kategori, 
            produk.harga, 
            produk.stock, 
            produk.diskon, 
            produk.gambar1, 
            produk.gambar2, 
            produk.gambar3, 
            COALESCE(AVG(ulasan.rating), 0) AS rating, 
            COALESCE(SUM(DISTINCT pesanan.quantity), 0) AS jml_terjual 
        FROM produk 
        JOIN seller ON produk.seller_id = seller.id 
        LEFT JOIN pesanan ON pesanan.produk_id = produk.id 
        LEFT JOIN transaksi ON transaksi.pesanan_id = pesanan.id 
        LEFT JOIN ulasan ON produk.id = ulasan.produk_id 
        WHERE produk.kategori = '$kategori' 
        GROUP BY produk.id 
        LIMIT 4
    ");
} else {
  $query_produk = mysqli_query($koneksi, "SELECT seller.nama_toko, seller.id, produk.id, produk.produk, produk.deskripsi, produk.kategori, produk.harga, produk.stock, produk.diskon, produk.gambar1, produk.gambar2, produk.gambar3,  COALESCE(AVG(ulasan.rating), 0) AS rating, 
  COALESCE(SUM(DISTINCT pesanan.quantity), 0) AS jml_terjual  FROM produk JOIN seller ON produk.seller_id = seller.id LEFT JOIN pesanan ON pesanan.produk_id = produk.id LEFT JOIN transaksi ON transaksi.pesanan_id = pesanan.id LEFT JOIN ulasan ON produk.id = ulasan.produk_id GROUP BY produk.id LIMIT 4");
}

// Menampilkan hasil produk
while ($row = mysqli_fetch_assoc($query_produk)) {
  echo '<div class="card p1">';
  echo '<a href="?page=detail&kode=' . $row['id'] . '"><img src="assets/img/produk/' . $row['gambar1'] . '" class="card-img-top" alt="..."></a>';
  
  if ($row['diskon'] != 0) {
      echo '<span class="discount-badge">' . $row['diskon'] . '% OFF</span>';
  }
  else{
    echo '';
  }
  
  echo '<div class="card-body">';
  echo '<a href="?page=detail&kode=' . $row['id'] . '"><p class="card-title">' .$row['nama_toko'] . '</p></a>';
  echo '<a href="?page=detail&kode=' . $row['id'] . '"><p class="card-title">' . $row['produk'] . '</p></a>';
  echo '<a href="?page=detail&kode=' . $row['id'] . '"><p class="card-text"><b>' . $row['harga'] . '</b></p></a>';
  echo '<p style="font-size: 0.8em;" class="card-info">⭐ ' .$row['rating']. ' / 5 | Terjual: ' .$row['jml_terjual']. ' pcs</p>';
  echo '</div>';
  echo '</div>';
}

?>
         <!-- <a href="?page=detail&id=' . $row['id'] . '"></a> -->