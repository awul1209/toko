<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" id="nav">
    <div class="container d-flex align-items-center">
        <!-- Logo (Sembunyi saat mobile) -->
        <a class="navbar-brand d-lg-block d-none" href="index.php">
            <img id="logo" src="assets/img/konten/icon.png" alt="Logo" style="width: 45px;">
        </a>

        <!-- Tombol toggler untuk mobile -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu utama dan user -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu utama tetap di samping logo -->
            <ul class="navbar-nav ms-3"> <!-- Menjaga posisi tetap di samping logo -->
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == '' || $page == 'index.php') ? 'active' : ''; ?>" href="index.php" style="color:#fff;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == 'produk' || $page == 'detail') ? 'active' : ''; ?>" href="index.php?page=produk" style="color:#fff;">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == 'rating' || $page == 'detail') ? 'active' : ''; ?>" href="index.php?page=rating" style="color:#fff;">Rating</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == 'tentang-kami') ? 'active' : ''; ?>" href="?page=tentang-kami" style="color:#fff;">Tentang Kami</a>
                </li>
            </ul>

            <!-- Bagian user (keranjang & login/logout) tetap di kanan -->
            <ul class="navbar-nav ms-auto">
                <?php if (!empty($s_nama)) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#fff;">
                            Welcome back, <?= $s_nama ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item <?php echo ($page == 'dashboard') ? 'active' : ''; ?>" href="?page=dashboard">
                                    <i class="bi bi-layout-text-window-reverse"></i> My Dashboard
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="text-decoration-none" href="?page=logout">
                                <button type="submit" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=keranjang" role="button">
                            <i class="bi bi-cart-plus text-white" style="font-size: 1.2rem;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
    <a class="nav-link position-relative" href="index.php?page=pesan" role="button">
        <i class="bi bi-messenger text-white" style="font-size: 1.2rem;"></i>
        <?php if (!isset($_GET['page']) || $_GET['page'] !== 'pesan') : ?>
            <span id="notif-messenger" class="notif-iconn position-absolute top-20 start-80 translate-middle badge rounded-pill bg-danger" style="display: none;">
                0
            </span>
        <?php endif; ?>
    </a>
</li>


                <?php } else { ?>
                    <li class="nav-item">
                        <a data-bs-toggle="modal" data-bs-target="#modallogin" class="nav-link text-white" href="/login">
                            <i class="bi bi-box-arrow-in-right" style="color:#fff;"></i> Login/Daftar
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Tambahkan CSS -->
<style>
/* Sembunyikan logo saat layar kecil */
@media (max-width: 991.98px) {
    .navbar-brand {
        display: none;
    }
}

/* Mengubah warna ikon hamburger menu menjadi putih */
.navbar-toggler {
    /* border: 1px solid white;  */
    /* Border putih */
}

.navbar-toggler-icon {
    filter: invert(1); /* Membuat ikon menjadi putih */
}
.notif-iconn {
    font-size: 8px;
    padding: 3px 5px;
    display: none; /* Sembunyikan jika tidak ada notifikasi */
}

</style>

<script>
    function checkMessengerNotifications(userId) {
    $.get("check_notifications.php", { receiver_id: userId }, function(data) {
        try {
            let notifications = JSON.parse(data);
            let totalUnread = Object.values(notifications).reduce((a, b) => a + b, 0);

            if (totalUnread > 0) {
                $("#notif-messenger").text(totalUnread).show();
            } else {
                $("#notif-messenger").hide();
            }
        } catch (error) {
            console.error("JSON Parse Error:", error, "Received:", data);
        }
    }).fail(function(xhr, status, error) {
        console.error("AJAX Error:", status, error);
    });
}

// Jalankan pengecekan setiap 5 detik
setInterval(function() {
    checkMessengerNotifications(<?php echo $s_id; ?>);
}, 2000);

</script>
