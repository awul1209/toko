<?php
include 'koneksi.php'; // Pastikan path ini benar
$s_id = $_GET['s_id'];

// --- Query Anda tidak diubah ---
$query = "
SELECT pesanan.id AS id_pesanan,pesanan.estimasi, produk.id AS id_produk, seller.id AS id_toko, seller.nama_toko,seller.kontak, produk.gambar1, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,pesanan.keterangan,pesanan.briva FROM pesanan JOIN produk ON produk.id = pesanan.produk_id JOIN user ON user.id = pesanan.user_id JOIN seller ON seller.id = produk.seller_id WHERE pesanan.user_id = '$s_id' AND (
    pesanan.status = 'pending' 
   OR pesanan.status = 'menunggu pembayaran' 
   OR pesanan.status = 'di proses' 
   OR pesanan.status = 'batal' 
   OR pesanan.status = 'di batalkan' 
   OR pesanan.status = 'ditolak'  
   OR pesanan.status = 'bayar'
   OR pesanan.status = 'proses'
   OR pesanan.status = 'dikirim'
 )
 ORDER BY pesanan.tgl_pesanan DESC";
$pesanan = mysqli_query($koneksi, $query);

if (mysqli_num_rows($pesanan) == 0) {
    echo '<div class="alert alert-light text-center">Anda belum memiliki pesanan aktif.</div>';
}

while ($row_pesanan = mysqli_fetch_assoc($pesanan)) {
    // --- Logika untuk menentukan teks dan warna badge status ---
    $status_text = '';
    $status_class = '';
    switch ($row_pesanan['status']) {
        case 'pending': $status_text = 'Pending'; $status_class = 'bg-secondary'; break;
        case 'menunggu pembayaran': case 'bayar': $status_text = 'Menunggu Pembayaran'; $status_class = 'bg-warning text-dark'; break;
        case 'proses': case 'di proses': $status_text = 'Diproses'; $status_class = 'bg-info'; break;
        case 'dikirim': $status_text = 'Dikirim'; $status_class = 'bg-primary'; break;
        case 'batal': $status_text = 'Menunggu Konfirmasi Batal'; $status_class = 'bg-danger'; break;
        case 'di batalkan': case 'ditolak': $status_text = 'Dibatalkan'; $status_class = 'bg-dark'; break;
        default: $status_text = ucfirst($row_pesanan['status']); $status_class = 'bg-light text-dark';
    }
?>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Toko:</small>
                <strong class="ms-2"><?= htmlspecialchars($row_pesanan['nama_toko']) ?></strong>
            </div>
            <span class="badge rounded-pill <?= $status_class ?> fs-6 px-3 py-2"><?= $status_text ?></span>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-7 col-lg-8">
                    <div class="d-flex">
                        <img src="assets/img/produk/<?= $row_pesanan['gambar1'] ?>" class="rounded border" alt="produk" style="width: 90px; height: 90px; object-fit: cover;">
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
                                <?php if ($varian): ?> Varian: <?= $varian ?> | <?php endif; ?>
                                Jumlah: <strong><?= $row_pesanan['quantity'] ?></strong>
                            </p>
                            <p class="card-text"><small class="text-muted">Tgl Pesan: <?= date('d M Y', strtotime($row_pesanan['tgl_pesanan'])) ?></small></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-lg-4 border-start ps-md-4">
                    <div class="mb-3">
                        <small class="text-muted d-block">Total Harga</small>
                        <h4 class="fw-bold text-success">Rp.<?= number_format($row_pesanan['price'], 0, ',', '.'); ?></h4>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <?php if ($row_pesanan['status'] == 'pending' || $row_pesanan['status'] == 'di proses' || $row_pesanan['status'] == 'menunggu pembayaran' || $row_pesanan['status'] == 'bayar') { ?>
                            <form action="" method="post" class="flex-grow-1">
                                <input type="hidden" name="id_batal" value="<?= $row_pesanan['id_pesanan'] ?>">
                                <button class="btn btn-outline-danger btn-sm w-100" name="batal" type="submit">Batalkan</button>
                            </form>
                        <?php } ?>

                        <?php if ($row_pesanan['status'] == 'dikirim') { ?>
                            <form action="" method="post" class="flex-grow-1">
                                <input type="hidden" name="id_pesanan" value="<?= $row_pesanan['id_pesanan'] ?>">
                                <button class="btn btn-success btn-sm w-100" name="selesai" type="submit">Pesanan Diterima</button>
                            </form>
                        <?php } ?>
                        
                        <?php if ($row_pesanan['status'] == 'ditolak' || $row_pesanan['status'] == 'di batalkan') { ?>
                            <form action="" method="post" class="flex-grow-1">
                                <input type="hidden" name="id_pesanan" value="<?= $row_pesanan['id_pesanan'] ?>">
                                <button class="btn btn-danger btn-sm w-100" name="hapus" type="submit">Hapus</button>
                            </form>
                              <button type="button"
            class="badge bg-primary text-white border-0 mt-1"
            data-bs-toggle="modal"
            data-bs-target="#modal_view"
            data-keterangan-pesanan="<?= htmlspecialchars($row_pesanan['keterangan']) ?>"
            id="btn_view_pesanan_<?= htmlspecialchars($row_pesanan['id_pesanan']) ?>"> View
    </button>
                        <?php } ?>

                         <?php if ($row_pesanan['status'] == 'bayar') { ?>
                            <button type="button" class="btn btn-primary btn-sm btn-buka-modal flex-grow-1" data-va="<?= $row_pesanan['id_pesanan'] ?>" data-total="<?= $row_pesanan['price'] ?>">Bayar</button>
                        <?php } ?>

                        <button type="button" class="btn btn-info btn-sm text-white btn_lacak flex-grow-1" 
                                data-id="<?= $row_pesanan['id_toko'] ?>" 
                                data-status="<?= $row_pesanan['status'] ?>" 
                                data-estimasi="<?= $row_pesanan['estimasi'] ?>">
                                Lacak
                        </button>
                        
                        <a class="btn btn-secondary btn-sm flex-grow-1" href="?page=chat&seller_id=<?= $row_pesanan['id_toko'] ?>">Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>