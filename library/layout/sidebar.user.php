<?php
if($data_user['level'] == 'Admin') li('Admin','feather icon-bookmark warning','/admin');
li('Home','fa fa-home','/');
if($data_user['level'] != 'Basic') ul([
    'name' => 'Premium',
    'icon' => 'fi-briefcase',
    'content' => [
        ['name' => 'Transfer Balance','page' => '/premium/transfer'],
        ['name' => 'Make a Voucher','page' => '/premium/voucher'],
        ['name' => 'My Downline','page' => '/premium/downline'],
    ]
]);
if(conf('xtra-fitur',4) == 'true') ul([
    'name' => 'Papan Peringkat',
    'icon' => 'fa fa-trophy',
    'content' => [
        (conf('xtra-fitur',3) == 'true') ? ['name' => 'Social Media','page' => '/page/monthly-rating/social-media'] : '',
    ]
]);
ul([
    'name' => 'Sosial Media',
    'icon' => 'mdi mdi-cart',
    'content' => [
        ['name' => 'New','page' => '/order/social-media'],
        ['name' => 'Riwayat','page' => '/order/history/social-media'],
    ]
]);
li('Daftar Harga','mdi mdi-tag','/page/product');
ul([
    'name' => 'Deposit',
    'icon' => 'mdi mdi-bank',
    'content' => [
        ['name' => 'New','page' => '/deposit/new'],
        ['name' => 'Voucher','page' => '/deposit/voucher'],
        ['name' => 'Riwayat','page' => '/deposit/history'],
    ]
]);
ul([
    'name' => 'Halaman',
    'icon' => 'mdi mdi-sitemap',
    'content' => [
        ['name' => 'Information Center','page' => '/page/information'],
        ['name' => 'Terms of Service','page' => '/page/terms-of-service'],
        ['name' => 'General Questions','page' => '/page/general-questions'],
        ['name' => 'Contact Admin','page' => '/page/contact'],
    ]
]);

ul([
    'name' => 'API Documentation',
    'icon' => 'mdi mdi-code-tags',
    'content' => [
        ['name' => 'Profile','page' => '/page/api/profile'],
        ['name' => 'Prepaid','page' => '/page/api/prepaid'],
        (conf('xtra-fitur',1) == 'true') ? ['name' => 'Postpaid','page' => '/page/api/postpaid'] : '',
        (conf('xtra-fitur',3) == 'true') ? ['name' => 'Social Media','page' => '/page/api/social-media'] : '',
        (conf('xtra-fitur',2) == 'true') ? ['name' => 'Game Feature','page' => '/page/api/game-feature'] : '',
    ]
]);
?>