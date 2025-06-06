<?php
include '../koneksi.php';
$ses_id=$_GET['ses_id'];
$no = 1;

$pesanan=mysqli_query($koneksi,"SELECT user.alamat,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status, user.email, user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id JOIN user ON user.id = pesanan.user_id JOIN seller ON seller.id = produk.seller_id WHERE seller.id='$ses_id' AND pesanan.status='dikirim'");
while ($data = mysqli_fetch_assoc($pesanan)) { ?>
<tr>
<td><?= $no; ?></td>
<td><img src="../assets/img/produk/<?= $data['gambar1'] ?>" alt="icon" width="100px"></td>
<td><?= $data['produk'] ?></td>
<td><?= $data['email'] ?></td>
<td><?= $data['kontak'] ?></td>
<td><?= $data['tgl_pesanan'] ?></td>
<td><?= $data['quantity'] ?> </td>
<?php if($data['ukuran'] == '-' || $data['gambar1'] == '-' ) { ?>
<td> <?= $data['rasa'] ?></td>
<?php } else { ?>
<td> <?= $data['warna'] ?> - (<?= $data['ukuran'] ?>)</td>
<?php } ?>
<td>Rp.<?= number_format($data['price'], 0, ',', '.'); ?></td>
<td><?= $data['metode'] ?></td>
<td> <?= $data['alamat'] ?></td>
<?php if($data['status'] == 'dikirim') { ?>
    <td>
        <button class="badge bg-primary border-0 p-2" id="btn_tolak" style="cursor: not-allowed;">Dikirim</button>
    </td>
    <td>
    <!-- <button class="badge bg-danger border-0 p-2" data-bs-toggle="modal" data-bs-target="#modal_detail" data-id="<?= $data['id_pesanan'] ?>" id="btn_detail">Detail</button> -->
        <form action="" method="post" class="d-inline">
        <input type="hidden" name="id_pesanan" value="<?= $data['id_pesanan'] ?>">
        <button  class="badge border-0 text-decoration-none p-2" style="background-color:#8a38e4;" name="selesai" type="submit">Selesai</button>
        </form>
    </td>

</tr>

<?php  } $no++;  }?> 