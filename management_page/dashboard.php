    <!-- leaflet -->
         <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>


    <!-- end leaflet -->
<?php
$query=mysqli_query($koneksi,"SELECT * FROM user WHERE role='user' AND id='$s_id'");
$data=mysqli_fetch_assoc($query);
?>
<div class="kotak-dashboard">
     <!-- Kartu Identitas User -->
     <div class="user-card text-center p-4">
            <img src="assets/img/icon_form/user.png" class="user-avatar rounded-circle" alt="User Avatar">
            <h4 class="mt-3"><?= $s_nama ?></h4>
            <p class="text-muted"><?= $s_email ?></p>
            <p class="text-muted">Bergabung sejak: <?= $s_created ?></p>
            <center>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUpdate" style="background-color:#3498DB; padding:3px 7px;">Profil
            </button>
            </center>
        </div>

        <!-- Pesanan Saya -->
        <div class="pesanan-user mt-4">
            <h3>Pesanan Saya</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Produk</th>
                            <th>Tanggal Pesanan</th>
                            <th>Jumlah</th>
                            <th>Warna (Ukuran) / Rasa</th>
                            <th>Total Harga</th>
                            <th>Metode</th>
                            <th>Toko</th>
                            <th>Status</th>
                            <th>Lacak</th>
                        </tr>
                    </thead>
                    <tbody id="realtime_pesanan_user">
                        
                    </tbody>
                </table>
            </div>
        </div>



        <!-- PHistoriesanan Saya -->
        <div class="histori-user mt-4">
            <h3>Histori Pesanan</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Warna (Ukuran) / Rasa</th>
                            <th>Total Harga</th>
                            <th>Metode</th>
                            <th>Toko</th>
                            <th>Waktu Pesan</th>
                            <th>Tiba</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="realtime_histori_user">
                        
                    </tbody>
                </table>
            </div>
        </div>


<!-- Modal -->
<div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Data Pribadi</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
      <div class="mb-3">
      <label for="basic-url" class="form-label">Email</label>
      <input type="text" class="form-control" id="email" name="email" readonly value="<?= $s_email ?>">
      </div>
      <div class="mb-3">
      <label for="basic-url" class="form-label">Nama</label>
      <input type="text" class="form-control" id="nama" name="nama" value="<?= $s_nama ?>">
      </div>
      <div class="mb-3">
      <label for="basic-url" class="form-label">Update Password</label>
      <input type="text" class="form-control" id="pa" name="pa" value="<?= $s_pa ?>">
      </div>
      <div class="mb-3">
      <label for="basic-url" class="form-label">Kontak</label>
      <input type="text" class="form-control" id="kontak" name="kontak" value="<?= $data['kontak'] ?>">
      </div>
      <div class="mb-3">
      <label for="basic-url" class="form-label">Alamat</label>
      <textarea class="form-control" id="alamat" name="alamat" ><?= $data['alamat'] ?></textarea>

      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="ubah">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal rating -->
<div class="modal fade" id="modal_rating" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Berikan Ulasan Anda</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="kotak-rating-dashboard modal-body">
      <h2 class="mb-4 text-center">Seberapa Bagus Produk ini</h2>
        <form action="" method="post">
        <input type="hidden" class="form-control" id="rating" name="id_tr">
        <div class="stars" id="stars_1">
        <div class="star" data-value="1" onclick="setRating(this, 1, 'rating_1')"></div>
        <div class="star" data-value="2" onclick="setRating(this, 2, 'rating_1')"></div>
        <div class="star" data-value="3" onclick="setRating(this, 3, 'rating_1')"></div>
        <div class="star" data-value="4" onclick="setRating(this, 4, 'rating_1')"></div>
        <div class="star" data-value="5" onclick="setRating(this, 5, 'rating_1')"></div>
        </div>
        <input type="hidden" name="rating_1" id="rating_1" required>
            <textarea class="text-area form-control" name="comment" placeholder="Tulis komentar Anda..." required></textarea>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit" name="komen">Kirim</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal view -->
<div class="modal fade" id="modal_view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Pesanan Anda Di Tolak</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="kotak-rating-dashboard modal-body">
      <h2 class="mb-4 text-center">Berikut Keterangannya</h2>
       <input class="form-control mb-5" type="komentar" id="komentar">
    </div>
  </div>
</div>
        
<script>
    function setRating(star, value, inputId) {
        // Menentukan nilai rating untuk bintang yang dipilih
        var stars = star.parentElement.children;

        // Update bintang menjadi penuh atau kosong
        for (var i = 0; i < stars.length; i++) {
            if (i < value) {
                stars[i].classList.add('selected'); // Menambahkan kelas 'selected' untuk bintang penuh
            } else {
                stars[i].classList.remove('selected'); // Menghapus kelas 'selected' untuk bintang kosong
            }
        }

        // Update nilai input tersembunyi
        document.getElementById(inputId).value = value;
    }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function(event) {
      if (event.target && event.target.id === 'btn_view') {
        var pesananId = event.target.getAttribute('data-id');
        document.getElementById('komentar').value = pesananId;

        var myModalView = new bootstrap.Modal(document.getElementById('modal_view'));
        myModalView.show();
      }
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function(event) {
      if (event.target && event.target.id === 'btn_rating') {
        var pesananId = event.target.getAttribute('data-id');
        document.getElementById('rating').value = pesananId;

        var myModalRating = new bootstrap.Modal(document.getElementById('modal_rating'));
        myModalRating.show();
      }
    });
  });
