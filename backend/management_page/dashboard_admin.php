<?php
$date=date('Y-m-d');
$jmlseller = mysqli_query($koneksi, "SELECT COUNT(seller.id) as jml_seller FROM seller");
$seller = mysqli_fetch_assoc($jmlseller);

$user=mysqli_query($koneksi,"SELECT COUNT(user.id) jml_user FROM user WHERE role='user'");
$userr=mysqli_fetch_assoc($user);

$produk=mysqli_query($koneksi,"SELECT COUNT(produk.id) jml_produk FROM produk");
$produkk=mysqli_fetch_assoc($produk);


?>

<div class="row kotak-seller">
    <!-- ./col -->
    <div class="card-seller">
        <!-- small box -->
        <div class="small-box" style="background-color: #fff; color:#222; border-radius: 10px; box-shadow: 5px 8px 12px rgba(0, 0, 0, 0.1);">
            <div class="inner" style="padding: 20px;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <h3 style=" font-weight: bold;">
                            <?= $seller['jml_seller']; ?>
                        </h3>
                        <p style=" font-weight: bold;">Penjual</p>
                    </div>
                    <!-- Right: Image -->
                    <div>
                        <img src="assets/img/icon_action/seller.png" alt="Pesanan" style="width: 60px; height: auto;"/>
                    </div>
                </div>
            </div>
            <div class="footer" style="padding: 10px; text-align: center; background-color: #3498DB; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                <a href="?page=data-seller" class="small-box-footer" style="color: #fff;  font-weight: bold; text-decoration: none;">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- ./col -->

    <div class="card-seller">
        <!-- small box -->
        <div class="small-box" style="background-color: #fff; color:#222; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="inner" style="padding: 20px;">
                <!-- Left: Data count -->
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <h3 style="  font-weight: bold;">
                            <?= $userr['jml_user']; ?>
                        </h3>
                        <p style=" font-weight: bold;">Users</p>
                    </div>
                    <!-- Right: Image -->
                    <div>
                        <img src="assets/img/icon_action/user.png" alt="Transaksi" style="width: 60px; height: auto;"/>
                    </div>
                </div>
            </div>
            <div class="footer" style="padding: 10px; text-align: center; background-color:#3498DB; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                <a href="?page=data-user" class="small-box-footer" style="color: #fff; font-weight: bold; text-decoration: none;">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- ./col -->

    <div class="card-seller">
        <!-- small box -->
        <div class="small-box" style="background-color: #fff; color:#222; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="inner" style="padding: 20px;">
                <!-- Left: Data count -->
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <h3 style="  font-weight: bold;">
                            <?= $produkk['jml_produk']; ?>
                             
                        </h3>
                        <p style=" font-weight: bold;">produk</p>
                    </div>
                    <!-- Right: Image -->
                    <div>
                        <img src="assets/img/icon_action/produk.png" alt="Transaksi" style="width: 60px; height: auto;"/>
                    </div>
                </div>
            </div>
            <div class="footer" style="padding: 10px; text-align: center; background-color:#3498DB; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                <a href="?page=data-produk" class="small-box-footer" style="color: #fff;  font-weight: bold; text-decoration: none;">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- ./col -->
</div>


<!-- chart -->
<div class="kotak-chart">
    <div class="transaksi">
        <canvas id="transaksi"></canvas>
    </div>
    <div class="kategori">
        <canvas id="kategori"></canvas>
    </div>
    <br>
</div>

<script>
    let tahunSekarang = new Date().getFullYear();
    const transaksii = document.getElementById('transaksi');
    new Chart(transaksii, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: '# Data Transaksi ' + tahunSekarang,
                data:[
                    <?php
                    $sql_transaksi1 = mysqli_query($koneksi,
                    "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-01-01' AND '$tahun-01-30'");
                    echo mysqli_num_rows($sql_transaksi1);
                    ?>,
                    <?php
                    $sql_transaksi2 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-02-01' AND '$tahun-02-29'");
                    echo mysqli_num_rows($sql_transaksi2);
                    ?>,
                    <?php
                    $sql_transaksi3 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-03-01' AND '$tahun-03-30'");
                    echo mysqli_num_rows($sql_transaksi3);
                    ?>,
                    <?php
                    $sql_transaksi4 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-04-01' AND '$tahun-04-30'");
                    echo mysqli_num_rows($sql_transaksi4);
                    ?>,
                    <?php
                    $sql_transaksi5 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-05-01' AND '$tahun-05-30'");
                    echo mysqli_num_rows($sql_transaksi5);
                    ?>,
                    <?php
                    $sql_transaksi6 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-06-01' AND '$tahun-06-30'");
                    echo mysqli_num_rows($sql_transaksi6);
                    ?>,
                    <?php
                    $sql_transaksi7 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-07-01' AND '$tahun-07-30'");
                    echo mysqli_num_rows($sql_transaksi7);
                    ?>,
                    <?php
                    $sql_transaksi8 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-08-01' AND '$tahun-08-30'");
                    echo mysqli_num_rows($sql_transaksi8);
                    ?>,
                    <?php
                    $sql_transaksi9 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-09-01' AND '$tahun-09-30'");
                    echo mysqli_num_rows($sql_transaksi9);
                    ?>,
                    <?php
                    $sql_transaksi10 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-10-01' AND '$tahun-10-30'");
                    echo mysqli_num_rows($sql_transaksi10);
                    ?>,
                    <?php
                    $sql_transaksi11 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-11-01' AND '$tahun-11-30'");
                    echo mysqli_num_rows($sql_transaksi11);
                    ?>,
                    <?php
                    $sql_transaksi12 = mysqli_query($koneksi, "SELECT transaksi.created_at 
                    FROM transaksi 
                    LEFT JOIN pesanan ON transaksi.pesanan_id = pesanan.id 
                    JOIN produk ON pesanan.produk_id = produk.id 
                    JOIN seller ON produk.seller_id = seller.id 
                    WHERE  DATE(transaksi.created_at) BETWEEN '$tahun-12-01' AND '$tahun-12-30'");
                    echo mysqli_num_rows($sql_transaksi12);
                    ?>,
                ],
                backgroundColor: [
                    '#3498DB'
                ],
                borderColor: '#3498DB',

                // borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    min: 0,
                    max: 30
                }
            }
        }
    });
</script>

<script>
    // let tahunSekarang = new Date().getFullYear();
    const kategori = document.getElementById('kategori');
    new Chart(kategori, {
        type: 'pie',
        data: {
            labels: ['Fashion', 'Makanan', 'Sembako', 'Kerajinan'],
            datasets: [{
                label: '',
                data: [<?php
                        $sql1 = mysqli_query($koneksi, "SELECT kategori FROM produk WHERE kategori = 'Fashion' ");
                        echo mysqli_num_rows($sql1);
                        ?>,
                    <?php
                    $sql2 = mysqli_query($koneksi, "SELECT kategori FROM produk WHERE kategori = 'Makanan'  ");
                    echo mysqli_num_rows($sql2);
                    ?>,
                    <?php
                    $sql3 = mysqli_query($koneksi, "SELECT kategori FROM produk WHERE kategori = 'Sembako'   ");
                    echo mysqli_num_rows($sql3);
                    ?>,
                    <?php
                    $sql4 = mysqli_query($koneksi, "SELECT kategori FROM produk WHERE kategori = 'Kerajinan'  ");
                    echo mysqli_num_rows($sql4);
                    ?>,
                ],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    '#3498DB',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)'
                ],
            }]
        },
        options: {
            scales: {
            }
        }
        
    });
</script>