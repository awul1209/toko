<div class="card card-info mt-3" id="card-data">
    <div class="card-header" style="background-color: #3498DB;">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-table"></i> Data Tentang Kami
        </h5>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div>
            <a href="?page=add-tentang-kami" class="btn" style="background-color: #3498DB; color: #fff;">
                <i class="fa fa-edit"></i> Tambah Data</a>
        </div>
        <div class="table-responsive">
            <br>
            <table id="example" class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    $result = mysqli_query($koneksi, 'SELECT * from tentang_kami');
                    while ($data = mysqli_fetch_assoc($result)) { ?>

                        <tr>
                            <td>
                                <?php echo $no++; ?>
                            </td>
                            <td>
                                <?php echo $data['deskripsi']; ?>
                            </td>

                            <td>
                                <div class="action d-flex">
                                    <a href="?page=edit-tentang&kode=<?php echo $data['id']; ?>" title="Ubah"
                                        class="">
                                        <img src="assets/img/icon_action/edit.png" alt="edit" width="35">
                                    </a>
                                    <a href="?page=del-tentang&kode=<?php echo $data['id']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" title="Hapus" class="mt-1">
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