</script>
      
        <script>
    $('document').ready(function() {
        setInterval(function() {
            getRealtime();
        }, 1000); // satu detik
    });

    function getRealtime() {
        var s_id = <?php echo json_encode($s_id); ?>;  // Ambil $s_id dari PHP dan simpan di JavaScript
        
        $.ajax({
            url: "realtime_pesanan_user.php",  // Pastikan URL ini benar
            type: "GET",
            data: { s_id: s_id },  // Mengirim parameter s_id ke realtime_pesanan_user.php
            success: function(response) {  // Tidak perlu menggunakan $ sebelum response
                $("#realtime_pesanan_user").html(response);  // Menampilkan hasil ke elemen dengan id "realtime_pesanan_user"
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);  // Penanganan error jika AJAX gagal
            }
        });
    }
</script>


        <script>
    $('document').ready(function() {
        setInterval(function() {
            getRealtimeHistori();
        }, 1000); // satu detik
    });

    function getRealtimeHistori() {
        var s_id = <?php echo json_encode($s_id); ?>;  // Ambil $s_id dari PHP dan simpan di JavaScript
        
        $.ajax({
            url: "realtime_histori_user.php",  // Pastikan URL ini benar
            type: "GET",
            data: { s_id: s_id },  // Mengirim parameter s_id ke realtime_pesanan_user.php
            success: function(response) {  // Tidak perlu menggunakan $ sebelum response
                $("#realtime_histori_user").html(response);  // Menampilkan hasil ke elemen dengan id "realtime_pesanan_user"
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);  // Penanganan error jika AJAX gagal
            }
        });
    }
</script>
  <script src="https://cdn.jsdelivr.net/npm/Leaflet-MovingMaker@0.0.1/MovingMarker.min.js"></script>
<script>
// Deklarasikan variabel di scope yang lebih tinggi
let map;
let currentStatus = ''; // Variabel untuk menyimpan status pesanan

// Fungsi bantuan untuk membuat marker statis
function createMarker(coords, popupText) {
    return L.marker(coords).bindPopup(popupText);
}

// Definisikan ikon untuk kurir
const deliveryIcon = L.icon({
    // PERBAIKAN: Gunakan path absolut & format PNG direkomendasikan
    iconUrl: 'assets/img/konten/deli.png', // Ganti 'marketplace' jika perlu & ganti ke .png
    iconSize: [60, 60],
    iconAnchor: [40, 40], 
});


