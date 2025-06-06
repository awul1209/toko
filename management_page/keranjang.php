<?php
$keranjang=mysqli_query($koneksi,"SELECT keranjang.id,keranjang.created_at,produk.id as id_produk, produk,harga,stock,produk.gambar1,nama_toko,seller.kontak FROM keranjang  
JOIN produk ON keranjang.produk_id=produk.id 
JOIN seller ON produk.seller_id=seller.id
JOIN user ON keranjang.user_id=user.id WHERE user.id='$s_id'");
?>
<div class="kotak-keranjang">
     <!-- History Pembelian -->
     <div class="keranjang-user">
            <h3 >Keranjang Saya</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>No.</th>
                    <th> Gambar</th>
                    <th> Toko</th>
                    <th> Produk</th>
                    <th> Harga</th>
                    <th> Stock</th>
                    <th> Action </th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        while($row=mysqli_fetch_assoc($keranjang)){
                        ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><img src="assets/img/produk/<?= $row['gambar1'] ?>" alt="" width="100px"></td>
                            <td><?= $row['nama_toko']; ?><br>
                           (<?= $row['kontak']; ?>)
                            </td>
                            <td><?= $row['produk']; ?></td>
                            <td><?= $row['harga']; ?></td>
                            <td><?= $row['stock']; ?></td>
                            <td>
                                <form action="" method="post" class="d-inline me-2">
                                    <input type="hidden" name="id_produk" value="<?= $row['id_produk'] ?>">
                                    <button type="submit" name="beli" class="btn" style="background-color:#712cf9; color:white;" href="">Beli</buuton>
                                </form>
                                <a class="text-decoration-none" href="?page=del_keranjang&kode=<?= $row['id'] ?>">
                                <button class="btn btn-danger" style="" href="">Hapus</button>
                                </a>
                            </td>
                            <!-- <td>Rp 500.000</td>
                            <td><span class="badge bg-success">Selesai</span></td> -->
                        </tr>
                        <?php $no++; } ?>
 
                    </tbody>
                </table>
            </div>
        </div>
</div>

<?php
if(isset($_POST['beli'])){
    $id_produk=$_POST['id_produk'];
    if (empty($s_nama)) {
        echo "<script>
        Swal.fire({
            title: 'Anda Belum Terdaftar',
            text: '',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
            
            }
        });
    </script>";
    } else {
        echo "<script>
      window.location = '?page=transaksi&produk=$id_produk';
        </script>";
    }
}
?>