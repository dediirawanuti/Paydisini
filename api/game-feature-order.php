<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$post_srv = isset($_POST['service']) ? filter($_POST['service']) : '';
$post_tgt = isset($_POST['data_no']) ? filter($_POST['data_no']) : '';
$post_zon = isset($_POST['data_zone']) ? filter($_POST['data_zone']) : '';

$check_service = $call->query("SELECT * FROM srv_game WHERE code = '$post_srv' AND status = 'available'");
if($check_service->num_rows > 0) {
    $data_srv = $check_service->fetch_assoc();
    $provider = $data_srv['provider'];
    $service = $data_srv['game'].' - '.$data_srv['name'];
    $profit = (in_array($data_user['level'],['Admin','Premium'])) ? $data_srv['premium'] : $data_srv['basic'];
    $price = $data_srv['price']+$profit;
    $point = point($price,$profit,'game');
        
    $check_provider = $call->query("SELECT * FROM provider WHERE code = '$provider'");
    if($check_provider->num_rows > 0) $data_prv = $check_provider->fetch_assoc();
}

$data_user = data_user($username);
if($_CONFIG['lock']['status'] == true)                                      ShennDie(['result' => false,'data' => null,'message' => $_CONFIG['lock']['reason']]);
if($_CONFIG['mt']['trx'] == 'true')                                         ShennDie(['result' => false,'data' => null,'message' => 'Ada pemeliharaan sistem transaksi, coba lagi nanti.']);
if(!$post_srv || !$post_tgt)                                                ShennDie(['result' => false,'data' => null,'message' => 'Masih ada parameter yang kosong.']);
if($check_service->num_rows == 0)                                           ShennDie(['result' => false,'data' => null,'message' => 'Layanan tidak ditemukan atau saat ini tidak tersedia.']);
if($check_provider->num_rows == 0)                                          ShennDie(['result' => false,'data' => null,'message' => 'Server tidak ditemukan atau saat ini tidak tersedia.']);
if($data_user['balance'] < $price)                                          ShennDie(['result' => false,'data' => null,'message' => 'Saldo Anda tidak cukup untuk melakukan pemesanan ini.']);
if($data_user['balance'] < ($price+$_CONFIG['hold'][$data_user['level']]))  ShennDie(['result' => false,'data' => null,'message' => 'Saldo akun minimum Anda adalah '.number_format($_CONFIG['hold'][$data_user['level']]).'.']);
if(date_diffs(last_trx($username, 'game'), $dtme, 'second') < 6)            ShennDie(['result' => false,'data' => null,'message' => 'Transaksi dibatasi, coba lagi dalam 6 detik.']);

$ShennTRX = date('YmdHis').random_number(2);
if($call->query("SELECT id FROM trx_game WHERE wid = '$ShennTRX'")->num_rows > 0) ShennDie(['result' => false,'data' => null,'message' => 'Sistem Bentrok, coba lagi nanti!']);

$inp = $call->query("INSERT INTO trx_game VALUES (null,'$ShennTRX','','$username','$post_srv','$service','$post_tgt','$post_zon','','$price','$point','$profit','waiting','0','0','API,$client_ip','$dtme','$dtme','$provider')");
if($inp == true) $inp1 = $call->query("UPDATE users SET balance = balance-$price WHERE username = '$username'");

if($data_user['balance'] > $price) {
    if(isset($inp1) && $inp1 == false) {
        if($inp == true) $call->query("DELETE FROM trx_game WHERE wid = '$ShennTRX'");
        ShennDie(['result' => false,'data' => null,'message' => 'Terjadi kesalahan dengan data pengguna.']);
    } else if($inp == true && $inp1 == true) {
        $req_result = false;
        $req_message = 'Connection not found.';
        require _DIR_('library/shennboku.app/order-games-curl');
        
        if($req_result == true) {
            $call->query("INSERT INTO mutation VALUES (null,'$username','-','$price','Game Order :: $ShennTRX','$dtme')");
            $call->query("INSERT INTO logs VALUES (null,'$username','order','Game Order :: $ShennTRX','primary','$client_ip','$client_iploc','$dtme')");
            $call->query("UPDATE trx_game SET tid = '$req_provid', note = '$req_note' WHERE wid = '$ShennTRX'");
            ShennDie(['result' => true,'data' => [
                'trxid' => $ShennTRX,
                'data' => $post_tgt,
                'zone' => $post_zon,
                'service' => $service,
                'status' => 'waiting',
                'note' => $req_note,
                'balance' => (int)data_user($username, 'balance'),
                'price' => (int)$price
            ],'message' => 'Pesanan berhasil, pesanan akan diproses.']);
        } else {
            $call->query("INSERT INTO logs VALUES (null,'system','system','[$provider] [API] [$ShennTRX] Game: $req_message','primary','$client_ip','$client_iploc','$dtme')");
            $call->query("UPDATE users SET balance = balance+$price WHERE username = '$username'");
            $req_msg = (stristr(strtolower($req_message),'saldo') || stristr(strtolower($req_message),'balance')) ? 'Something went wrong, please contact the admin.' : $req_message;
            if(conf('xtra-fitur',7) == 'true') {
                $req_msg = $req_message;
                $call->query("INSERT INTO logs VALUES (null,'$username','order','Game Order :: $ShennTRX','primary','$client_ip','$client_iploc','$dtme')");
                $call->query("INSERT INTO mutation VALUES (null,'$username','-','$price','Game Order :: $ShennTRX','$dtme'), (null,'$username','+','$price','Game Refunds :: $ShennTRX','$dtme')");
                $call->query("UPDATE trx_game SET note = '$req_msg', status = 'error', price = '0', profit = '0', refund = '1' WHERE wid = '$ShennTRX'");
            } else {
                $call->query("DELETE FROM trx_game WHERE wid = '$ShennTRX'");
            }
            ShennDie(['result' => false,'data' => null,'message' => $req_msg]);
        }
    } else {
        if($inp == true) $call->query("DELETE FROM trx_game WHERE wid = '$ShennTRX'");
        if($inp1 == true) $call->query("UPDATE users SET balance = balance+$price WHERE username = '$username'");
        ShennDie(['result' => false,'data' => null,'message' => 'Terjadi error pada data transaksi.']);
    }
} else {
    if($inp == true) $call->query("DELETE FROM trx_game WHERE wid = '$ShennTRX'");
    if($inp1 == true) $call->query("UPDATE users SET balance = balance+$price WHERE username = '$username'");
    ShennDie(['result' => false,'data' => null,'message' => 'Saldo Anda rendah.']);
}