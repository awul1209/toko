<?php
include 'koneksi.php';
$s_id = $_GET['s_id'];
$histori=mysqli_query($koneksi,"SELECT transaksi.id as id_transaksi,pesanan.id AS id_pesanan,transaksi.created_at as tgl_selesai, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode,pesanan.briva, pesanan.price, pesanan.tgl_pesanan, pesanan.status,user.email,seller.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id 
JOIN user ON user.id = pesanan.user_id 
JOIN seller ON seller.id = produk.seller_id
JOIN transaksi ON transaksi.pesanan_id=pesanan.id
WHERE user.id='$s_id' AND pesanan.status='selesai'");
?>
<?php
$no = 1;
while ($row_histori = mysqli_fetch_assoc($histori)) {
?>
    <tr>
        <td><?= $no; ?></td>
        <td><img src="assets/img/produk/<?= $row_histori['gambar1'] ?>" alt="" width="100px"></td>
        <td><?= $row_histori['produk'] ?></td>
        <td><?= $row_histori['quantity'] ?> </td>
        <?php if ($row_histori['ukuran'] == '-' || $row_histori['warna'] == '-') { ?>
            <td> <?= $row_histori['rasa'] ?></td>
        <?php } else { ?>
            <td> <?= $row_histori['warna'] ?> - (<?= $row_histori['ukuran'] ?>)</td>
        <?php } ?>
        <td>Rp.<?= number_format($row_histori['price'], 0, ',', '.'); ?></td>
        <?php if($row_histori['metode'] == 'Briva'){ ?>
        <td>
            <?= $row_histori['metode'] ?><br>
            (<?= $row_histori['briva'] ?>)
        </td>
        <?php } else{ ?>
           <td>
           <?= $row_histori['metode'] ?>
           </td>
        <?php } ?>
        <td><?= $row_histori['nama_toko'] ?> <br> (<?= $row_histori['kontak'] ?>)</td>
        <td><?= $row_histori['tgl_pesanan'] ?></td>
        <td><?= $row_histori['tgl_selesai'] ?></td>
        <td>
                <!-- <button class="badge bg-primary border-0 mb-1" name="view" type="submit" data-bs-target="#modal_view" data-id="<?= $row_histori['id_transaksi'] ?>" id="btn_view">View</button> -->
                 <?php
    $id_produk=$row_histori['id_produk'];
    $id_tr=$row_histori['id_transaksi'];
    $rating=mysqli_query($koneksi,"SELECT * FROM ulasan  WHERE user_id='$s_id' AND produk_id ='$id_produk' and transaksi_id = '$id_tr'");
            if(mysqli_num_rows($rating) >= 1){ ?>
                <button class="badge bg-warning text-white border-0" style="cursor: not-allowed;">Selesai</button>
            <?php } else { ?>
                <button class="badge text-white border-0" style="background-color:#8a38e4;" name="rating" data-bs-target="#modal_rating" data-id="<?= $row_histori['id_transaksi'] ?>" id="btn_rating">Rating</button>
                <?php } ?>
        </td>
    </tr>
<?php
    $no++;
}
?>