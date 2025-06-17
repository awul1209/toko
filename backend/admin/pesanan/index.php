
<!-- Pesanan Saya -->
<div class="pesanan-seller mt-4">
    <h3 class="mb-3">Pesanan Masuk</h3>
    
    <div id="realtime-pesanan">
        </div>
</div>


<div class="card card-info mt-3" id="card-data">
    <div class="card-header" style="background-color: #3498DB">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-table"></i> Riwayat Pesanan
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Produk</th>
                        <th>User</th>
                        <th>Tanggal Pesanan</th>
                        <th>Jumlah</th>
                        <th>Varian</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Action</th> </tr>
                </thead>
                <tbody id="realtime-pesanan-selesai">
                    </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailPesanan" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Kode Transaksi:</strong> <span id="detail-idpesanan">-</span></p>
                        <p><strong>Produk:</strong> <span id="detail-produk">-</span></p>
                        <p><strong>Varian:</strong> <span id="detail-varian">-</span></p>
                        <p><strong>Jumlah:</strong> <span id="detail-quantity">-</span></p>
                        <p><strong>Total Harga:</strong> <span id="detail-total" class="fw-bold text-danger">-</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Pemesan:</strong> <span id="detail-user">-</span></p>
                        <p><strong>Kontak:</strong> <span id="detail-kontak">-</span></p>
                        <p><strong>Tanggal Pesan:</strong> <span id="detail-tglpesan">-</span></p>
                        <p><strong>Tanggal Selesai:</strong> <span id="detail-tglselesai">-</span></p>
                         <p><strong>Metode Bayar:</strong> <span id="detail-metode">-</span></p>
                    </div>
                </div>
                <hr>
                <p><strong>Alamat Pengiriman:</strong></p>
                <p><span id="detail-alamat">-</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Ambil session ID penjual (ses_id). Anda harus mengisinya dari sesi PHP.
    // Contoh: var sellerId = <?php echo $_SESSION['seller_id']; ?>;
    // Untuk sementara kita hardcode, GANTI DENGAN ID SELLER YANG LOGIN
    var sellerId = 1; // <-- GANTI INI DENGAN ID SELLER DARI SESI PHP

    // Fungsi untuk memuat data pesanan
    function loadPesananData() {
        $.ajax({
            url: 'realtime_pesanan_histori.php', // Sesuaikan dengan nama file real-time Anda
            type: 'GET',
            data: { ses_id: sellerId },
            success: function(data) {
                $('#realtime-pesanan-selesai').html(data);
            },
            error: function(xhr, status, error) {
                console.error("Gagal memuat data:", error);
            }
        });
    }

    // Panggil fungsi pertama kali saat halaman dimuat
    loadPesananData();

    // Set interval untuk memuat ulang data setiap 30 detik (30000 milidetik)
    setInterval(loadPesananData, 30000);

    // Event listener untuk tombol detail
    // Menggunakan event delegation karena tombol dibuat secara dinamis
    $('#realtime-pesanan-selesai').on('click', '.btn-detail', function() {
        // Ambil data dari atribut data-* tombol yang diklik
        var idpesanan = $(this).data('idpesanan');
        var produk = $(this).data('produk');
        var user = $(this).data('user');
        var kontak = $(this).data('kontak');
        var alamat = $(this).data('alamat');
        var tglpesan = $(this).data('tglpesan');
        var tglselesai = $(this).data('tglselesai');
        var total = $(this).data('total');
        var quantity = $(this).data('quantity');
        var varian = $(this).data('varian');
        var metode = $(this).data('metode');

        // Masukkan data ke dalam elemen-elemen di modal
        $('#detail-idpesanan').text(idpesanan);
        $('#detail-produk').text(produk);
        $('#detail-user').text(user);
        $('#detail-kontak').text(kontak);
        $('#detail-alamat').text(alamat);
        $('#detail-tglpesan').text(tglpesan);
        $('#detail-tglselesai').text(tglselesai);
        $('#detail-total').text(total);
        $('#detail-quantity').text(quantity);
        $('#detail-varian').text(varian);
        $('#detail-metode').text(metode);
    });
});
</script>

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
    $q_status=mysqli_query($koneksi,"SELECT status FROM pesanan WHERE id='$id'");
    $row_status=mysqli_fetch_assoc($q_status);
    $status=$row_status['status'];
    if($status=='menunggu pembayaran'){
      $update = mysqli_query($koneksi, "UPDATE pesanan set status='bayar' WHERE id='$id'");
    }else{
      $update = mysqli_query($koneksi, "UPDATE pesanan set status='di proses' WHERE id='$id'");
    }
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
  // Tentukan format tanggal yang diinginkan (Tahun-Bulan-Hari)
$formatTanggal = 'Y-m-d';

// Gunakan strtotime untuk menambahkan 1 hari ke tanggal "sekarang"
$estimasiHariSelanjutnya = date($formatTanggal, strtotime('+1 day'));
    $id = $_POST['id_pesanan'];
    $update = mysqli_query($koneksi, "UPDATE pesanan SET
    status='dikirim',
    estimasi='$estimasiHariSelanjutnya' 
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