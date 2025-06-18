<?php
$date=date('Y-m-d');
$jumlahpesanan = mysqli_query($koneksi, "SELECT COUNT(pesanan.id) as jml_pesanan FROM `pesanan` JOIN produk ON pesanan.produk_id=produk.id JOIN user ON pesanan.user_id=user.id JOIN seller ON produk.seller_id=seller.id WHERE seller.id='$ses_id' AND tgl_pesanan='$date' AND status != 'pembatalan' AND status != 'selesai'");
$pesanan = mysqli_fetch_assoc($jumlahpesanan);

$transaksi=mysqli_query($koneksi,"SELECT COUNT(transaksi.id) jml_transaksi FROM `transaksi` LEFT JOIN pesanan ON transaksi.pesanan_id=pesanan.id JOIN produk ON pesanan.produk_id=produk.id JOIN seller ON produk.seller_id=seller.id WHERE seller.id='$ses_id' AND pesanan.status='selesai'");
$transaksii=mysqli_fetch_assoc($transaksi);

$total=mysqli_query($koneksi,"SELECT
    s.id AS id_penjual,
    s.nama_toko AS nama_penjual,
    
    -- Menjumlahkan total pendapatan penjual dan langsung format ke Rupiah
    CONCAT('Rp. ', REPLACE(FORMAT(SUM(p.price * 0.90), 0), ',', '.')) AS total_pendapatan_penjual,
    
    -- (Opsional) Menjumlahkan total omset kotor (total penjualan sebelum dipotong)
    CONCAT('Rp. ', REPLACE(FORMAT(SUM(p.price), 0), ',', '.')) AS total_omset,
    
    -- (Opsional) Menjumlahkan total komisi yang didapat admin dari penjual ini
    CONCAT('Rp. ', REPLACE(FORMAT(SUM(p.price * 0.10), 0), ',', '.')) AS total_komisi_admin
FROM
    transaksi t
JOIN
    pesanan p ON t.pesanan_id = p.id
JOIN
    produk pr ON p.produk_id = pr.id
JOIN
    seller s ON pr.seller_id = s.id
WHERE
    p.status = 'selesai' AND pr.seller_id = '$ses_id'
GROUP BY
    s.id, s.nama_toko");
$totall=mysqli_fetch_assoc($total);


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
                            <?= $pesanan['jml_pesanan']; ?>
                        </h3>
                        <p style=" font-weight: bold;">Pesanan Masuk</p>
                    </div>
                    <!-- Right: Image -->
                    <div>
                        <img src="assets/img/icon_action/psm.png" alt="Pesanan" style="width: 60px; height: auto;"/>
                    </div>
                </div>
            </div>
            <div class="footer" style="padding: 10px; text-align: center; background-color: #3498DB; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                <a href="?page=data-pesanan" class="small-box-footer" style="color: #fff;  font-weight: bold; text-decoration: none;">
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
                            <?= $transaksii['jml_transaksi']; ?>
                        </h3>
                        <p style=" font-weight: bold;">Transaksi</p>
                    </div>
                    <!-- Right: Image -->
                    <div>
                        <img src="assets/img/icon_action/trh.png" alt="Transaksi" style="width: 60px; height: auto;"/>
                    </div>
                </div>
            </div>
            <div class="footer" style="padding: 10px; text-align: center; background-color:#3498DB; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                <a href="?page=data-transaksi" class="small-box-footer" style="color: #fff; font-weight: bold; text-decoration: none;">
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
                    <h3 style="font-weight: bold;">
    <?= $totall['total_pendapatan_penjual']; ?>
</h3>
                        <p style=" font-weight: bold;">Total Pendapatan</p>
                    </div>
                    <!-- Right: Image -->
                    <div>
                        <img src="assets/img/icon_action/pen.png" alt="Transaksi" style="width: 60px; height: auto;"/>
                    </div>
                </div>
            </div>
            <div class="footer" style="padding: 10px; text-align: center; background-color:#3498DB; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                <a href="?page=data-transaksi" class="small-box-footer" style="color: #fff;  font-weight: bold; text-decoration: none;">
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
// Langkah 1: Pastikan variabel-variabel ini sudah ada dan aman
// $koneksi -> dari file koneksi Anda
// $ses_id -> ID penjual yang sedang login

$tahun_sekarang = date('Y');

// Langkah 2: Siapkan array untuk 12 bulan, isi dengan nilai awal 0
$transaksi_per_bulan = array_fill(1, 12, 0);

// Langkah 3: Buat SATU query efisien untuk mengambil data transaksi penjual ini
// Query ini sudah difilter berdasarkan tahun dan ID penjual
$query_chart_penjual = "
    SELECT 
        MONTH(t.created_at) AS bulan, 
        COUNT(t.id) AS jumlah_transaksi
    FROM 
        transaksi t
    JOIN 
        pesanan p ON t.pesanan_id = p.id
    JOIN 
        produk pr ON p.produk_id = pr.id
    WHERE 
        YEAR(t.created_at) = ? AND pr.seller_id = ?
    GROUP BY 
        bulan
";

// Menggunakan Prepared Statement untuk keamanan dari SQL Injection
$stmt = mysqli_prepare($koneksi, $query_chart_penjual);
mysqli_stmt_bind_param($stmt, "is", $tahun_sekarang, $ses_id);
mysqli_stmt_execute($stmt);
$hasil_chart = mysqli_stmt_get_result($stmt);

// Langkah 4: Isi array $transaksi_per_bulan dengan data dari database
while ($row = mysqli_fetch_assoc($hasil_chart)) {
    $bulan = (int)$row['bulan'];
    $jumlah = (int)$row['jumlah_transaksi'];
    if (isset($transaksi_per_bulan[$bulan])) {
        $transaksi_per_bulan[$bulan] = $jumlah;
    }
}
mysqli_stmt_close($stmt);

// Langkah 5: Siapkan data untuk JavaScript
$data_chart_js = implode(',', array_values($transaksi_per_bulan));
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan elemen canvas ada di halaman HTML Anda dengan id="transaksi"
    const ctx = document.getElementById('transaksi');
    if (ctx) {
        const tahunSekarang = <?= json_encode($tahun_sekarang) ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: 'Transaksi Anda Tahun ' + tahunSekarang,
                    // Data diambil dari variabel PHP yang sudah diolah
                    data: [<?= $data_chart_js ?>],
                    backgroundColor: 'rgba(52, 152, 219, 0.7)', // Warna hijau toska
                    borderColor: 'rgba(52, 152, 219, 0.7)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // Hanya tampilkan angka bulat
                            callback: function(value) {
                                if (Math.floor(value) === value) {
                                    return value;
                                }
                            }
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
                                return context.parsed.y + ' transaksi';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>

<?php
// Asumsi $koneksi dan $ses_id sudah tersedia dari file Anda

// 1. Siapkan query untuk mengambil data secara dinamis
$query_kategori = "SELECT kategori, COUNT(id) AS jumlah_produk 
                   FROM produk 
                   WHERE seller_id = '$ses_id' 
                   GROUP BY kategori";

$hasil_query = mysqli_query($koneksi, $query_kategori);

// 2. Olah data hasil query menjadi array untuk chart
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
                '#9B59B6', // Tambahkan warna lain untuk kategori
                '#F1C40F', // yang mungkin lebih dari 4
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
                text: 'Persentase Produk Berdasarkan Kategori'
            }
        }
    }
});
</script>