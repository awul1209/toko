<div class="card card-info mt-3" id="card-data">
    <div class="card-header" style="background-color:#3498DB;">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-table"></i> Data Seller
        </h5>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <a href="?page=add-seller" class="btn" style="background-color:#3498DB; color: #fff;">
                <i class="fa fa-edit"></i> Tambah Data</a>
        </div>
        <div class="table-responsive">
            <br>
            <table id="example" class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Toko</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Kontak</th>
                        <th class="text-center">Password</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    $result = mysqli_query($koneksi, 'SELECT * from seller');
                    while ($data = mysqli_fetch_assoc($result)) { ?>

                        <tr>
                            <td class="text-center">
                                <?php echo $no++; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['nama']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['email']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['nama_toko']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['deskripsi_toko']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['alamat']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['kontak']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['password']; ?>
                            </td>
                            <td class="text-center">
                                <div class="action d-flex">
                                    <a href="?page=edit-seller&kode=<?php echo $data['id']; ?>&seller=0" title="Ubah"
                                        class="">
                                        <img src="assets/img/icon_action/edit.png" alt="edit" width="35">
                                    </a>
                                    <a href="?page=del-seller&kode=<?php echo $data['id']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" title="Hapus" class="mt-1">
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