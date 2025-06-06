<div class="card card-info mt-3" id="card-data">
    <div class="card-header" style="background-color: #3498DB">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-table"></i> Data Pesanan
        </h5>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <br>
            <table id="example" class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                    <th>No</th>
                            <th>Gambar</th>
                            <th>Tanggal Pesanan</th>
                            <th>User</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Warna (Ukuran) / Rasa</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
$pesanan=mysqli_query($koneksi,"SELECT pesanan.admin, user.alamat,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, user.id as id_user, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,pesanan.metode,pesanan.briva, user.email, user.kontak FROM pesanan JOIN produk ON produk.id = pesanan.produk_id JOIN user ON user.id = pesanan.user_id JOIN seller ON seller.id = produk.seller_id WHERE
    (pesanan.admin = '' OR pesanan.admin = 'setuju')
    AND pesanan.status IN ('pending', 'di proses', 'batal', 'ditolak')");
 $no=1;
while($row_pesanan=mysqli_fetch_assoc($pesanan)){ ?>
<tr>
    <td><?= $no; ?></td>
        <td><img src="../assets/img/produk/<?= $row_pesanan['gambar1'] ?>" alt="icon" width="100px"></td>
        <td><?= $row_pesanan['tgl_pesanan'] ?></td>
        <td><?= $row_pesanan['email'] ?></td>
        <td><?= $row_pesanan['produk'] ?></td>
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

        <td>
        <?php if($row_pesanan['admin'] == 'setuju' && ($row_pesanan['status'] == 'pending' || $row_pesanan['status'] == 'dikirim')){ ?>
            <button data-bs-toggle="modal" data-bs-target="#modal_detail_admin<?= $row_pesanan['id_pesanan'] ?>" class="btn btn-primary btn-sm">Detail</button>
            <?php }elseif($row_pesanan['admin']==''){ ?>
                <form action="" method="post">
                    <input type="hidden" name="id_pesanan" value="<?= $row_pesanan['id_pesanan'] ?>">
                    <button type="submit" name="setuju" class="btn btn-success btn-sm m-2">Setujui</button>
                </form>
                <button data-bs-toggle="modal" data-bs-target="#modal_detail_admin<?= $row_pesanan['id_pesanan'] ?>" class="btn btn-primary btn-sm">Detail</button>
            <?php }elseif($row_pesanan['status']=='batal' || $row_pesanan['status']=='ditolak'){ ?>
                 <button class="btn btn-danger btn-sm m-2" disabled>Batal</button>
            <?php } ?>
        </td>
</tr>

   <!-- Modal -->
                        <div class="modal fade" id="modal_detail_admin<?= $row_pesanan['id_pesanan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Pesanan <?= $row_pesanan['nama_toko'] ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="" method="post">
                            <div class="mb-3">
                            <label for="basic-url" class="form-label">Kode Transaksi</label>
                            <input type="text" value="KDP<?= $row_pesanan['id_pesanan'] ?>" class="form-control" readonly>
                            </div>
                                            <div class="mb-3">
                <label for="basic-url" class="form-label">Tanggal Pesan</label>
                <input type="text" value="<?= $row_pesanan['tgl_pesanan'] ?>" class="form-control" readonly>
            </div>
                            <div class="mb-3">
                            <label for="basic-url" class="form-label">Produk</label>
                            <input type="text" value="<?= $row_pesanan['produk'] ?>" class="form-control" readonly>
                             </div>


                <div class="mb-3">
                <label for="basic-url" class="form-label">Quantity</label>
                <input type="text" value="<?= $row_pesanan['quantity'] ?>" class="form-control" readonly>
            </div>
            <?php if($row_pesanan['ukuran'] == '-' || $row_pesanan['warna'] == '-' ) { ?>
                <div class="mb-3">
                <label for="basic-url" class="form-label">Rasa</label>
                <input type="text" value="<?= $row_pesanan['rasa'] ?>" class="form-control" readonly>
            </div>
                        <?php } else { ?>
                            <div class="mb-3">
                <label for="basic-url" class="form-label">Ukuran (Warna)</label>
                <input type="text" value="<?= $row_pesanan['ukuran'] ?> (<?= $row_pesanan['warna'] ?> )" class="form-control" readonly>
            </div>
            <?php } ?>
            <div class="mb-3">
                <label for="basic-url" class="form-label">Harga</label>
                <input type="text" value="<?= number_format($row_pesanan['price'], 0, ',', '.'); ?>" class="form-control" readonly>
            </div>
            <div class="mb-3">
                        <label for="basic-url" class="form-label">Email</label>
                        <input type="text" value="<?= $row_pesanan['email'] ?>" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                    <label for="basic-url" class="form-label">Kontak</label>
                    <input type="text" value="<?= $row_pesanan['kontak'] ?>" class="form-control" readonly>
                </div>
            <div class="mb-3">
                <label for="basic-url" class="form-label">Alamat User</label>
            <textarea class="form-control" id="alamat" name="alamat"readonly><?= $row_pesanan['alamat'] ?></textarea>
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
    </div>


<?php
if(isset($_POST['setuju'])){
    $id_pesanan=$_POST['id_pesanan'];
    $update=mysqli_query($koneksi,"UPDATE pesanan SET
    admin='setuju'
    WHERE id='$id_pesanan'
    ");
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Di Setujui',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=admin-pesanan';
            }
            })</script>";
        } else {
            echo "<script>
            Swal.fire({title: 'Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
            }).then((result) => {if (result.value){
                window.location = '?page=admin-pesanan';
            }
        })</script>";
    }
}




  