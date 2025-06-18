<?php
$date=date('Y-m-d');
$jmlseller = mysqli_query($koneksi, "SELECT COUNT(seller.id) as jml_seller FROM seller");
$seller = mysqli_fetch_assoc($jmlseller);

$user=mysqli_query($koneksi,"SELECT
    DATE_FORMAT(t.created_at, '%Y-%m') AS bulan_transaksi,
    COUNT(t.id) AS jumlah_transaksi,
    
    -- Mengubah format kolom total_pendapatan_admin ke Rupiah
    CONCAT('Rp. ', REPLACE(FORMAT(SUM(p.price * 0.10), 0), ',', '.')) AS total_pendapatan_admin
    
FROM
    transaksi t
JOIN
    pesanan p ON t.pesanan_id = p.id
WHERE
    p.status = 'selesai'
GROUP BY
    bulan_transaksi
ORDER BY
    bulan_transaksi DESC;");
$jml_pendapatan=mysqli_fetch_assoc($user);

$produk=mysqli_query($koneksi,"SELECT COUNT(produk.id) jml_produk FROM produk");
$produkk=mysqli_fetch_assoc($produk);

// SELECT
//     s.id AS id_penjual,
//     s.nama_toko AS nama_penjual,
//     CONCAT('Rp. ', REPLACE(FORMAT(SUM(p.price * 0.90), 0), ',', '.')) AS total_pendapatan_penjual
// FROM
//     transaksi t
// JOIN
//     pesanan p ON t.pesanan_id = p.id
// JOIN
//     produk pr ON p.produk_id = pr.id
// JOIN
//     seller s ON pr.seller_id = s.id
// WHERE
//     p.status = 'selesai'
// GROUP BY
//     s.id, s.nama_toko
// ORDER BY
//     SUM(p.price * 0.90) DESC; -- Diurutkan dari pendapatan terbesar
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
                            <?= $jml_pendapatan['total_pendapatan_admin']; ?>
                        </h3>
                        <p style=" font-weight: bold;">Jumlah Pendapatan</p>
                    </div>
                    <!-- Right: Image -->
                    <div>
                        <img src="assets/img/icon_action/pen.png" alt="Transaksi" style="width: 60px; height: auto;"/>
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

<?php
// Langkah 1: Tentukan tahun yang akan ditampilkan (misalnya, tahun saat ini)
$tahun_sekarang = date('Y');

// Langkah 2: Siapkan array untuk menampung jumlah transaksi per bulan (dari 1 sampai 12)
// Kita isi semua dengan nilai 0 terlebih dahulu.
$transaksi_per_bulan = array_fill(1, 12, 0);

// Langkah 3: Buat SATU query efisien untuk mengambil jumlah transaksi per bulan untuk tahun ini
$query_chart = "
    SELECT 
        MONTH(transaksi.created_at) AS bulan, 
        COUNT(transaksi.id) AS jumlah_transaksi
    FROM 
        transaksi
    WHERE 
        YEAR(transaksi.created_at) = '$tahun_sekarang'
    GROUP BY 
        bulan
";

$hasil_chart = mysqli_query($koneksi, $query_chart);

// Langkah 4: Isi array $transaksi_per_bulan dengan data dari database
while ($row = mysqli_fetch_assoc($hasil_chart)) {
    $bulan = (int)$row['bulan'];
    $jumlah = (int)$row['jumlah_transaksi'];
    if (isset($transaksi_per_bulan[$bulan])) {
        $transaksi_per_bulan[$bulan] = $jumlah;
    }
}

// Langkah 5: Ubah array PHP menjadi format data yang bisa dibaca oleh JavaScript (Chart.js)
// array_values akan mengambil nilai [0, 5, 10, ...] dan mengabaikan key [1, 2, 3, ...]
// implode akan menggabungkan nilai-nilai tersebut dengan koma.
$data_chart_js = implode(',', array_values($transaksi_per_bulan));
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('transaksi');
    const tahunSekarang = <?= json_encode($tahun_sekarang) ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: 'Total Transaksi Tahun ' + tahunSekarang,
                // Data diambil dari variabel PHP yang sudah diolah
                data: [<?= $data_chart_js ?>],
                backgroundColor: 'rgba(52, 152, 219, 0.7)', // Warna biru dengan sedikit transparansi
                borderColor: 'rgba(41, 128, 185, 1)', // Warna biru lebih gelap untuk border
                borderWidth: 1,
                borderRadius: 5 // Membuat ujung bar sedikit melengkung
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    // Membuat angka di sumbu Y menjadi integer (tidak ada desimal)
                    ticks: {
                        stepSize: 1 
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y + ' transaksi';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});
</script>

<?php
// Asumsi $koneksi sudah tersedia dari file Anda

// 1. Siapkan query untuk mengambil data semua produk berdasarkan kategori
// Perubahan: Menghapus "WHERE seller_id" dan mengganti COUNT(id_produk) menjadi COUNT(id)
$query_kategori = "SELECT kategori, COUNT(id) AS jumlah_produk 
                   FROM produk 
                   GROUP BY kategori";

$hasil_query = mysqli_query($koneksi, $query_kategori);

// 2. Olah data hasil query menjadi array untuk chart (Tidak ada perubahan di bagian ini)
$labels_kategori = [];
$data_jumlah = [];
while ($row = mysqli_fetch_assoc($hasil_query)) {
    $labels_kategori[] = $row['kategori'];
    $data_jumlah[] = $row['jumlah_produk'];
}

?>

<script>
// Ambil elemen canvas
const kategoriCanvas = document.getElementById('kategori');

// 3. Buat chart baru dengan data dinamis dari PHP
new Chart(kategoriCanvas, {
    type: 'pie',
    data: {
        // Gunakan data kategori yang sudah diambil dari database
        labels: <?php echo json_encode($labels_kategori); ?>,
        datasets: [{
            label: 'Jumlah Produk per Kategori',
            // Gunakan data jumlah produk yang sesuai
            data: <?php echo json_encode($data_jumlah); ?>,
            backgroundColor: [
                'rgb(255, 99, 132)',
                '#3498DB',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                '#9B59B6',
                '#F1C40F',
                '#E74C3C',
                '#2ECC71'
            ],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Persentase Semua Produk Berdasarkan Kategori'
            }
        }
    }
});
</script>