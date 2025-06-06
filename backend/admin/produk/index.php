<div class="card card-info mt-3" id="card-data">
    <div class="card-header" style="background-color:#3498DB;">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-table"></i> Data Produk
        </h5>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <a href="?page=add-produk" class="btn" style="background-color:#3498DB; color: #fff;">
                <i class="fa fa-edit"></i> Tambah Data</a>
        </div>
        <div class="table-responsive">
            <br>
            <table id="example" class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Toko</th>
                        <th class="text-center">Produk</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Ukuran</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Rasa</th>
                        <th class="text-center">Pembayaran</th>
                        <th class="text-center">Briva</th>
                        <th class="text-center">Diskon</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Gambar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $no = 1;
                    if($role == 'admin'){
                    $result = mysqli_query($koneksi, 'SELECT 
                    p.id AS produk_id,
                    s.id AS seller_id,
                    p.*,
                    s.*
                  FROM produk p
                  JOIN seller s ON p.seller_id = s.id');
                    }else{
                        $result = mysqli_query($koneksi, "SELECT 
                    p.id AS produk_id,
                    s.id AS seller_id,
                    p.*,
                    s.*
                  FROM produk p
                  JOIN seller s ON p.seller_id = s.id WHERE seller_id='$ses_id'");
                    }
                    while ($data = mysqli_fetch_assoc($result)) { ?>

                        <tr>
                            <td class="text-center">
                                <?php echo $no++; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['nama_toko']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['produk']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['kategori']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['harga']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['stock']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['ukuran']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['warna']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['rasa']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['metode']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['briva']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['diskon']; ?>
                            </td>
                            <td class="text-center">
                                <?php
                                $deskripsi = $data['deskripsi'];;
                                echo implode(' ', array_slice(explode(' ', $deskripsi), 0, 10)) . '...';
                                ?>
                                
                            </td>
                            <td class="text-center d-flex">
                                <img src="../assets/img/produk/<?php echo $data['gambar1']; ?>" alt="" width="50px">
                                <img src="../assets/img/produk/<?php echo $data['gambar2']; ?>" alt="" width="50px">
                                <img src="../assets/img/produk/<?php echo $data['gambar3']; ?>" alt="" width="50px">
                            </td>
                            <td class="text-center">
                                <div class="action d-flex">
                                    <a href="?page=edit-produk&kode=<?php echo $data['produk_id']; ?>" title="Ubah"
                                        class="">
                                        <img src="assets/img/icon_action/edit.png" alt="edit" width="35">
                                    </a>
                                    <a href="?page=del-produk&kode=<?php echo $data['produk_id']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" title="Hapus" class="mt-1">
                                        <img src="assets/img/icon_action/trash.png" alt="trash" width="28">
                                    </a>
                                </div>
                            </td>

                        </tr>

                    <?php
                    }
                    ?>
                   
                </tbody>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- /.card-body -->