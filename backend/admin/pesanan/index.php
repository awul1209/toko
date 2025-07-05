
<!-- Pesanan Saya -->
<div class="pesanan-seller mt-4">
    <h3 class="mb-3">Pesanan Masuk</h3>
    
    <div id="realtime-pesanan">
        </div>
</div>



<!-- pengembalian -->
 <?php
// Pastikan Anda sudah memiliki koneksi database ($koneksi) di sini
// Contoh: include 'koneksi.php'; atau require_once 'config.php';

// --- Ambil Seller ID yang Sedang Login ---
// Ganti ini dengan cara Anda mendapatkan seller_id dari sesi atau autentikasi
$logged_in_seller_id = $ses_id; // Contoh: $_SESSION['seller_id']; // GANTI DENGAN ID SELLER YANG LOGIN SEBENARNYA!

// --- Proses Aksi Setujui atau Tolak Pengembalian ---
if (isset($_POST['setujui_pengembalian'])) {
    $pengembalian_id = mysqli_real_escape_string($koneksi, $_POST['pengembalian_id']);

    $update_query = "UPDATE pengembalian SET status_pengembalian = 'disetujui_penjual',nomor_resi_pengembalian='NORES12346', updated_at = NOW() WHERE id = '$pengembalian_id' AND seller_id = '$logged_in_seller_id'";
    $update_result = mysqli_query($koneksi, $update_query);

    if ($update_result) {
        echo "<script>
            Swal.fire({title: 'Berhasil!',text: 'Pengajuan pengembalian disetujui.',icon: 'success',confirmButtonText: 'OK'})
            .then((result) => {if (result.value){  window.location = '?page=data-pesanan';  }});
            </script>";
    } else {
        echo "<script>
            Swal.fire({title: 'Error!',text: 'Gagal menyetujui pengembalian: " . mysqli_error($koneksi) . "',icon: 'error',confirmButtonText: 'OK'});
            </script>";
    }
}

if (isset($_POST['tolak_pengembalian'])) {
    $pengembalian_id = mysqli_real_escape_string($koneksi, $_POST['id_pengembalian_tolak']); // ID dari modal
    $catatan_penolakan = mysqli_real_escape_string($koneksi, $_POST['catatan_penolakan']);

    $update_query = "UPDATE pengembalian SET status_pengembalian = 'ditolak_penjual', catatan_penolakan = '$catatan_penolakan', updated_at = NOW() WHERE id = '$pengembalian_id' AND seller_id = '$logged_in_seller_id'";
    $update_result = mysqli_query($koneksi, $update_query);

    if ($update_result) {
        echo "<script>
            Swal.fire({title: 'Berhasil!',text: 'Pengajuan pengembalian ditolak.',icon: 'success',confirmButtonText: 'OK'})
            .then((result) => {if (result.value){  window.location = '?page=data-pesanan'; }});
            </script>";
    } else {
        echo "<script>
            Swal.fire({title: 'Error!',text: 'Gagal menolak pengembalian: " . mysqli_error($koneksi) . "',icon: 'error',confirmButtonText: 'OK'});
            </script>";
    }
}

// --- Query untuk Mengambil Data Pengembalian untuk Penjual ---
// Ambil semua pengajuan pengembalian yang ditujukan ke toko penjual yang sedang login
$query_pengembalian_penjual = "
    SELECT
        p.id AS pengembalian_id,
        p.pesanan_id,
        p.alasan,
        p.bukti_foto,
        p.status_pengembalian,
        p.catatan_penolakan,
        p.nomor_resi_pengembalian,
        p.created_at AS tanggal_pengajuan,
        ps.quantity,
        ps.price,
        ps.ukuran,
        ps.warna,
        ps.rasa,
        pr.produk,
        pr.gambar1 AS gambar_produk,
        u.nama AS nama_pembeli -- Asumsi ada tabel user dengan kolom nama
    FROM
        pengembalian p
    JOIN
        pesanan ps ON p.pesanan_id = ps.id
    JOIN
        produk pr ON ps.produk_id = pr.id
    JOIN
        user u ON p.user_id = u.id -- JOIN ke tabel user untuk mendapatkan nama pembeli
    WHERE
        p.seller_id = '$logged_in_seller_id' AND status_pengembalian != 'barang_diterima_penjual' AND  status_pengembalian != 'ditolak_penjual'
    ORDER BY
        p.created_at DESC;
";

