<?php
$id=$_GET['kode'];
$query=mysqli_query($koneksi," SELECT nama_toko,alamat,seller.id as id_toko,produk.id as id_produk ,produk,deskripsi_toko,kategori,harga,stock,diskon,gambar1,gambar2,gambar3, seller.gambar, FORMAT(SUM(rating) / COUNT(ulasan.id), 1) as rating FROM produk 
JOIN seller ON produk.seller_id=seller.id 
LEFT JOIN ulasan ON produk.id=ulasan.produk_id
WHERE produk.id='$id'");
?>
<div class="kotak-detail">
    <?php 
    $row=mysqli_fetch_assoc($query);
    ?>

  <img id="mainImage" class="main-image" src="assets/img/produk/<?= $row['gambar1'] ?>" alt="Produk">
        <div class="thumbnail-container">
            <img class="thumbnail" src="assets/img/produk/<?= $row['gambar1'] ?>" alt="Thumbnail 1" onclick="changeImage(this)">
            <img class="thumbnail" src="assets/img/produk/<?= $row['gambar2'] ?>" alt="Thumbnail 2" onclick="changeImage(this)">
            <img class="thumbnail" src="assets/img/produk/<?= $row['gambar3'] ?>" alt="Thumbnail 3" onclick="changeImage(this)">
        </div>
        <div class="button-container">
            <form action="" method="post">
                <input type="hidden" name='produk' value="<?= $row['id_produk'] ?>">
                <button type="submit" name="keranjang" class="button add-to-cart">Tambah ke Keranjang</button>
            </form>
            <form action="" method="post">
            <input type="hidden" name="id_produk" value="<?= $row['id_produk'] ?>">
                <button type="submit" name="beli" class="button buy-now">Beli Sekarang</button>
            </form>
        </div>
        <div class="product-details">
            <h5><strong><?= $row['produk'] ?></strong></h5>
            <p><strong>Harga:</strong> Rp <?= $row['harga'] ?></p>
            <p><strong>Stok:</strong> <?= $row['stock'] ?></p>
            <p><strong>Rating:</strong> ⭐ <?= $row['rating'] ?> / 5</p>
            <!-- <p><strong>Rating:</strong> ⭐ <?= $row['rating'] !== null ? $row['rating'] : 0 ?> / 5</p> -->
            <div class="tokonya">
                <div class="nama-tokonya">
                    <div class="img-radius">
                <img src="./backend/assets/img/seller/<?= $row['gambar'] ?>" alt="">
                </div>
                <div class="isi">
                    <p class="nama"><strong> <?= $row['nama_toko'] ?></strong></p>
                    <p> <?= $row['alamat'] ?></p>
                </div>
                </div>
                <div class="profilnya">
                    <a href="index.php?page=toko&kode=<?= $row['id_toko'] ?>" class="text-decoration-none">
                    <div style="cursor:hand" class="badge bg-warning">Kunjungi</div>
                    </a>
                    <a href="index.php?page=chat&seller_id=<?= $row['id_toko'] ?>" class="text-decoration-none">
                    <div style="cursor:hand" class="badge bg-success">Chat</div>
                    </a>
                </div>
            </div>
            <p class="deskripsi-produk"><strong>Deskripsi:</strong> <?= $row['deskripsi_toko'] ?></p>
            <?php $komen=mysqli_query($koneksi,"SELECT * FROM ulasan WHERE produk_id='$id'");
            while ($row_komen=mysqli_fetch_assoc($komen)){
            ?>
            <div class="kotak-komen">
                <div class="komen">
                    <div class="img">
                        <img src="assets/img/konten/userr.png" alt="">
                    </div>
                    <div class="text">
                        <p><?= $row_komen['comment'] ?>. </p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <script>
        function changeImage(element) {
            document.getElementById('mainImage').src = element.src;
        }
    </script>


<?php
if(isset($_POST['keranjang'])){
    $id_produk=$_POST['produk'];
    if (empty($s_nama)) {
        echo "<script>
        Swal.fire({
            title: 'Anda Belum Terdaftar',
            text: '',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {}
        });
    </script>";
    } else {
 
    $simpan = mysqli_query($koneksi,"INSERT INTO keranjang (user_id,produk_id) VALUES ('$s_id','$id_produk')");
    if($simpan){
        echo "<script>
        Swal.fire({title: 'Keranjang',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){

            }
            })</script>";
    }
}
}

if(isset($_POST['beli'])){
    $produk_id=$_POST['id_produk'];
    if (empty($s_nama)) {
        echo "<script>
        Swal.fire({
            title: 'Anda Belum Terdaftar',
            text: '',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
            
            }
        });
    </script>";
    } else {
        echo "<script>
       window.location = '?page=transaksi&produk=$produk_id';
        </script>";
    }
}
?>