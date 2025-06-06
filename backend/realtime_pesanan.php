<?php
include '../koneksi.php';
$ses_id=$_GET['ses_id'];
$tgl=date('Y-m-d');
$pesanan=mysqli_query($koneksi,"SELECT user.alamat,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, user.id as id_user, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,pesanan.metode,pesanan.briva, user.email, user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id JOIN user ON user.id = pesanan.user_id JOIN seller ON seller.id = produk.seller_id WHERE seller.id='$ses_id' AND tgl_pesanan='$tgl' AND pesanan.admin='setuju' AND (pesanan.status='pending' OR pesanan.status='di proses' OR pesanan.status='batal')");

$no=1;
while($row_pesanan=mysqli_fetch_assoc($pesanan)){
?>
        <tr>
        <td><?= $no; ?></td>
        <td><img src="../assets/img/produk/<?= $row_pesanan['gambar1'] ?>" alt="icon" width="100px"></td>
        <td><?= $row_pesanan['produk'] ?></td>
        <td><?= $row_pesanan['email'] ?></td>
        <td><?= $row_pesanan['kontak'] ?></td>
        <td><?= $row_pesanan['tgl_pesanan'] ?></td>
        <td><?= $row_pesanan['quantity'] ?> </td>
        <?php if($row_pesanan['ukuran'] == '-' || $row_pesanan['gambar1'] == '-' ) { ?>
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
        <td> <?= $row_pesanan['alamat'] ?></td>
        <td >
            <?php if($row_pesanan['status'] == 'pending') { ?>
            <form action="" method="post" class="d-inline">
                <input type="hidden" name="id_pesanan" id="" value="<?= $row_pesanan['id_pesanan'] ?>">
                <button class="badge bg-warning border-0 p-2 mb-1" name="terima" type="submit">Terima</button>
            </form>
            <button class="badge bg-danger border-0 p-2 mb-1" data-bs-toggle="modal" data-bs-target="#modal_tolak" data-id="<?= $row_pesanan['id_pesanan'] ?>" id="btn_tolak">Tolak</button>

            <?php } else if($row_pesanan['status'] == 'di proses'){ ?>
                <form action="" method="post" class="d-inline">
                <input type="hidden" name="id_pesanan" id="" value="<?= $row_pesanan['id_pesanan'] ?>">
                <button class="badge bg-primary border-0 p-2 mb-1" name="kirim" type="submit">Kirim</button>
            </form>
            <button class="badge bg-danger border-0 p-2 mb-1" data-bs-toggle="modal" data-bs-target="#modal_tolak" data-id="<?= $row_pesanan['id_pesanan'] ?>" id="btn_tolak">Tolak</button>

            <?php } else if($row_pesanan['status'] == 'batal'){ ?>
                <form action="" method="post" class="d-inline">
                <input type="hidden" name="id_pesanan" id="" value="<?= $row_pesanan['id_pesanan'] ?>">
                <button class="badge bg-primary border-0 p-2 mb-1" name="pembatalan" type="submit">SetujuiPembatalan</button>
            </form>
            <?php } ?>
            <a  class="badge border-0 text-decoration-none p-2 mt-1" style="background-color:#8a38e4;" href="?page=chat&user_id=<?= $row_pesanan['id_user'] ?>">Chat</a>
         

        </td>
</tr>
<?php $no++; } ?>