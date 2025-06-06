<?php

if (isset($_GET['page'])) {
    $hal = $_GET['page'];

    switch ($hal) {
            //home
        case '':
            include 'management_page/home.php';
            break;
        case 'home':
            include 'management_page/home.php';
            break;
        case 'dashboard':
            include 'management_page/dashboard.php';
            break;
        case 'form-logout':
            include 'form-logout.php';
            break;
        case 'keranjang':
            include 'management_page/keranjang.php';
            break;

            // produk
        case 'produk':
            include 'management_page/produk.php';
            break;
        case 'transaksi':
            include 'management_page/transaksi.php';
            break;
        case 'detail':
            include 'management_page/detail.php';
            break;
            
            // toko
        case 'toko':
            include 'management_page/toko.php';
            break;
        case 'detail':
            include 'management_page/detail.php';
            break;

            // chat
        case 'chat':
            include 'management_page/chat.php';
            break;

            // pesan
        case 'pesan':
            include 'management_page/pesan.php';
            break;
            // tentang kami
        case 'tentang-kami':
            include 'management_page/tentang_kami.php';
            break;

            // rating
        case 'rating':
            include 'management_page/rating.php';
            break;
        case 'proses-nilai':
            include 'management_page/proses_rating.php';
            break;

            // logout
        case 'logout':
            include 'form-logout.php';
            break;

            // keranjang
        case 'del_keranjang':
            include 'del_keranjang.php';
            break;
       
            //default
        default:
            include 'management_page/home.php';
            break;
    }
} else {
    include 'management_page/home.php';
}
