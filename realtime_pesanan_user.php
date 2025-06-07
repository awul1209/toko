<?php
include 'koneksi.php';
$s_id = $_GET['s_id'];

// Perbaiki query untuk memfilter status pesanan dengan benar
$pesanan = mysqli_query($koneksi, "
SELECT pesanan.id AS id_pesanan,pesanan.estimasi, produk.id AS id_produk, seller.id AS id_toko, seller.nama_toko,seller.kontak, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,pesanan.keterangan,pesanan.briva FROM pesanan JOIN produk ON produk.id = pesanan.produk_id JOIN user ON user.id = pesanan.user_id JOIN seller ON seller.id = produk.seller_id WHERE pesanan.user_id = '$s_id' AND pesanan.status = 'pending' OR pesanan.status = 'di proses' OR pesanan.status='batal' OR pesanan.status='di batalkan' OR pesanan.status='ditolak'  OR pesanan.status='dikirim'
");
?>

<?php
$no = 1;
while ($row_pesanan = mysqli_fetch_assoc($pesanan)) {
?>
    <tr>
        <td><?= $no; ?></td>
        <td><img src="assets/img/produk/<?= $row_pesanan['gambar1'] ?>" alt="" width="100px"></td>
        <td><?= $row_pesanan['produk'] ?></td>
        <td><?= $row_pesanan['tgl_pesanan'] ?></td>
        <td><?= $row_pesanan['quantity'] ?> </td>
        <?php if ($row_pesanan['ukuran'] == '-' || $row_pesanan['warna'] == '-') { ?>
            <td> <?= $row_pesanan['rasa'] ?></td>
        <?php } else { ?>
            <td> <?= $row_pesanan['warna'] ?> - (<?= $row_pesanan['ukuran'] ?>)</td>
        <?php } ?>
        <td>Rp.<?= number_format($row_pesanan['price'], 0, ',', '.'); ?></td>
        <?php if($row_pesanan['metode'] == 'Briva'){ ?>
        <td>
            <?= $row_pesanan['metode'] ?><br>
            (<?= $row_pesanan['briva'] ?>)
        </td>
        <?php } else{ ?>
            <td>
                <?= $row_pesanan['metode'] ?>
            </td>
        <?php } ?>
        <td><?= $row_pesanan['nama_toko'] ?> <br> (<?= $row_pesanan['kontak'] ?>)</td>
        <td>
            <!-- Tombol untuk status pending -->
            <?php if ($row_pesanan['status'] == 'pending') { ?>
                    <button class="badge bg-warning border-0 mb-1" name="terima" type="submit" style="cursor: not-allowed;">Pending</button>
                    <br>
                    <form action="" method="post" class="d-inline">
                    <input type="hidden" name="id_batal" value="<?= $row_pesanan['id_pesanan'] ?>">
                    <button class="badge bg-danger border-0" name="batal" type="submit">Batalkan</button>
                    </form>

                               <!-- Tombol untuk status di proses -->
            <?php } elseif ($row_pesanan['status'] == 'di proses') { ?>
                    <button class="badge bg-primary border-0 mb-1" name="proses" type="submit" style="cursor: not-allowed;">Di Proses</button>
                    <br>
                    <form action="" method="post" class="d-inline">
                    <input type="hidden" name="id_batal" value="<?= $row_pesanan['id_pesanan'] ?>">
                    <button class="badge bg-danger border-0" name="batal" type="submit">Batalkan</button>
                    </form>
            <?php } ?>

                        <!-- Tombol untuk status dikirim -->
            <?php if ($row_pesanan['status'] == 'dikirim') { ?>
                <button class="badge bg-primary border-0" style="cursor: not-allowed;">Dikirim</button>
            <?php } ?>

                       <!-- Tombol untuk status pengajuan pembatalan -->
            <?php if ($row_pesanan['status'] == 'batal') { ?>
                <button class="badge bg-danger border-0" style="cursor: not-allowed;">Mengajukan Pembatalan</button>
            <?php } ?>

                       <!-- Tombol untuk status ditolak -->
            <?php if ($row_pesanan['status'] == 'ditolak') { ?>
                <button class="badge bg-danger border-0 mb-1" style="cursor: not-allowed;">Di Tolak</button>
    
                <button class="badge bg-primary border-0" name="view" type="submit" data-bs-target="#modal_view" data-id="<?= $row_pesanan['keterangan'] ?>" id="btn_view">View</button>
            </form>
            <form action="" method="post" class="d-inline">
                <input type="hidden" name="id_pesanan" value="<?= $row_pesanan['id_pesanan'] ?>">
                <button class="badge bg-danger border-0" name="hapus" type="submit">Hapus</button>
            </form>
            <?php } ?>

                       <!-- Tombol untuk status pembatalan disetujui -->
            <?php if ($row_pesanan['status'] == 'di batalkan') { ?>
                <button class="badge bg-danger border-0 mb-1" style="cursor: not-allowed;">Pembatalan di Setujui</button>
                <br>
            </form>
            <form action="" method="post" class="d-inline">
                <input type="hidden" name="id_pesanan" value="<?= $row_pesanan['id_pesanan'] ?>">
                <button class="badge bg-danger border-0" name="hapus" type="submit">Hapus</button>
            </form>
            <?php } ?>
            <a class="badge border-0 text-decoration-none mt-1" style="background-color:#8a38e4;" href="?page=chat&seller_id=<?= $row_pesanan['id_toko'] ?>">Chat</a>
        </td>
        <td>
            <button type="button" class="btn btn-primary btn_lacak" data-id="<?= $row_pesanan['id_toko'] ?>" data-status="<?= $row_pesanan['status'] ?>" data-estimasi="<?= $row_pesanan['estimasi'] ?>">Lacak</button>
        </td>
    </tr>
<?php
    $no++;
}
?>