document.addEventListener('DOMContentLoaded', function () {
    // Caching elemen DOM
    const modalElement = document.getElementById('modal_lacak');
    const modalInstance = new bootstrap.Modal(modalElement);
    const statusTextElement = document.getElementById('status_pesanan_text');
    const estimasiTextElement = document.getElementById('estimasi_pesanan_text');
    const idTokoInput = document.getElementById('id_toko_lacak');
    const idUserInput = document.getElementById('id_user');
    const mapDiv = document.getElementById('map');
    
    const statusMessages = {
        pending: '<h2 class="mb-4">Pesanan Anda sedang dibuat</h2>',
        dikirim: '<h2 class="mb-4">Pesanan Anda sedang dalam pengiriman</h2>'
    };

    // Event listener untuk klik tombol lacak
    document.body.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('btn_lacak')) {
            const idToko = event.target.getAttribute('data-id');
            const estimasiPesanan = event.target.getAttribute('data-estimasi');
            // Simpan status pesanan saat ini di variabel agar bisa diakses nanti
            currentStatus = event.target.getAttribute('data-status'); 

            idTokoInput.value = idToko;
            statusTextElement.innerHTML = statusMessages[currentStatus] || `<h2 class="mb-4">Status: ${currentStatus}</h2>`;
            estimasiTextElement.innerHTML=`<h5>Estimasi Pesanan Sampai : ${estimasiPesanan}</h5>`;
            modalInstance.show();
        }
    });

    // Event listener untuk modal
    modalElement.addEventListener('shown.bs.modal', async function () {
        if (map) { map.remove(); }
        mapDiv.innerHTML = `<div class='alert alert-info'>Memuat data lokasi...</div>`;

        try {
            // (Semua kode fetch data Anda tetap sama dan sudah benar)
            const idToko = idTokoInput.value;
            const sellerResponse = await fetch(`/marketplace/management_page/get_seller_location.php?id_toko=${idToko}`);
            const dataSeller = await sellerResponse.json();
            if(dataSeller.error) throw new Error(dataSeller.error);

            const idUser = idUserInput.value;
            const userResponse = await fetch(`/marketplace/management_page/get_user_address.php?id_user=${idUser}`);
            const dataUser = await userResponse.json();
            if(dataUser.error) throw new Error(dataUser.error);
            
            const userAddress = dataUser.address;
            const geocodeUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(userAddress)}&format=json&limit=1`;
            const geocodeResponse = await fetch(geocodeUrl);
            const geoData = await geocodeResponse.json();
            if (!geoData || geoData.length === 0) throw new Error(`Tidak dapat menemukan koordinat untuk alamat: "${userAddress}".`);
            
            mapDiv.innerHTML = "";

            const userCoords = [parseFloat(geoData[0].lat), parseFloat(geoData[0].lon)];
            const sellerCoords = dataSeller.latlng.split(',').map(Number);
            
            map = L.map('map');
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            map.invalidateSize();

            // === INTI PERUBAHAN LOGIKA ADA DI SINI ===
            const routingControl = L.Routing.control({
                waypoints: [ L.latLng(sellerCoords[0], sellerCoords[1]), L.latLng(userCoords[0], userCoords[1]) ],
                routeWhileDragging: false, addWaypoints: false, draggableWaypoints: false,
                fitSelectedRoutes: true, show: false,
                // PENTING: Matikan pembuatan marker bawaan dari library agar tidak konflik
                createMarker: function() { return null; } 
                
            }).on('routesfound', function(e) {
                // Event ini hanya berjalan jika rute BERHASIL ditemukan
                const routeLine = e.routes[0].coordinates;

                // 1. Gambar marker statis A dan B kustom kita
                createMarker(sellerCoords, '<b>Lokasi Toko</b>').addTo(map);
                createMarker(userCoords, `<b>Alamat Tujuan</b><br>${userAddress}`).addTo(map);

                // 2. Jika status 'dikirim', gambar juga marker yang bergerak
                if (currentStatus === 'dikirim') {
                    L.Marker.movingMarker(routeLine, 20000, { // durasi 20 detik
                        autostart: true,
                        loop: true,
                        icon: deliveryIcon
                    }).addTo(map);
                }
            }).on('routingerror', function(e) {
                // Penanganan jika rute gagal ditemukan
                if (map) { map.remove(); }
                mapDiv.innerHTML = `<div class='alert alert-warning'>Gagal menghitung rute.</div>`;
            });

            // Tambahkan routing control yang sudah diatur ke peta
            routingControl.addTo(map);

        } catch (error) {
            console.error('Terjadi kesalahan:', error);
            mapDiv.innerHTML = `<div class='alert alert-danger'>${error.message}</div>`;
        }
    });
});
</script>







<?php
if (isset($_POST['ubah'])) {
    $id = $s_id;
    $nama=$_POST['nama'];
    $kontak=$_POST['kontak'];
    $alamat=$_POST['alamat'];
    $pa=$_POST['pa'];
    if($pa == $s_pa){
        $update = mysqli_query($koneksi, "UPDATE user set nama='$nama',kontak='$kontak',alamat='$alamat' WHERE id='$id'");
    }else{
        $update = mysqli_query($koneksi, "UPDATE user set nama='$nama',kontak='$kontak',alamat='$alamat', password='$pa' WHERE id='$id'");
    }
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Berhasil. Silahkan Logout dan login kembali',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=dashboard';
            }
            })</script>";
    }
}

if (isset($_POST['batal'])) {
    $id = $_POST['id_batal'];
    $update = mysqli_query($koneksi, "UPDATE pesanan set status='batal' WHERE id='$id'");
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Mengajukan Pembatalan',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=dashboard';
            }
            })</script>";
    }
}
if (isset($_POST['hapus'])) {
    $id = $_POST['id_pesanan'];
    $update = mysqli_query($koneksi, "UPDATE pesanan set status='pembatalan' WHERE id='$id'");
    if ($update) {
        echo "<script>
        Swal.fire({title: 'Berhasil Menghapus',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=dashboard';
            }
            })</script>";
    }
}

if (isset($_POST['komen'])) {
    $tr_id=$_POST['id_tr'];
    $query=mysqli_query($koneksi,"SELECT * FROM `transaksi` JOIN pesanan ON pesanan_id=pesanan.id where transaksi.id='$tr_id'");
    $row=mysqli_fetch_assoc($query);
    $produk_id = $row['produk_id'];
    $rating = $_POST['rating_1'];
    $comment = $_POST['comment'];

        $insert = mysqli_query($koneksi, "INSERT INTO ulasan (user_id,produk_id,comment,rating,transaksi_id) VALUES ('$s_id','$produk_id','$comment','$rating','$tr_id') ");
 
    if ($insert) {
        echo "<script>
        Swal.fire({title: 'Terima Kasih Atas Ulasannya',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            window.location = '?page=dashboard';
            }
            })</script>";
    }
}
?>