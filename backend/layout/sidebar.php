<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary position-fixed" id="side" style="">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">SeePay VI.0</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div id="parent-sidebar" class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto ps-1 pe-1" style="box-sizing: border-box;">
            <ul class="nav flex-column">
                <?php if($role == 'admin') { ?>
                <li class="nav-item">
                    <a  class="nav-link "
                        style="<?php if ($page == 'home-admin' or $page == '') {
                                    echo 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;';
                                } ?>; color: #3498DB"
                        aria-current="page" href="?page=home-admin">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-house-door-fill"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link"
                        style="<?= ($page == 'admin-pesanan') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB"
                        href="?page=admin-pesanan">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-file-person"></i>
                        Pesanan Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link"
                        style="<?= ($page == 'data-user' || $page == 'add-user' || $page == 'edit-user') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB"
                        href="?page=data-user">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-file-person"></i>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link"
                        style="<?= ($page == 'data-seller' || $page == 'add-seller' || $page == 'edit-seller') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB"
                        href="?page=data-seller">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-person-badge"></i>
                        Penjual
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" style="<?= ($page == 'data-produk' || $page == 'add-produk' || $page == 'edit-produk') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB" href="?page=data-produk">
                    <i  style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-box2"></i>
                     Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" style="<?= ($page == 'data-transaksi' || $page == 'add-transaksi' || $page == 'edit-transaksi') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB" href="?page=data-transaksi">
                    <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-cart-check"></i>
                     Transaksi
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" href="?page=data-ulasan" style="<?= ($page == 'data-ulasan' || $page == 'add-ulasan' || $page == 'edit-ulasan') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;"  class="bi bi-star"></i>
                        Ulasan
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" href="?page=data-rating" style="<?= ($page == 'data-rating' || $page == 'add-rating' || $page == 'edit-rating') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;"  class="bi bi-star"></i>
                        Rating Web
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" href="?page=tentang-kami" style="<?= ($page == 'tentang-kami' || $page == 'add-tentang-kami' || $page == 'edit-tentang') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>;color: #3498DB">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB" class="bi bi-universal-access-circle"></i>
                        Tentang Kami
                    </a>
                </li>
                <!-- style="font-size: 1.5rem; color: cornflowerblue;" -->
                 <?php } else { ?>
                    <li class="nav-item">
                    <a  class="nav-link "
                        style="<?php if ($page == 'home' or $page == '') {
                                    echo 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;';
                                } ?>; color: #3498DB"
                        aria-current="page" href="?page=home">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-house-door-fill"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link"
                        style="<?= ($page == 'data-profil' || $page == 'add-profil' || $page == 'edit-seller') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB"
                        href="?page=edit-seller&kode=<?= $ses_id ?>&seller=1">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-shop-window"></i>
                        Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link"
                        style="<?= ($page == 'data-pesanan' || $page == 'add-pesanan' || $page == 'edit-pesanan') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB"
                        href="?page=data-pesanan">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-bag-fill"></i>
                        Pesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link"
                        style="<?= ($page == 'data-produk' || $page == 'add-produk' || $page == 'edit-produk') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB"
                        href="?page=data-produk">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-boxes"></i>
                        Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link"
                        style="<?= ($page == 'pesan' || $page == 'add-chat' || $page == 'edit-chat') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB"
                        href="?page=pesan">
                        <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-whatsapp"></i>
                        Pesan
                        <?php if (!isset($_GET['page']) || $_GET['page'] !== 'pesan') : ?>
            <span id="notif-messenger" class="notif-iconn position-absolute start-75 translate-middle badge rounded-pill bg-danger" style="display: none;">
                0
            </span>
        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" style="<?= ($page == 'data-transaksi' || $page == 'add-transaksi' || $page == 'edit-transaksi') ? 'background-color: #eaeaea; border-radius:2px; border-left: 5px solid black;' : '' ?>; color: #3498DB" href="?page=data-transaksi">
                    <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB;" class="bi bi-cart-check"></i>
                     Transaksi
                    </a>
                </li>
                <?php } ?>

            </ul>



            <hr class="my-3">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link " onclick="return confirm('Apakah anda yakin akan keluar ?')" href="logout.php" style="color: #3498DB">
                    <i style="font-size: 1.2rem; margin-right:5px; color: #3498DB" class="bi bi-box-arrow-left"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<style>
    .notif-iconn {
    font-size: 8px;
    padding: 2px 4px;
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
    checkMessengerNotifications(<?php echo $ses_id; ?>);
}, 2000);

</script>