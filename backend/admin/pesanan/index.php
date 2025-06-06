
<!-- Pesanan Saya -->
<div class="pesanan-seler mt-4">
            <h3>Pesanan Masuk</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr >
                            <th style="background-color:#eaeaea">No</th>
                            <th style="background-color:#eaeaea">Gambar</th>
                            <th style="background-color:#eaeaea">Produk</th>
                            <th style="background-color:#eaeaea">User</th>
                            <th style="background-color:#eaeaea">Kontak</th>
                            <th style="background-color:#eaeaea">Tanggal Pesanan</th>
                            <th style="background-color:#eaeaea">Jumlah</th>
                            <th style="background-color:#eaeaea">Warna (Ukuran) / Rasa</th>
                            <th style="background-color:#eaeaea">Total</th>
                            <th style="background-color:#eaeaea">Metode</th>
                            <th style="background-color:#eaeaea">Alamat</th>
                            <th style="background-color:#eaeaea">Action</th>
                        </tr>
                    </thead>
                    <tbody id="realtime-pesanan">
                        
                    </tbody>
                </table>
            </div>
</div>


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
                            <th>Produk</th>
                            <th>User</th>
                            <th>Kontak</th>
                            <th>Tanggal Pesanan</th>
                            <th>Jumlah</th>
                            <th>Warna (Ukuran) / Rasa</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Action</th>
                    </tr>
                </thead>
                <tbody id="realtime-pesanan-selesai">

                      
                </tbody>
                </tfoot>
            </table>
        </div>
    </div>
    </div>

    <!-- /.card-body -->



<!-- Modal -->
<div class="modal fade" id="modal_tolak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="post">
      <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Keterangan</label>
  <textarea class="form-control" name="keterangan" rows="3"></textarea>
  <input type="hidden" name="id_pesanan_tolak" id="id_pesanan_tolak">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"><a class="text-decoration-none text-white" href="?page=data-pesanan">Close</a></button>
        <button type="submit" name="tolak" class="btn btn-primary">Tolak</button>
      </div>
    </form>
    </div>
  </div>
</div>





<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function(event) {
      if (event.target && event.target.id === 'btn_tolak') {
        var pesananId = event.target.getAttribute('data-id');
        document.getElementById('id_pesanan_tolak').value = pesananId;

        var myModal = new bootstrap.Modal(document.getElementById('modal_tolak'));
        myModal.show();
      }
    });
  });
</script>
<!-- <script>
  document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function(event) {
      if (event.target && event.target.id === 'btn_detail') {
        var pesananId = event.target.getAttribute('data-id');
        document.getElementById('id_pesanan_detail').value = pesananId;

        var myModal = new bootstrap.Modal(document.getElementById('modal_detail'));
        myModal.show();
      }
    });
  });
</script>
  -->


        <script>
        $('document').ready(function() {
        setInterval(function() {
        getRealtime();
        }, 1000); //dua detik
        });
        function getRealtime() {
        var ses_id = <?php echo json_encode($ses_id); ?>;  // Ambil $ses_id dari PHP dan simpan di JavaScript

        $.ajax({
        url: "realtime_pesanan.php",
        type: "GET",
        data: { ses_id: ses_id },  // Mengirim parameter ses_id ke realtime_pesanan.php
        success: function($response) {
        $("#realtime-pesanan").html($response);  // Menampilkan hasil ke elemen dengan id "realtime-pesanan"
        }
        });
        }
        </script>

        <script>
        $('document').ready(function() {
        setInterval(function() {
        getRealtimeSelesai();
        }, 1000); //dua detik
        });
        function getRealtimeSelesai() {
        var ses_id = <?php echo json_encode($ses_id); ?>;  // Ambil $ses_id dari PHP dan simpan di JavaScript

        $.ajax({
        url: "realtime_pesanan_selesai.php",
        type: "GET",
        data: { ses_id: ses_id },  // Mengirim parameter ses_id ke realtime_pesanan.php
        success: function($response) {
        $("#realtime-pesanan-selesai").html($response);  // Menampilkan hasil ke elemen dengan id "realtime-pesanan"
        }
        });
        }
        </script>







<?php
// terima
if (isset($_POST['terima'])) {
    $id = $_POST['id_pesanan'];
    $update = mysqli_query($koneksi, "UPDATE pesanan set status='di proses' WHERE id='$id'");
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Di Terima',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=data-pesanan';
            }
            })</script>";
    }
}


// tolak
if (isset($_POST['tolak'])) {
    $id = $_POST['id_pesanan_tolak'];
    $keterangan = $_POST['keterangan'];
    $update = mysqli_query($koneksi, "UPDATE pesanan SET
    quantity=0,
    status='ditolak',
    keterangan='$keterangan'
    WHERE id='$id'");
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Di Batalkan',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=data-pesanan';
            }
            })</script>";
    }
}

// persetujuan pembatalan
if (isset($_POST['pembatalan'])) {
    $id = $_POST['id_pesanan'];
    $update = mysqli_query($koneksi, "UPDATE pesanan SET
     quantity=0,
    status='di batalkan'
    WHERE id='$id'");
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Setujui Pembatalan',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=data-pesanan';
            }
            })</script>";
    }
}

// proses kirim
if (isset($_POST['kirim'])) {
    $id = $_POST['id_pesanan'];
    $update = mysqli_query($koneksi, "UPDATE pesanan SET
    status='dikirim'
    WHERE id='$id'");
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Sukses dikirim',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=data-pesanan';
            }
            })</script>";
    }
}

// pesanan selesai
if (isset($_POST['selesai'])) {
    $id = $_POST['id_pesanan'];
    $update = mysqli_query($koneksi, "UPDATE pesanan SET
    status='selesai'
    WHERE id='$id'");
    mysqli_query($koneksi,"INSERT INTO transaksi (pesanan_id) VALUES ('$id')");
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Pesanan Selesai',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=data-pesanan';
            }
            })</script>";
    }
}
?>