 <!-- Header / Slider Section -->

        <div class="container-slide">
            <div class="row justify-content-center">
                <div class="col-12 kotak-slide">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="assets/img/konten/s1.png" class="d-block w-100" alt="Slide 1">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/img/konten/s2.png" class="d-block w-100" alt="Slide 2">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/img/konten/s3.png" class="d-block w-100" alt="Slide 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


    <!-- fitur -->

<div class="kotak-fitur">
        <div class="fitur fitur1">
            <img src="assets/img/konten/car.png" alt="" width="25px">
             <p><strong>PENGIRIMAN CEPAT</strong> </p>
            </div>
        <div class="fitur fitur2">
        <img src="assets/img/konten/check.png" alt="" width="25px">
        <p><strong>KUALITAS TERJAMIN</strong> </p>
        </div>
        <div class="fitur fitur3">
        <img src="assets/img/konten/dolar.png" alt="" width="25px">
        <p><strong>PEMBAYARAN MUDAH</strong> </p>
        </div>
        <div class="fitur fitur4">
        <img src="assets/img/konten/user.png" alt="" width="25px">
        <p><strong>ADMIN BERSAHABT</strong> </p>
        </div>
</div>



<div class="kotak-kategori">
<div class="kotak-judul">
            <p><strong>PRODUK TERBARU</strong></p>
        </div>

        <!-- batas mobile desktop -->
        <div class="kategori">
        <?php  
      $query_kategori = mysqli_query($koneksi, "SELECT DISTINCT kategori from produk");
      while ($row_kategori = mysqli_fetch_assoc($query_kategori)){
      ?>
            <button class="btn btn-outline-dark kategori-btn" onclick="filterProduk('<?= $row_kategori['kategori'] ?>')"><?= $row_kategori['kategori'] ?></button>
            <?php } ?>
            <div class="pagination">
                <button id="prevBtn" onclick="prevPage()"><</button>
                <span id="pageInfo">1</span>
                <button id="nextBtn" onclick="nextPage()">></button>
            </div>
        </div>
    </div>


  <!-- produk -->
<div class="container kotak-produk">
    <div class="judul-produk"><center><p><b>PRODUK TERBARU</b></p></center></div>
        <div class="produk" id="container-produk"> <!-- Ukuran kolom utama -->
<!-- dari ajax -->
    </div>
</div>


<!-- iklan -->
 <div class="container kotak-iklan">
<div class="iklan1">
    <img src="assets/img/iklan/ik1.png" alt="">
</div>
<div class="iklan2">
    <img src="assets/img/iklan/ik3.png" alt="">
</div>
 </div>


<!-- best -->
<div class="container kotak-best">
    <div class="judul-best"><p><strong>BEST PRODUK</strong></p></div>
        <div class="best"> <!-- Ukuran kolom utama -->
            <?php 
             $query_produk = mysqli_query($koneksi, "SELECT seller.nama_toko, seller.id, produk.id, produk.produk, produk.deskripsi, produk.kategori, produk.harga, produk.stock, produk.diskon, produk.gambar1, produk.gambar2, produk.gambar3,  COALESCE(AVG(ulasan.rating), 0) AS rating, 
  COALESCE(SUM(DISTINCT pesanan.quantity), 0) AS jml_terjual  FROM produk JOIN seller ON produk.seller_id = seller.id LEFT JOIN pesanan ON pesanan.produk_id = produk.id LEFT JOIN transaksi ON transaksi.pesanan_id = pesanan.id LEFT JOIN ulasan ON produk.id = ulasan.produk_id GROUP BY produk.id LIMIT 8");
             // Menampilkan hasil produk
while ($row = mysqli_fetch_assoc($query_produk)) {
            ?>
        <div class="card best-card">
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
                    <p class="card-text-toko"><?= $row['nama_toko'] ?></p>
                    <p class="card-text-toko"><?= $row['produk'] ?></p>
                    <p class="card-title"><b><?= $row['harga'] ?></b></p>
                    <p style="font-size: 0.8em;" class="card-info">⭐ <?= $row['rating'] ?> / 5 | Terjual: <?= $row['jml_terjual']  ?> pcs</p>
            </a>
                </div>
            </div>
            <?php } ?>
    </div>
</div>




   



  

    <!-- ajax kategori -->
<script>
  function filterProduk(kategori) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'filter_kategori_produk.php?kategori=' + kategori, true);
    xhr.onload = function() {
      if (xhr.status === 200) {
        document.getElementById('container-produk').innerHTML = xhr.responseText;
      }
    };
    xhr.send();
  }

  // Untuk memuat data wisata saat halaman pertama kali dimuat
  window.onload = function() {
    filterProduk('');
  };
</script>

<!-- pagination -->
    <script>
        const itemsPerPage = 4;
        let currentPage = 1;
        const categories = document.querySelectorAll(".kategori-btn");
        const totalPages = Math.ceil(categories.length / itemsPerPage);
        const pageInfo = document.getElementById("pageInfo");
        
        function showPage(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            categories.forEach((btn, index) => {
                btn.classList.toggle("hidden", index < start || index >= end);
            });

            pageInfo.textContent = page;
            document.getElementById("prevBtn").disabled = (page === 1);
            document.getElementById("nextBtn").disabled = (page === totalPages);
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        }

        showPage(currentPage);
    </script>
