<?php

// Pagination
$data_per_halaman = 16;
$query_jumlah_data = mysqli_query($koneksi, "SELECT COUNT(*) AS total from produk");
$row_jumlah_data = mysqli_fetch_assoc($query_jumlah_data);
$total_data = $row_jumlah_data['total'];
$total_halaman = ceil($total_data / $data_per_halaman);
$halaman_saat_ini = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
$mulai_data = ($halaman_saat_ini - 1) * $data_per_halaman;

// Pencarian
if (isset($_POST['cari'])) {
    $produk = $_POST['produk'];

    $produk = mysqli_real_escape_string($koneksi, $produk);

    $query_produk = "SELECT 
  p.id,
  p.produk,
  p.deskripsi,
  p.kategori,
  p.harga,
  p.stock,
  p.diskon,
  p.gambar1,
  p.gambar2,
  p.gambar3,
  s.id AS seller_id,
  s.nama_toko,
  FORMAT(COALESCE(u.avg_rating, 0), 1) AS rating,
  COALESCE(penjualan.total_terjual, 0) AS jml_terjual
FROM produk p
JOIN seller s ON p.seller_id = s.id

-- Subquery untuk hitung jumlah terjual
LEFT JOIN (
  SELECT produk_id, SUM(quantity) AS total_terjual
  FROM pesanan
  GROUP BY produk_id
) AS penjualan ON penjualan.produk_id = p.id

-- Subquery untuk hitung rating
LEFT JOIN (
  SELECT produk_id, AVG(rating) AS avg_rating
  FROM ulasan
  GROUP BY produk_id
) AS u ON u.produk_id = p.id  WHERE 1=1 "; // Inisialisasi query


        $query_produk .= "AND produk LIKE '%$produk%' OR kategori LIKE '%$produk%' ";


    $query_produk .= "GROUP BY p.id ORDER BY p.id DESC LIMIT $mulai_data, $data_per_halaman"; // Tambahkan LIMIT untuk pagination

    $query_produk = mysqli_query($koneksi, $query_produk);
} else {
    $query_produk = mysqli_query($koneksi, "SELECT 
  p.id,
  p.produk,
  p.deskripsi,
  p.kategori,
  p.harga,
  p.stock,
  p.diskon,
  p.gambar1,
  p.gambar2,
  p.gambar3,
  s.id AS seller_id,
  s.nama_toko,
  FORMAT(COALESCE(u.avg_rating, 0), 1) AS rating,
  COALESCE(penjualan.total_terjual, 0) AS jml_terjual
FROM produk p
JOIN seller s ON p.seller_id = s.id

-- Subquery untuk hitung jumlah terjual
LEFT JOIN (
  SELECT produk_id, SUM(quantity) AS total_terjual
  FROM pesanan
  GROUP BY produk_id
) AS penjualan ON penjualan.produk_id = p.id

-- Subquery untuk hitung rating
LEFT JOIN (
  SELECT produk_id, AVG(rating) AS avg_rating
  FROM ulasan
  GROUP BY produk_id
) AS u ON u.produk_id = p.id

ORDER BY p.id DESC LIMIT $mulai_data, $data_per_halaman");
}
?>

<form action="" method="post">
    <div class="search input-group mb-3">
        <div class="input-group cari">
            <input type="text" class="form-control" name="produk" placeholder="search produk" aria-label="search produk"
                aria-describedby="basic-addon2">
            <button class="input-group-text btn" type="submit" name="cari" style="background-color:#3498DB; color:white;">search..</button>
            <a href="index.php?page=produk">
                <button class="btn ms-1" style="background-color:#3498DB; color:white;">All</button>
            </a>
        </div>
    </div>
</form>

<h2 id="h2" class="text-center">Produk</h2>

<div class="produk-kotak">
    <?php
    while ($row = mysqli_fetch_assoc($query_produk)) {
        ?>

      <div class="card produk-card">
                <img src="assets/img/produk/<?= $row['gambar1'] ?>" class="card-img-top" alt="Product Name">
                <?php
                if ($row['diskon'] != 0) {
                    echo '<span class="discount-badge">' . $row['diskon'] . '% OFF</span>';
                }
                else{
                echo '';
                }
               ?>
                <div class="card-body">
                <a href="index.php?page=detail&kode=<?= $row['id'] ?>" style="text-decoration:none; color:black;">
                    <p class="card-title-toko"><?= $row['nama_toko'] ?></p>
                    <p class="card-title-toko"><?= $row['produk'] ?></p>
                    <p class="card-title"><b><?= $row['harga'] ?></b></p>
                    <p style="font-size: 0.8em;" class="card-info">⭐ <?= $row['rating'] ?> / 5 | Terjual: <?= $row['jml_terjual'] ?> pcs</p>
                </a>
                </div>
            </div>
    <?php } ?>
</div>

<div id="kotak-pagination">
    <nav aria-label="Page navigation example"  style="display: flex; justify-content: center; margin-bottom:20px;">
        <ul class="pagination">
            <?php if ($halaman_saat_ini > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=produk&halaman=<?= $halaman_saat_ini - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } ?>
    
            <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>
                <li class="page-item <?= ($i == $halaman_saat_ini) ? 'active' : '' ?>">
                    <a style="background-color:#3498DB; color:white; border:none;" class="page-link" href="?page=produk&halaman=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>
    
            <?php if ($halaman_saat_ini < $total_halaman) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=produk&halaman=<?= $halaman_saat_ini + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>