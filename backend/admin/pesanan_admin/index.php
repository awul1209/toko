<div class="card card-info mt-3" id="card-data">
    <div class="card-header" style="background-color: #3498DB">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-table"></i> Data Pesanan
        </h5>
    </div>
    <!-- /.card-header -->
   <div class="card-body">
    <?php
    // Langkah 1: Jalankan query dan simpan semua hasilnya ke dalam array
    $query_pesanan = "SELECT pesanan.admin, user.alamat,pesanan.id AS id_pesanan, produk.id AS id_produk, seller.id AS id_toko, user.id as id_user, produk.gambar1, seller.nama_toko, produk.produk AS produk, pesanan.quantity, pesanan.ukuran, pesanan.warna, pesanan.rasa, pesanan.metode, pesanan.price, pesanan.tgl_pesanan, pesanan.status,pesanan.metode,pesanan.briva, user.email, user.kontak,pesanan.bukti FROM pesanan JOIN produk ON produk.id = pesanan.produk_id JOIN user ON user.id = pesanan.user_id JOIN seller ON seller.id = produk.seller_id WHERE pesanan.metode='Briva' AND (pesanan.admin = '' OR pesanan.admin = 'proses' OR pesanan.status='diterima') AND (pesanan.status ='menunggu pembayaran' OR pesanan.status='bayar' OR pesanan.status='proses'OR pesanan.status='di proses' OR pesanan.status='dikirim')";
    $hasil_query = mysqli_query($koneksi, $query_pesanan);
    
    $data_pesanan_admin = [];
    while ($row = mysqli_fetch_assoc($hasil_query)) {
        $data_pesanan_admin[] = $row;
    }

    if (empty($data_pesanan_admin)) {
        echo '<div class="alert alert-secondary text-center">Tidak ada pesanan yang perlu dikonfirmasi saat ini.</div>';
    }

    // Langkah 2: Loop pertama untuk membuat semua KARTU PESANAN
    foreach ($data_pesanan_admin as $row_pesanan) {
        // Logika untuk menentukan teks dan warna badge status
        $status_text = '';
        $status_class = '';
        switch ($row_pesanan['status']) {
            case 'proses': $status_text = 'Perlu Disetujui'; $status_class = 'bg-warning text-dark'; break;
            case 'bayar': case 'menunggu pembayaran': $status_text = 'Menunggu Pembayaran'; $status_class = 'bg-info'; break;
            case 'di proses': $status_text = 'Proses Pengiriman'; $status_class = 'bg-primary'; break;
            case 'dikirim': $status_text = 'Paket Dikirim'; $status_class = 'bg-success'; break;
            default: $status_text = ucfirst($row_pesanan['status']); $status_class = 'bg-secondary';
        }
    ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                <div>
                    <strong class="text-primary">#KDP-<?= $row_pesanan['id_pesanan'] ?></strong>
                    <span class="text-muted mx-2">|</span>
                    <small class="text-muted">Toko: <strong><?= htmlspecialchars($row_pesanan['nama_toko']) ?></strong></small>
                </div>
                <span class="badge rounded-pill <?= $status_class ?> fs-6"><?= $status_text ?></span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="d-flex mb-3">
                            <img src="../assets/img/produk/<?= $row_pesanan['gambar1'] ?>" class="rounded" alt="produk" style="width: 70px; height: 70px; object-fit: cover;">
                            <div class="ms-3">
                                <h5 class="card-title mb-1"><?= htmlspecialchars($row_pesanan['produk']) ?></h5>
                                <p class="card-text text-muted mb-1">
                                    Jumlah: <strong><?= $row_pesanan['quantity'] ?></strong> | Total: <strong class="text-danger">Rp.<?= number_format($row_pesanan['price'], 0, ',', '.'); ?></strong>
                                </p>
                            </div>
                        </div>
                        <p class="mb-1"><i class="fas fa-user-circle fa-fw me-2 text-muted"></i><strong>Pembeli:</strong> <?= htmlspecialchars($row_pesanan['email']) ?></p>
                        <p class="mb-0"><i class="fas fa-money-check-alt fa-fw me-2 text-muted"></i><strong>Metode Bayar:</strong> <?= htmlspecialchars($row_pesanan['metode']) ?> (<?= htmlspecialchars($row_pesanan['briva']) ?>)</p>
                    </div>
                    <div class="col-md-4 border-start ps-md-4 d-flex flex-column justify-content-center">
                        <div class="d-grid gap-2">
                            <?php if($row_pesanan['status'] == 'proses'){ ?>
                                <form action="" method="post" class="d-grid"><input type="hidden" name="id_pesanan" value="<?= $row_pesanan['id_pesanan'] ?>"><button type="submit" name="setuju" class="btn btn-success"><i class="fas fa-check-circle me-2"></i>Setujui & Proses</button></form>
                            <?php }elseif($row_pesanan['status']=='bayar' || $row_pesanan['status']=='menunggu pembayaran'){ ?>
                                <button class="btn btn-light border" disabled>Menunggu Pembayaran</button>
                            <?php }elseif($row_pesanan['status']=='di proses' && $row_pesanan['admin']=='proses'){ ?>
                                <button class="btn btn-light border" disabled><i class="fas fa-box-open me-2"></i>Siap Dikirim Penjual</button>
                            <?php }elseif($row_pesanan['status']=='dikirim'){ ?>
                                <button class="btn btn-light border" disabled><i class="fas fa-truck me-2"></i>Dalam Perjalanan</button>
                            <?php } ?>
                            <button data-bs-toggle="modal" data-bs-target="#modal_detail_admin<?= $row_pesanan['id_pesanan'] ?>" class="btn btn-outline-secondary"><i class="fas fa-eye me-2"></i>Lihat Detail</button>
                            <?php if($row_pesanan['bukti'] != ''){ ?>
                            <button data-bs-toggle="modal" data-bs-target="#modaldetailadmin<?= $row_pesanan['id_pesanan'] ?>" class="btn btn-outline-secondary"><i class="fas fa-eye me-2"></i>Bukti Pembayaran</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } // Akhir loop untuk kartu ?>
</div> <?php foreach ($data_pesanan_admin as $row_pesanan) { ?>
<div class="modal fade" id="modal_detail_admin<?= $row_pesanan['id_pesanan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan #KDP-<?= $row_pesanan['id_pesanan'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Pesan</label>
                            <input type="text" value="<?= date('d F Y, H:i', strtotime($row_pesanan['tgl_pesanan'])) ?>" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Produk</label>
                            <input type="text" value="<?= htmlspecialchars($row_pesanan['produk']) ?>" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Quantity</label>
                            <input type="text" value="<?= $row_pesanan['quantity'] ?>" class="form-control" readonly>
                        </div>
                        <?php if($row_pesanan['ukuran'] == '-' || $row_pesanan['warna'] == '-' ) { ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Rasa</label>
                                <input type="text" value="<?= htmlspecialchars($row_pesanan['rasa']) ?>" class="form-control" readonly>
                            </div>
                        <?php } else { ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ukuran (Warna)</label>
                                <input type="text" value="<?= htmlspecialchars($row_pesanan['ukuran']) ?> (<?= htmlspecialchars($row_pesanan['warna']) ?>)" class="form-control" readonly>
                            </div>
                        <?php } ?>
                         <div class="mb-3">
                            <label class="form-label fw-bold">Total Harga</label>
                            <input type="text" value="Rp. <?= number_format($row_pesanan['price'], 0, ',', '.'); ?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Pembeli</label>
                            <input type="text" value="<?= htmlspecialchars($row_pesanan['email']) ?>" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kontak</label>
                            <input type="text" value="<?= htmlspecialchars($row_pesanan['kontak']) ?>" class="form-control" readonly>
                        </div>
                         <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Pengiriman</label>
                            <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($row_pesanan['alamat']) ?></textarea>
                        </div>
                         <div class="mb-3">
                             <label class="form-label fw-bold">Bukti Pembayaran</label>
                            <center>
                                <img src="../assets/bukti/<?= $row_pesanan['bukti'] ?>" alt="Belum Bayar" style="max-width: 150px;">
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- modal detail lagi -->
 <div class="modal fade" id="modaldetailadmin<?= $row_pesanan['id_pesanan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
    <center>
                                <img src="../assets/bukti/<?= $row_pesanan['bukti'] ?>" alt="bukti" style="max-width: 350px;">
                            </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php } // Akhir loop untuk modal ?>

 <div class="card card-success mt-4" id="card-selesai">
    <div class="card-header">
        <h5 class="card-title">
            <i class="fa fa-check-circle"></i> Riwayat Pesanan Selesai (24 Jam Terakhir)
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="example2" class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>User</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Tanggal Pesanan</th>
                        <th>Tanggal Diterima</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Langkah 1: Ambil semua data dan simpan ke dalam array PHP
                    $query_selesai = "SELECT pesanan.id AS id_pesanan, produk.gambar1, pesanan.tgl_pesanan, user.email, produk.produk, pesanan.price, pesanan.metode,pesanan.quantity,pesanan.ukuran,pesanan.rasa,pesanan.warna,user.kontak,user.alamat, pesanan.briva,transaksi.created_at, seller.nama_toko FROM pesanan JOIN produk ON produk.id = pesanan.produk_id JOIN user ON user.id = pesanan.user_id JOIN seller ON seller.id = produk.seller_id JOIN transaksi ON transaksi.pesanan_id=pesanan.id WHERE pesanan.status = 'selesai' AND transaksi.created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY transaksi.created_at DESC";
                    $hasil_query = mysqli_query($koneksi, $query_selesai);
                    $data_pesanan_selesai = [];
                    while ($row = mysqli_fetch_assoc($hasil_query)) {
                        $data_pesanan_selesai[] = $row;
                    }

                    // Langkah 2: Loop pertama untuk membuat baris tabel
                    $no_selesai = 1;
                    foreach ($data_pesanan_selesai as $row_selesai) { ?>
                    <tr>
                        <td><?= $no_selesai++; ?></td>
                        <td><img src="../assets/img/produk/<?= $row_selesai['gambar1'] ?>" alt="icon" width="100px"></td>
                        <td><?= $row_selesai['email'] ?></td>
                        <td><?= $row_selesai['produk'] ?></td>
                        <td>Rp.<?= number_format($row_selesai['price'], 0, ',', '.'); ?></td>
                        <td>
                            <?= $row_selesai['metode'] ?><br>
                            (<?= $row_selesai['briva'] ?>)
                        </td>
                        <td><?= $row_selesai['tgl_pesanan'] ?></td>
                        <td><?= $row_selesai['created_at'] ?></td>
                        <td>
                             <button class="badge bg-success border-0 m-1" disabled>Pesanan Selesai</button>
                             <button data-bs-toggle="modal" data-bs-target="#modal_detail_admin<?= $row_selesai['id_pesanan'] ?>" class="badge bg-warning border-0">Detail</button>
                        </td>
                    </tr>
                    <?php } // Akhir loop untuk tabel ?>
                </tbody>
            </table>
        </div> </div> </div> <?php foreach ($data_pesanan_selesai as $row_selesai) { ?>
<div class="modal fade" id="modal_detail_admin<?= $row_selesai['id_pesanan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Pesanan <?= $row_selesai['nama_toko'] ?? '' ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kode Transaksi</label>
                    <input type="text" value="KDP<?= $row_selesai['id_pesanan'] ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pesan</label>
                    <input type="text" value="<?= $row_selesai['tgl_pesanan'] ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Produk</label>
                    <input type="text" value="<?= $row_selesai['produk'] ?>" class="form-control" readonly>
                </div>
                 <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="text" value="<?= $row_selesai['quantity'] ?>" class="form-control" readonly>
                </div>
                <?php if($row_selesai['ukuran'] == '-' || $row_selesai['warna'] == '-' ) { ?>
                    <div class="mb-3">
                        <label class="form-label">Rasa</label>
                        <input type="text" value="<?= $row_selesai['rasa'] ?>" class="form-control" readonly>
                    </div>
                <?php } else { ?>
                    <div class="mb-3">
                        <label class="form-label">Ukuran (Warna)</label>
                        <input type="text" value="<?= $row_selesai['ukuran'] ?> (<?= $row_selesai['warna'] ?> )" class="form-control" readonly>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="text" value="Rp. <?= number_format($row_selesai['price'], 0, ',', '.'); ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" value="<?= $row_selesai['email'] ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" value="<?= $row_selesai['kontak'] ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat User</label>
                    <textarea class="form-control" readonly><?= $row_selesai['alamat'] ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php } // Akhir loop untuk modal ?>

    </div>


<?php
if(isset($_POST['setuju'])){
    $id_pesanan=$_POST['id_pesanan'];
    $update=mysqli_query($koneksi,"UPDATE pesanan SET
    status='di proses',
    admin='proses'
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





  