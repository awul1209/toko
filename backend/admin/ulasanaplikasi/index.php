<div class="card card-info mt-3" id="card-data">
    <div class="card-header" style="background-color: #3498DB;">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-table"></i> Ulasan Produk
        </h5>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <br>
            <table id="example" class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Rating</th>
                        <th class="text-center">Komentar</th>
                        <th class="text-center">Waktu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                        $result = mysqli_query($koneksi, "SELECT rating.id,user.nama,user.email, rating.rating,rating.komentar,rating.created_at,rating.updated_at FROM `rating` JOIN user ON rating.user_id=user.id");
                    while ($data = mysqli_fetch_assoc($result)) { ?>

                        <tr>
                            <td class="text-center">
                                <?php echo $no++; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['email']; ?>
                            </td>
                            <td class="text-center">⭐ 
                                <?php echo $data['rating']; ?> / 5
                            </td>
                            <td class="text-center">
                                <?php echo $data['komentar']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $data['created_at']; ?>
                            </td>

                            <td>
                                <div class="action d-flex">
                                    <!-- <a href="?page=edit-ulasan&kode=<?php echo $data['id']; ?>" title="Ubah"
                                        class="">
                                        <img src="assets/img/icon_action/edit.png" alt="edit" width="35">
                                    </a> -->
                                    <a href="?page=del-ulasan&kode=<?php echo $data['id']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" title="Hapus" class="mt-1">
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