<?php
include '../koneksi.php';
// Harap pastikan variabel koneksi Anda bernama $koneksi

$ses_id = $_GET['ses_id'];

// --- Query tidak diubah, hanya ditambahkan alias agar lebih rapi ---
$query = "SELECT 
    user.alamat,
    user.id as id_user,
    user.email, 
    user.kontak,
    pesanan.id AS id_pesanan, 
    pesanan.quantity, 
    pesanan.ukuran, 
    pesanan.warna, 
    pesanan.rasa, 
    pesanan.metode, 
    pesanan.price, 
    pesanan.tgl_pesanan, 
    pesanan.status,
    pesanan.briva, 
    produk.id AS id_produk, 
    produk.gambar1, 
    produk.produk AS produk, 
    seller.id AS id_toko, 
    seller.nama_toko
FROM pesanan 
JOIN produk ON produk.id = pesanan.produk_id 
JOIN user ON user.id = pesanan.user_id 
JOIN seller ON seller.id = produk.seller_id 
WHERE seller.id='$ses_id' 
  AND (pesanan.status='pending' OR pesanan.status='di proses' OR pesanan.status='batal' OR pesanan.status='menunggu pembayaran' OR pesanan.status='bayar' OR pesanan.status='proses')";

$pesanan = mysqli_query($koneksi, $query);

if (mysqli_num_rows($pesanan) == 0) {
    echo '<div class="alert alert-secondary text-center">Belum ada pesanan masuk yang perlu ditangani.</div>';
}

while ($row_pesanan = mysqli_fetch_assoc($pesanan)) {

    // --- Logika untuk menentukan teks dan warna badge status ---
    $status_text = '';
    $status_class = '';
    switch ($row_pesanan['status']) {
        case 'pending':
        case 'menunggu pembayaran':
            $status_text = 'Pesanan Baru';
            $status_class = 'bg-info';
            break;
        case 'bayar':
        case 'proses':
            $status_text = 'Menunggu Konfirmasi Admin';
            $status_class = 'bg-secondary';
            break;
        case 'di proses':
            $status_text = 'Perlu Dikirim';
            $status_class = 'bg-primary';
            break;
        case 'batal':
            $status_text = 'Permintaan Batal';
            $status_class = 'bg-danger';
            break;
        default:
            $status_text = ucfirst($row_pesanan['status']);
            $status_class = 'bg-dark';
    }
?>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
            <div>
                <strong class="text-primary">#PESANAN-<?= $row_pesanan['id_pesanan'] ?></strong>
                <small class="text-muted ms-3"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y, H:i', strtotime($row_pesanan['tgl_pesanan'])) ?></small>
            </div>
            <span class="badge rounded-pill <?= $status_class ?> fs-6"><?= $status_text ?></span>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="d-flex">
                        <img src="../assets/img/produk/<?= $row_pesanan['gambar1'] ?>" class="rounded" alt="produk" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="ms-3">
                            <h5 class="card-title mb-1"><?= htmlspecialchars($row_pesanan['produk']) ?></h5>
                            <?php 
                            $varian = '';
                            if ($row_pesanan['ukuran'] != '-' && $row_pesanan['warna'] != '-') {
                                $varian = htmlspecialchars($row_pesanan['warna']) . ' (' . htmlspecialchars($row_pesanan['ukuran']) . ')';
                            } elseif ($row_pesanan['rasa'] != '-') {
                                $varian = htmlspecialchars($row_pesanan['rasa']);
                            }
                            ?>
                            <p class="card-text text-muted mb-1">
                                <?php if ($varian): ?>
                                    Varian: <?= $varian ?> | 
                                <?php endif; ?>
                                Jumlah: <strong><?= $row_pesanan['quantity'] ?></strong>
                            </p>
                             <p class="card-text text-muted">
                                Metode Bayar: <strong><?= htmlspecialchars($row_pesanan['metode']) ?></strong> 
                                <?php if($row_pesanan['metode'] == 'Briva'): ?>
                                    (<?= htmlspecialchars($row_pesanan['briva']) ?>)
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <p class="mb-1"><strong>Pembeli:</strong> <?= htmlspecialchars($row_pesanan['email']) ?> (<?= htmlspecialchars($row_pesanan['kontak']) ?>)</p>
                        <p class="mb-0"><strong>Alamat:</strong> <?= htmlspecialchars($row_pesanan['alamat']) ?></p>
                    </div>
                </div>

                <div class="col-md-4 border-start ps-md-4">
                    <div class="text-md-end">
                        <small class="text-muted">Total Harga</small>
                        <h3 class="fw-bold text-success mb-3">Rp.<?= number_format($row_pesanan['price'], 0, ',', '.'); ?></h3>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <?php if($row_pesanan['status'] == 'pending' || $row_pesanan['status'] == 'menunggu pembayaran'){ ?>
                            <form action="" method="post" class="d-grid">
                                <input type="hidden" name="id_pesanan" value="<?= $row_pesanan['id_pesanan'] ?>">
                                <button class="btn btn-warning" name="terima" type="submit"><i class="fas fa-check-circle me-2"></i>Terima Pesanan</button>
                            </form>
                            <button class="btn btn-outline-danger btn-tolak" data-bs-toggle="modal" data-bs-target="#modal_tolak" data-id="<?= $row_pesanan['id_pesanan'] ?>"><i class="fas fa-times-circle me-2"></i>Tolak</button>
                        
                        <?php } else if($row_pesanan['status'] == 'di proses'){ ?>
                            <form action="" method="post" class="d-grid">
                                <input type="hidden" name="id_pesanan" value="<?= $row_pesanan['id_pesanan'] ?>">
                                <button class="btn btn-primary" name="kirim" type="submit"><i class="fas fa-truck me-2"></i>Kirim Pesanan</button>
                            </form>
                            <button class="btn btn-outline-danger btn-tolak" data-bs-toggle="modal" data-bs-target="#modal_tolak" data-id="<?= $row_pesanan['id_pesanan'] ?>"><i class="fas fa-times-circle me-2"></i>Tolak</button>

                        <?php } else if($row_pesanan['status'] == 'batal'){ ?>
                            <form action="" method="post" class="d-grid">
                                <input type="hidden" name="id_pesanan" value="<?= $row_pesanan['id_pesanan'] ?>">
                                <button class="btn btn-danger" name="pembatalan" type="submit"><i class="fas fa-exclamation-triangle me-2"></i>Setujui Pembatalan</button>
                            </form>

                        <?php } else if($row_pesanan['status'] == 'bayar' || $row_pesanan['status'] == 'proses'){ ?>
                            <button class="btn btn-secondary disabled"><i class="fas fa-spinner fa-spin me-2"></i>Diproses Admin</button>
                        <?php } ?>

                        <a class="btn btn-info text-white" href="?page=chat&user_id=<?= $row_pesanan['id_user'] ?>"><i class="fas fa-comments me-2"></i>Chat Pembeli</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>