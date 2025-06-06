<?php
if($role == 'admin'){
    if(isset($_POST['cari'])){
        $dari=$_POST['dari'];
        $sampai=$_POST['sampai'];
        $transaksi=mysqli_query($koneksi,"SELECT pesanan.created_at as tgl_p, user.alamat,transaksi.id as id_transaksi,transaksi.created_at,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,user.email,user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id 
        JOIN user ON user.id = pesanan.user_id 
        JOIN seller ON seller.id = produk.seller_id
        JOIN transaksi ON transaksi.pesanan_id=pesanan.id
        WHERE pesanan.status='selesai' AND DATE(transaksi.created_at) BETWEEN '$dari' AND '$sampai'");
    }else{
        $transaksi=mysqli_query($koneksi,"SELECT pesanan.created_at as tgl_p, user.alamat,transaksi.id as id_transaksi,transaksi.created_at,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,user.email,user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id 
        JOIN user ON user.id = pesanan.user_id 
        JOIN seller ON seller.id = produk.seller_id
        JOIN transaksi ON transaksi.pesanan_id=pesanan.id
        WHERE pesanan.status='selesai'");
    }

}else{
    if(isset($_POST['cari'])){
        $dari=$_POST['dari'];
        $sampai=$_POST['sampai'];
        $transaksi=mysqli_query($koneksi,"SELECT pesanan.created_at as tgl_p, user.alamat,transaksi.id as id_transaksi,transaksi.created_at,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,user.email,user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id 
        JOIN user ON user.id = pesanan.user_id 
        JOIN seller ON seller.id = produk.seller_id
        JOIN transaksi ON transaksi.pesanan_id=pesanan.id
        WHERE pesanan.status='selesai' AND seller.id='$ses_id' AND DATE(transaksi.created_at) BETWEEN '$dari' AND '$sampai'");
    }else{
        $transaksi=mysqli_query($koneksi,"SELECT pesanan.created_at as tgl_p, user.alamat,transaksi.id as id_transaksi,transaksi.created_at,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,user.email,user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id 
        JOIN user ON user.id = pesanan.user_id 
        JOIN seller ON seller.id = produk.seller_id
        JOIN transaksi ON transaksi.pesanan_id=pesanan.id
        WHERE pesanan.status='selesai'AND seller.id='$ses_id'");
    }
}
?>
<div class="card card-info mt-3" id="card-data">
    <div class="card-header" style="background-color:  #3498DB">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-table"></i> Data Transaksi
        </h5>
    </div>

    <!-- /.card-header -->
    <div class="card-body p-2">
    <div class="kotak-cari">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row align-items-end">
            <div class="col-sm-4">
                <label class="col-form-label">Dari Tanggal</label>
                <input type="date" name="dari" id="dari" class="form-control" required>
            </div>

            <div class="col-sm-4">
                <label class="col-form-label">Sampai Tanggal</label>
                <input type="date" name="sampai" id="sampai" class="form-control" required>
            </div>

            <div class="col-sm-4">
                <button type="submit" name="cari" class="btn text-white w-50" 
                    style="background-color: #3498DB;">Cari</button>

                <?php
                $cetak_url = "././cetak/transaksi/data_transaksi.php";
                if (!empty($_POST['dari']) && !empty($_POST['sampai'])) {
                    $cetak_url .= "?dari=" . $_POST['dari'] . "&sampai=" . $_POST['sampai'] . "&id=" . $ses_id . "&role=" . $role;
                }
                ?>

                <a href="<?= $cetak_url ?>?id=<?= $ses_id ?>&role=<?= $role ?>" class="btn text-white" target="_blank" 
                    style="background-color: #3498DB;">Cetak</a>
            </div>

        </div>
    </form>
</div>

        </div>
   
        <div class="table-responsive">
            <br>
            <table id="example" class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                         <th>No</th>
                        <th>Gambar</th>
                        <th>User</th>
                        <th>Kontak</th>
                        <th>Produk</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jumlah</th>
                        <th>Warna (Ukuran) / Rasa</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($transaksi)) { ?>
                        <tr>
                        <td><?= $no++; ?></td>
                        <td><img src="../assets/img/produk/<?= $data['gambar1'] ?>" alt="icon" width="100px"></td>
                        <td><?= $data['email'] ?></td>
                        <td><?= $data['kontak'] ?></td>
                        <td><?= $data['produk'] ?></td>
                        <td><?= $data['created_at'] ?></td>
                        <td><?= $data['quantity'] ?> </td>
                        <?php if($data['ukuran'] == '-' || $data['warna'] == '-' ) { ?>
                        <td> <?= $data['rasa'] ?></td>
                        <?php } else { ?>
                        <td> <?= $data['warna'] ?> - (<?= $data['ukuran'] ?>)</td>
                        <?php } ?>
                        <td>Rp.<?= number_format($data['price'], 0, ',', '.'); ?></td>
                        <td>
                            <button class="badge  border-0 p-2" style="background-color:#3498DB;" data-bs-toggle="modal" data-bs-target="#modal_detail<?= $data['id_transaksi'] ?>" id="btn_detail">Detail</button>
                        </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="modal_detail<?= $data['id_transaksi'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Pesanan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="" method="post">
                            <div class="mb-3">
                            <label for="basic-url" class="form-label">Kode Transaksi</label>
                            <input type="text" value="<?= $data['id_transaksi'] ?>" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                            <label for="basic-url" class="form-label">Produk</label>
                            <input type="text" value="<?= $data['produk'] ?>" class="form-control" readonly>
                             </div>
                        <div class="mb-3">
                        <label for="basic-url" class="form-label">Email</label>
                        <input type="text" value="<?= $data['email'] ?>" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                    <label for="basic-url" class="form-label">Kontak</label>
                    <input type="text" value="<?= $data['kontak'] ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                <label for="basic-url" class="form-label">Tanggal Pesan</label>
                <input type="text" value="<?= $data['tgl_p'] ?>" class="form-control" readonly>
            </div>
                <div class="mb-3">
                <label for="basic-url" class="form-label">Tanggal diterima</label>
                <input type="text" value="<?= $data['created_at'] ?>" class="form-control" readonly>
            </div>
                <div class="mb-3">
                <label for="basic-url" class="form-label">Quantity</label>
                <input type="text" value="<?= $data['quantity'] ?>" class="form-control" readonly>
            </div>
            <?php if($data['ukuran'] == '-' || $data['warna'] == '-' ) { ?>
                <div class="mb-3">
                <label for="basic-url" class="form-label">Rasa</label>
                <input type="text" value="<?= $data['rasa'] ?>" class="form-control" readonly>
            </div>
                        <?php } else { ?>
                            <div class="mb-3">
                <label for="basic-url" class="form-label">Ukuran (Warna)</label>
                <input type="text" value="<?= $data['ukuran'] ?> (<?= $data['warna'] ?> )" class="form-control" readonly>
            </div>
            <?php } ?>
            <div class="mb-3">
                <label for="basic-url" class="form-label">Harga</label>
                <input type="text" value="<?= number_format($data['price'], 0, ',', '.'); ?>" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="basic-url" class="form-label">Alamat User</label>
            <textarea class="form-control" id="alamat" name="alamat"readonly><?= $data['alamat'] ?></textarea>
            </div>
   
                            </div>
                          
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                            </form>
                            </div>
                        </div>
                        </div>
                        <?php } ?>
                </tbody>
                </tfoot>
            </table>

        </div>
    </div>

    <!-- /.card-body -->