$result_pengembalian_penjual = mysqli_query($koneksi, $query_pengembalian_penjual);

if (!$result_pengembalian_penjual) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<div class="card card-info mt-3" id="card-data">
    <div class="card-header" style="background-color: #3498DB">
        <h5 class="card-title" style="color: #fff;">
            <i class="fa fa-table"></i> Pengembalian 
        </h5>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="font-size:14px;">No</th>
                    <th style="font-size:14px;">ID Pengajuan</th>
                    <th style="font-size:14px;">ID Pesanan</th>
                    <th style="font-size:14px;">Pembeli</th>
                    <th style="font-size:14px;">Gambar Produk</th>
                    <th style="font-size:14px;">Nama Produk</th>
                    <th style="font-size:14px;">Jumlah</th>
                    <th style="font-size:14px;">Ukuran</th>
                    <th style="font-size:14px;">Warna</th>
                    <th style="font-size:14px;">Rasa</th>
                    <th style="font-size:14px;">Harga Satuan</th>
                    <th style="font-size:14px;">Alasan Pengajuan</th>
                    <th style="font-size:14px;">Bukti Foto</th>
                    <th style="font-size:14px;">No. Resi Pengembalian</th>
                    <th style="font-size:14px;">Status</th>
                    <th style="font-size:14px;">Catatan Penolakan</th>
                    <th style="font-size:14px;">Tanggal Pengajuan</th>
                    <th style="font-size:14px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result_pengembalian_penjual) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result_pengembalian_penjual)) {
                ?>
                        <tr>
                            <td style="font-size:14px;"><?php echo $no++; ?></td>
                            <td style="font-size:14px;"><?php echo htmlspecialchars($row['pengembalian_id']); ?></td>
                            <td style="font-size:14px;"><?php echo htmlspecialchars($row['pesanan_id']); ?></td>
                            <td style="font-size:14px;"><?php echo htmlspecialchars($row['nama_pembeli']); ?></td>
                            <td style="font-size:14px;">
                                <?php if (!empty($row['gambar_produk'])) : ?>
                                    <img src="../assets/img/produk/<?php echo htmlspecialchars($row['gambar_produk']); ?>" alt="Produk" style="width: 70px; height: 70px; object-fit: cover;">
                                <?php else : ?>
                                    Tidak Ada Gambar
                                <?php endif; ?>
                            </td>
                            <td style="font-size:14px;"><?php echo htmlspecialchars($row['produk']); ?></td>
                            <td style="font-size:14px;"><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td style="font-size:14px;"><?php echo htmlspecialchars($row['ukuran']); ?></td>
                            <td style="font-size:14px;"><?php echo htmlspecialchars($row['warna']); ?></td>
                            <td style="font-size:14px;"><?php echo htmlspecialchars($row['rasa']); ?></td>
                            <td style="font-size:14px;"><?php echo 'Rp ' . number_format($row['price'], 0, ',', '.'); ?></td>
                            <td style="font-size:14px;"><?php echo htmlspecialchars(substr($row['alasan'], 0, 100)) . (strlen($row['alasan']) > 100 ? '...' : ''); ?></td>
                            <td>
                                <?php if (!empty($row['bukti_foto'])) : ?>
                                    <a href="../<?php echo htmlspecialchars($row['bukti_foto']); ?>" target="_blank">Lihat Bukti</a>
                                <?php else : ?>
                                    Tidak Ada
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo !empty($row['nomor_resi_pengembalian']) ? htmlspecialchars($row['nomor_resi_pengembalian']) : '-'; ?>
                            </td>
                            <td>
                                <?php
                                $status = htmlspecialchars($row['status_pengembalian']);
                                $badge_class = '';
                                switch ($status) {
                                    case 'diajukan':
                                        $badge_class = 'bg-warning text-dark'; // Kuning untuk diajukan
                                        break;
                                    case 'disetujui_penjual':
                                        $badge_class = 'bg-success'; // Hijau
                                        break;
                                    case 'ditolak_penjual':
                                        $badge_class = 'bg-danger'; // Merah
                                        break;
                                    default:
                                        $badge_class = 'bg-secondary'; // Abu-abu
                                        break;
                                }
                                echo '<span class="badge ' . $badge_class . '">' . ucfirst(str_replace('_', ' ', $status)) . '</span>';
                                ?>
                            </td>
                            <td>
    <?php
    // Gunakan trim() untuk membersihkan spasi sebelum mengecek empty()
    $catatan_penolakan = trim($row['catatan_penolakan']);

    if (!empty($catatan_penolakan)) {
        // Tampilkan tombol "View" jika ada catatan
        // data-bs-target menunjuk ke ID modal yang unik untuk setiap pengembalian
        echo '<button class="badge text-white border-0" style="background-color:#8a38e4;" data-bs-toggle="modal" data-bs-target="#modal_view_penolakan' . htmlspecialchars($row['pengembalian_id']) . '">View</button>';
    } else {
        echo '-'; // Tampilkan '-' jika catatan kosong
    }
    ?>
