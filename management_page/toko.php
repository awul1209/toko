<?php
$id=$_GET['kode'];
$query=mysqli_query($koneksi,"SELECT 
  p.id AS id_produk,
  p.produk,
  p.kategori,
  p.harga,
  p.stock,
  p.diskon,
  p.gambar1,
  p.gambar2,
  p.gambar3,
  s.id AS seller_id,
  s.nama_toko,
  s.deskripsi_toko,
  s.alamat,
  s.kontak,
  FORMAT(COALESCE(u.avg_rating, 0), 1) AS rating,
  COALESCE(jml.total_terjual, 0) AS jml_terjual
FROM produk p
JOIN seller s ON p.seller_id = s.id

-- subquery jumlah terjual
LEFT JOIN (
  SELECT produk_id, SUM(quantity) AS total_terjual
  FROM pesanan
  GROUP BY produk_id
) jml ON jml.produk_id = p.id

-- subquery rata-rata rating
LEFT JOIN (
  SELECT produk_id, AVG(rating) AS avg_rating
  FROM ulasan
  GROUP BY produk_id
) u ON u.produk_id = p.id

WHERE s.id = '$id'
ORDER BY p.created_at asc;
");

$query_rating=mysqli_query($koneksi,"SELECT FORMAT(COALESCE(AVG(ulasan.rating), 0), 1) AS rating from ulasan JOIN produk ON produk.id = ulasan.produk_id JOIN seller ON seller.id= produk.seller_id where seller.id='$id'");
$roww=mysqli_fetch_assoc($query);
$rating=mysqli_fetch_assoc($query_rating);
?>
<div class="kotak-toko">
    <div class="profile"> 
        <img src="assets/img/konten/toko.png" alt="Logo Toko">
        <div class="profile-info">
            <h2>Nama Toko :<?= $roww['nama_toko'] ?></h2>
            <p style="margin-bottom:2px;">Deskripsi :<?= $roww['deskripsi_toko'] ?></p>
            <p style="margin-bottom:2px;">Alamat : <?= $roww['alamat'] ?> - (<?= $roww['kontak'] ?>)</p>
            <p style="margin-bottom:2px;">Rating : ⭐ <?= $rating['rating'] ?></p>
        </div>
    </div>


        <h2 class="produk-judul">Produk</h2>
        <div class="product-list">
            <?php
                while($row=mysqli_fetch_assoc($query)){ ?>
        <!-- Produk 2 -->
        <div class="card product">
                <img src="assets/img/produk/<?= $row['gambar1'] ?>" class="card-img-top" alt="Product Name">
               <?php
                if ($row['diskon'] != 0) {
                    echo '<span class="discount-badge">' . $row['diskon'] . '% OFF</span>';
                }
                else{
                echo '';
                }
               ?>
               <a href=""></a>
                <div class="card-body">
                <a href="index.php?page=detail&kode=<?= $row['id_produk'] ?>" style="text-decoration:none; color:black;">
                    <p class="card-text-toko"><?= $row['produk'] ?></p>
                    <p class="card-title"><b><?= $row['harga'] ?></b></p>
                    <p style="font-size: 0.8em;" class="card-info">⭐ <?= $row['rating'] ?> / 5 | Terjual: <?= $row['jml_terjual'] ?> pcs</p>
            </a>
                </div>
            </div>
              <?php  } ?>
    
        </div>

</div>