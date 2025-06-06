
<?php

if (isset($_GET['page'])) {
    $hal = $_GET['page'];

    switch ($hal) {
            //home
        case 'home':
            include 'management_page/dashboard.php';
            break;
        case 'home-admin':
            include 'management_page/dashboard_admin.php';
            break;
            //Pengguna
        case 'data-user':
            include 'admin/user/index.php';
            break;
        case 'add-user':
            include 'admin/user/add_user.php';
            break;
        case 'del-user':
            include 'admin/user/del.php';
            break;
        case 'edit-user':
            include 'admin/user/edit_user.php';
            break;
            //seller
        case 'data-seller':
            include 'admin/seller/index.php';
            break;
        case 'add-seller':
            include 'admin/seller/add_seller.php';
            break;
        case 'del-seller':
            include 'admin/seller/del.php';
            break;
        case 'edit-seller':
            include 'admin/seller/edit_seller.php';
            break;

            //pesanan
        case 'data-pesanan':
            include 'admin/pesanan/index.php';
            break;
        case 'add-pesanan':
            include 'admin/pesanan/add_pesanan.php';
            break;
        case 'del-pesanan':
            include 'admin/pesanan/del.php';
            break;
        case 'edit-pesanan':
            include 'admin/pesanan/edit_pesanan.php';
            break;
            //produk
        case 'data-produk':
            include 'admin/produk/index.php';
            break;
        case 'add-produk':
            include 'admin/produk/add_produk.php';
            break;
        case 'del-produk':
            include 'admin/produk/del_produk.php';
            break;
        case 'edit-produk':
            include 'admin/produk/edit_produk.php';
            break;
            //transaksi
        case 'data-transaksi':
            include 'admin/transaksi/index.php';
            break;
        case 'add-pesanan':
            include 'admin/pesanan/add_pesanan.php';
            break;
        case 'del-pesanan':
            include 'admin/pesanan/del.php';
            break;
        case 'edit-pesanan':
            include 'admin/pesanan/edit_pesanan.php';
            break;
            // pesanan admin
        case 'admin-pesanan':
            include 'admin/pesanan_admin/index.php';
            break;

            //ulasan
        case 'data-ulasan':
            include 'admin/ulasan/index.php';
            break;
        case 'add-ulasan':
            include 'admin/ulasan/add_ulasan.php';
            break;
        case 'del-ulasan':
            include 'admin/ulasan/del.php';
            break;
        case 'edit-ulasan':
            include 'admin/ulasan/edit_ulasan.php';
            break;
            //rating
        case 'data-rating':
            include 'admin/ulasanaplikasi/index.php';
            break;
        case 'add-rating':
            include 'admin/ulasanaplikasi/add_rating.php';
            break;
        case 'del-rating':
            include 'admin/ulasanaplikasi/del.php';
            break;
        case 'edit-rating':
            include 'admin/ulasanaplikasi/edit_rating.php';
            break;
        // tentang kami
        case 'tentang-kami':
            include 'admin/tentang_kami/index.php';
            break;
        case 'add-tentang-kami':
            include 'admin/tentang_kami/add_tentang_kami.php';
            break;
        case 'edit-tentang':
            include 'admin/tentang_kami/edit_tentang.php';
            break;
        case 'del-tentang':
            include 'admin/tentang_kami/del.php';
            break;

            // chat
            case 'chat':
                include 'management_page/chat.php';
                break;
            // pesan
            case 'pesan':
                include 'management_page/pesan.php';
                break;
            // logout
        case 'logout':
            include 'logout.php';
            break;




        default:
            echo '<center><h1> ERROR !</h1></center>';
            break;
    }
} else {
    if($role == 'admin'){
        include 'management_page/dashboard_admin.php';
    }else{
        include 'management_page/dashboard.php';
    }
}