</td>
                            <td style="font-size:14px;"><?php echo date('d M Y H:i', strtotime($row['tanggal_pengajuan'])); ?></td>
                            <td>
                                <?php if ($row['status_pengembalian'] == 'diajukan') { ?>
                                    <form action="" method="post" class="d-inline">
                                        <input type="hidden" name="pengembalian_id" value="<?php echo htmlspecialchars($row['pengembalian_id']); ?>">
                                        <button type="submit" name="setujui_pengembalian" class="btn btn-success btn-sm me-1 mb-1" onclick="return confirm('Apakah Anda yakin ingin MENYETUJUI pengajuan ini?');">Setujui</button>
                                    </form>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolakPengembalian" data-id="<?php echo htmlspecialchars($row['pengembalian_id']); ?>">Tolak</button>
                                <?php } elseif($row['status_pengembalian'] == 'disetujui_penjual'){  ?>
                                    <span class="text-muted">Telah Diproses</span>
                        <?php } elseif($row['status_pengembalian'] == 'barang_dikirim_pembeli'){ ?>
                            <form action="" method="post">
                            <input type="hidden" name='id_pengembalian' value="<?= $row['pengembalian_id'] ?>">
                            <input type="hidden" name='id_pesanan' value="<?= $row['pesanan_id'] ?>">
                            <button type="submit" name="terima-barang" class="badge bg-primary border-0 mt-1">Terima Barang</button>
                            </form>
                        <?php } ?>
                            </td>
                        </tr>

                           <!-- Modal view -->
<div class="modal fade" id="modal_view_penolakan<?= $row['pengembalian_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Pengembalian Anda Di Tolak</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="kotak-rating-dashboard modal-body">
      <h2 class="mb-4 text-center">Berikut Keterangannya</h2>
      <textarea class="form-control" name="" id="" readonly><?= $row['catatan_penolakan'] ?></textarea>
     
    </div>
  </div>
</div>
</div>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="18" class="text-center">Belum ada pengajuan pengembalian produk dari pembeli.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTolakPengembalian" tabindex="-1" aria-labelledby="modalTolakPengembalianLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTolakPengembalianLabel">Tolak Pengajuan Pengembalian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_pengembalian_tolak" id="id_pengembalian_tolak">
                    <div class="mb-3">
                        <label for="catatan_penolakan" class="form-label">Keterangan Penolakan</label>
                        <textarea class="form-control" id="catatan_penolakan" name="catatan_penolakan" rows="4" placeholder="Berikan alasan penolakan secara jelas..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tolak_pengembalian" class="btn btn-danger">Tolak Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalTolak = document.getElementById('modalTolakPengembalian');
        modalTolak.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            var pengembalianId = button.getAttribute('data-id');

            // Update the modal's content.
            var modalInputId = modalTolak.querySelector('#id_pengembalian_tolak');
            modalInputId.value = pengembalianId;
        });
    });
</script>
<!-- end pengembalian -->




<!-- riwayat pesanan -->
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
                        <th>Action</th> 
                    </tr>
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




    </div>

    <!-- /.card-body -->



