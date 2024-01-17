<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$web_token = isset($_POST['service']) ? filter($_POST['service']) : '';
$tgt_token = isset($_POST['data_no']) ? filter($_POST['data_no']) : '';

$check_service = $call->query("SELECT * FROM srv_ppob WHERE code = '$web_token' AND status = 'available'");
if($check_service->num_rows > 0) {
    $data_srv = $check_service->fetch_assoc();
    $provider = $data_srv['provider'];
    $service = $data_srv['name'];
    $web_token = $data_srv['code'];
    $profit = (in_array($data_user['level'],['Admin','Premium'])) ? $data_srv['premium'] : $data_srv['basic'];
    $price = $data_srv['price']+$profit;
    
    $check_provider = $call->query("SELECT * FROM provider WHERE code = '$provider'");
    if($check_provider->num_rows > 0) $data_prv = $check_provider->fetch_assoc();
}

$data_user = data_user($username);
if($_CONFIG['lock']['status'] == true)                                      ShennDie(['result' => false,'data' => null,'message' => $_CONFIG['lock']['reason']]);
if($_CONFIG['mt']['trx'] == 'true')                                         ShennDie(['result' => false,'data' => null,'message' => 'Ada pemeliharaan sistem transaksi, coba lagi nanti.']);
if(!$web_token || !$tgt_token)                                              ShennDie(['result' => false,'data' => null,'message' => 'Masih ada parameter yang kosong.']);
if($check_service->num_rows == 0)                                           ShennDie(['result' => false,'data' => null,'message' => 'Layanan tidak ditemukan atau saat ini tidak tersedia.']);
if($check_provider->num_rows == 0)                                          ShennDie(['result' => false,'data' => null,'message' => 'Server tidak ditemukan atau saat ini tidak tersedia.']);
if($data_user['balance'] < $price)                                          ShennDie(['result' => false,'data' => null,'message' => 'Saldo Anda tidak cukup untuk melakukan pemesanan ini.']);
if($data_user['balance'] < ($price+$_CONFIG['hold'][$data_user['level']]))  ShennDie(['result' => false,'data' => null,'message' => 'Saldo akun minimum Anda adalah '.number_format($_CONFIG['hold'][$data_user['level']]).'.']);

$ShennTRX = date('YmdHis').random_number(2);
$out_res = false;
$out_msg = 'Connection not Found';
require _DIR_('library/shennboku.app/order-postpaid-invcurl');

if($out_res == true) {
    ShennDie(['result' => true,'data' => [
        'trxid' => $ShennTRX,
        'data' => [
            'no' => $tgt_token,
            'name' => $out_name
        ],
        'code' => $web_token,
        'service' => $service,
        'balance' => (int)data_user($username, 'balance'),
        'price' => [
            'bill' => (int)$out_bills,
            'admin' => (int)$price,
            'total' => (int)$out_bills+$price
        ]
    ],'message' => 'Pesanan berhasil, pesanan akan diproses.']);
} else {
    ShennDie(['result' => false,'data' => null,'message' => $out_msg]);
}