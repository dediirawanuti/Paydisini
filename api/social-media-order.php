<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$post_srv = isset($_POST['service']) ? filter($_POST['service']) : '';
$post_tgt = isset($_POST['data']) ? filter($_POST['data']) : '';
$post_qty = isset($_POST['quantity']) ? filter($_POST['quantity']) : '';

$check_service = $call->query("SELECT * FROM srv_socmed WHERE id = '$post_srv' AND status = 'available'");
if($check_service->num_rows > 0) {
    $data_srv = $check_service->fetch_assoc();
    $provider = $data_srv['provider'];
    $service = $data_srv['name'];
    $provid = $data_srv['pid'];
    
    $profit_db = (in_array($data_user['level'],['Admin','Premium'])) ? $data_srv['premium'] : $data_srv['basic'];
    $price_db = $data_srv['price']+$profit;
    $price = ($price_db / 1000) * $post_qty;
    $profit = ($profit_db / 1000) * $post_qty;
    $point = point($price,$profit,'socmed');
    
    $check_provider = $call->query("SELECT * FROM provider WHERE code = '$provider'");
    if($check_provider->num_rows > 0) $data_prv = $check_provider->fetch_assoc();
}

$data_user = data_user($username);
if($_CONFIG['lock']['status'] == true)                                      ShennDie(['result' => false,'data' => null,'message' => $_CONFIG['lock']['reason']]);
if($_CONFIG['mt']['trx'] == 'true')                                         ShennDie(['result' => false,'data' => null,'message' => 'Ada pemeliharaan sistem transaksi, coba lagi nanti.']);
if(!$post_srv || !$post_tgt || !$post_qty)                                  ShennDie(['result' => false,'data' => null,'message' => 'Masih ada parameter yang kosong.']);
if($check_service->num_rows == 0)                                           ShennDie(['result' => false,'data' => null,'message' => 'Layanan tidak ditemukan atau saat ini tidak tersedia.']);
if($check_provider->num_rows == 0)                                          ShennDie(['result' => false,'data' => null,'message' => 'Server tidak ditemukan atau saat ini tidak tersedia.']);
if($post_qty < $data_srv['min'])                                            ShennDie(['result' => false,'data' => null,'message' => 'Pesanan Anda kurang dari jumlah pesanan minimum.']);
if($post_qty > $data_srv['max'])                                            ShennDie(['result' => false,'data' => null,'message' => 'Pesanan Anda melebihi batas pesanan maksimum.']);
if($data_user['balance'] < $price)                                          ShennDie(['result' => false,'data' => null,'message' => 'Saldo Anda tidak cukup untuk melakukan pemesanan ini.']);
if($data_user['balance'] < ($price+$_CONFIG['hold'][$data_user['level']]))  ShennDie(['result' => false,'data' => null,'message' => 'Saldo akun minimum Anda adalah '.number_format($_CONFIG['hold'][$data_user['level']]).'.']);
if(date_diffs(last_trx($username, 'socmed'), $dtme, 'second') < 1)          ShennDie(['result' => false,'data' => null,'message' => 'Transaksi dibatasi, coba lagi dalam 1 detik.']);
if($call->query("SELECT id FROM trx_socmed WHERE name = '$service' AND data = '$post_tgt' AND status NOT IN ('error', 'partial', 'success')")->num_rows > 0)
    ShennDie(['result' => false,'data' => null,'message' => 'Masih terdapat pesanan pending dengan target yang sama.']);

$ShennTRX = date('YmdHis').random_number(2);
if($call->query("SELECT id FROM trx_socmed WHERE wid = '$ShennTRX'")->num_rows > 0) ShennDie(['result' => false,'data' => null,'message' => 'Sistem Bentrok, coba lagi nanti!']);

$inp = $call->query("INSERT INTO trx_socmed VALUES (null,'$ShennTRX','','$username','$service','$post_tgt','','','','$post_qty','$price','$point','$profit','0','0','waiting','0','0','WEB,$client_ip','$dtme','$dtme','$provider')");
if($inp == true) $inp1 = $call->query("UPDATE users SET balance = balance-$price WHERE username = '$username'");

if($data_user['balance'] > $price) {
    if(isset($inp1) && $inp1 == false) {
        if($inp == true) $call->query("DELETE FROM trx_socmed WHERE wid = '$ShennTRX'");
        ShennDie(['result' => false,'data' => null,'message' => 'Terjadi kesalahan dengan data pengguna.']);
    } else if($inp == true && $inp1 == true) {
        $req_result = false;
        $req_message = 'Connection not found.';
        require _DIR_('library/shennboku.app/order-sosmed-curl');
        
        if($req_result == true) {
            $call->query("INSERT INTO mutation VALUES (null,'$username','-','$price','Socmed Order :: $ShennTRX','$dtme')");
            $call->query("INSERT INTO logs VALUES (null,'$username','order','Socmed Order :: $ShennTRX','primary','$client_ip','$client_iploc','$dtme')");
            $call->query("UPDATE trx_socmed SET tid = '$req_provid', note = '-', count = '$req_count', remain = '$req_remain' WHERE wid = '$ShennTRX'");
            ShennDie(['result' => true,'data' => [
                'trxid' => $ShennTRX,
                'data' => $post_tgt,
                'service' => $service,
                'quantity' => $post_qty,
                'status' => 'waiting',
                'note' => '-',
                'balance' => (int)data_user($username, 'balance'),
                'price' => (int)$price
            ],'message' => 'Pesanan berhasil, pesanan akan diproses.']);
        } else {
            $call->query("INSERT INTO logs VALUES (null,'system','system','[$provider] [API] [$ShennTRX] Sosmed: $req_message','primary','$client_ip','$client_iploc','$dtme')");
            $call->query("UPDATE users SET balance = balance+$price WHERE username = '$username'");
            $req_msg = (stristr(strtolower($req_message),'saldo') || stristr(strtolower($req_message),'balance')) ? 'Something went wrong, please contact the admin.' : $req_message;
            if(conf('xtra-fitur',7) == 'true') {
                $req_msg = $req_message;
                $call->query("INSERT INTO logs VALUES (null,'$username','order','Sosmed Order :: $ShennTRX','primary','$client_ip','$client_iploc','$dtme')");
                $call->query("INSERT INTO mutation VALUES (null,'$username','-','$price','Sosmed Order :: $ShennTRX','$dtme'), (null,'$username','+','$price','Sosmed Refunds :: $ShennTRX','$dtme')");
                $call->query("UPDATE trx_socmed SET note = '$req_msg', status = 'error', price = '0', profit = '0', refund = '1' WHERE wid = '$ShennTRX'");
            } else {
                $call->query("DELETE FROM trx_socmed WHERE wid = '$ShennTRX'");
            }
            ShennDie(['result' => false,'data' => null,'message' => $req_msg]);
        }
    } else {
        if($inp == true) $call->query("DELETE FROM trx_socmed WHERE wid = '$ShennTRX'");
        if($inp1 == true) $call->query("UPDATE users SET balance = balance+$price WHERE username = '$username'");
        ShennDie(['result' => false,'data' => null,'message' => 'Terjadi error pada data transaksi.']);
    }
} else {
    if($inp == true) $call->query("DELETE FROM trx_socmed WHERE wid = '$ShennTRX'");
    if($inp1 == true) $call->query("UPDATE users SET balance = balance+$price WHERE username = '$username'");
    ShennDie(['result' => false,'data' => null,'message' => 'Saldo Anda rendah.']);
}