<!-- Modal -->
<div class="modal fade" id="modal_tolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTolakLabel">Tolak Pesanan</h1> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="keteranganTolak" class="form-label">Keterangan Penolakan</label>
                        <textarea class="form-control" id="keteranganTolak" name="keterangan" rows="3" required></textarea>
                        <input type="hidden" name="id_pesanan_tolak" id="id_pesanan_tolak">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> <button type="submit" name="tolak" class="btn btn-primary">Tolak Pesanan</button> </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {

    var sellerId = $ses_id;

    // Fungsi untuk memuat data pesanan
    function loadPesananData() {
        $.ajax({
            url: 'realtime_pesanan_selesai.php', 
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Dapatkan elemen modal Detail Pesanan
        var modalDetailPesanan = document.getElementById('modalDetailPesanan');

        // Tambahkan event listener saat modal akan ditampilkan
        modalDetailPesanan.addEventListener('show.bs.modal', function (event) {
            // Dapatkan tombol yang memicu modal
            var button = event.relatedTarget;

            // Dapatkan semua data dari atribut data-* tombol
            var idPesanan = button.getAttribute('data-idpesanan');
            var produk = button.getAttribute('data-produk');
            var user = button.getAttribute('data-user');
            var kontak = button.getAttribute('data-kontak');
            var alamat = button.getAttribute('data-alamat');
            var tglPesan = button.getAttribute('data-tglpesan');
            var tglSelesai = button.getAttribute('data-tglselesai');
            var total = button.getAttribute('data-total');
            var quantity = button.getAttribute('data-quantity');
            var varian = button.getAttribute('data-varian');
            var metode = button.getAttribute('data-metode');

            // Dapatkan elemen <span> di dalam modal tempat data akan ditampilkan
            var spanIdPesanan = modalDetailPesanan.querySelector('#detail-idpesanan');
            var spanProduk = modalDetailPesanan.querySelector('#detail-produk');
            var spanUser = modalDetailPesanan.querySelector('#detail-user');
            var spanKontak = modalDetailPesanan.querySelector('#detail-kontak');
            var spanAlamat = modalDetailPesanan.querySelector('#detail-alamat');
            var spanTglPesan = modalDetailPesanan.querySelector('#detail-tglpesan');
            var spanTglSelesai = modalDetailPesanan.querySelector('#detail-tglselesai');
            var spanTotal = modalDetailPesanan.querySelector('#detail-total');
            var spanQuantity = modalDetailPesanan.querySelector('#detail-quantity');
            var spanVarian = modalDetailPesanan.querySelector('#detail-varian');
            var spanMetode = modalDetailPesanan.querySelector('#detail-metode');

            // Isi elemen <span> dengan data yang diambil
            spanIdPesanan.textContent = idPesanan;
            spanProduk.textContent = produk;
            spanUser.textContent = user;
            spanKontak.textContent = kontak;
            spanAlamat.textContent = alamat;
            spanTglPesan.textContent = tglPesan;
            spanTglSelesai.textContent = tglSelesai;
            spanTotal.textContent = total;
            spanQuantity.textContent = quantity;
            spanVarian.textContent = varian;
            spanMetode.textContent = metode;

            // Opsional: Jika Anda ingin mengubah judul modal secara dinamis
            // var modalTitle = modalDetailPesanan.querySelector('.modal-title');
            // modalTitle.textContent = 'Detail Pesanan: ' + idPesanan;
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modalTolak = document.getElementById('modal_tolak'); // Dapatkan elemen modal

        // Tambahkan event listener saat modal akan ditampilkan
        modalTolak.addEventListener('show.bs.modal', function (event) {
            // Dapatkan tombol yang memicu modal
            var button = event.relatedTarget;

            // Dapatkan nilai data-id dari tombol tersebut
            var idPesanan = button.getAttribute('data-id');

            // Set nilai input hidden di dalam modal
            var inputIdPesanan = modalTolak.querySelector('#id_pesanan_tolak');
            inputIdPesanan.value = idPesanan;

            // Opsional: Jika Anda ingin mengubah judul modal secara dinamis
            var modalTitle = modalTolak.querySelector('.modal-title');
            modalTitle.textContent = 'Tolak Pesanan ID: ' + idPesanan;
        });
    });
</script>

<script>
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
        Swal.fire({title: 'Di Batalkan',text: 'Pesanan Berhasil di Tolak',icon: 'success',confirmButtonText: 'OK'
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

// pengembalian
if (isset($_POST['terima-barang'])) {
    $id_pengembalian = $_POST['id_pengembalian'];
    $id_pesanan = $_POST['id_pesanan'];
    $update = mysqli_query($koneksi, "UPDATE pengembalian SET
    status_pengembalian='barang_diterima_penjual'
    WHERE id='$id_pengembalian'");
    if ($update) {
        mysqli_query($koneksi,"DELETE FROM transaksi WHERE id='$id_pesanan'");
         mysqli_query($koneksi, "UPDATE pesanan SET returnn=2 WHERE id='$id_pesanan'");
        echo "<script>
        Swal.fire({title: 'Setujui Pembatalan',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=data-pesanan';
            }
            })</script>";
    }
}
?>