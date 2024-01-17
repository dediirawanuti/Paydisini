<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$search1 = $call->query("SELECT * FROM deposit WHERE user = '$sess_username' AND status = 'unpaid'");
if($search1->num_rows == 1) redirect(0,base_url('deposit/invoice/'.$search1->fetch_assoc()['wid']));

if(isset($_POST['confirm'])) {
    $post_rid = date('YmdHis').random_number(2);
    $post_payment = filter($_POST['payment']);
    $post_method = filter_entities($_POST['method']);
    $post_sender = ($_POST['phone'] !== '') ? filter_phone('62',$_POST['phone']) : '';
    $post_quantity = filter_entities($_POST['quantity']);
    $post_kodeuniq = ($post_payment == 'pulsa') ? '0' : rand(001,410);

    $data_depo = $call->query("SELECT * FROM deposit_method WHERE id = '$post_method'")->fetch_assoc();
	$post_note = $data_depo['data'];
	$post_name = $data_depo['name'];
	$post_vendr = $data_depo['method'];
	
	$post_price3 = ($data_depo['xfee'] == '-') ? $data_depo['fee'] : ($post_quantity * $data_depo['fee']);
    $post_price2 = $post_quantity - $post_price3;
    $post_price1 = $post_price2 * $data_depo['rate'];
    $post_price = $post_price2 - $post_price1;
	
	$check_operators = $SimCard->operator($post_sender);
    $check_operator = (in_array($check_operators, ['Axis','XL'])) ? 'axiata' : strtolower($check_operators);
    if($post_payment == 'pulsa') {
        $gte_max = "999999";
        $gte_acc = ($post_vendr === $check_operator) ? true : false;
	} else {
        $gte_max = "9999999";
        $gte_acc = true;
	}
	$gte_sal = $post_price1;
	$gte_fee = $post_price3+$post_price;
	$gte_min = $data_depo['min'];

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if($_CONFIG['mt']['topup'] == 'true') {
        ShennXit(['type' => false,'message' => 'There is a deposit system maintenance, please try again later.']);
    } else if(!$post_method || !$post_quantity) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if($post_payment == 'pulsa' && $gte_acc == false) {
        ShennXit(['type' => false,'message' => ucfirst($check_operators).' numbers are not supported in this method.']);
    } else if($post_quantity < $gte_min) {
        ShennXit(['type' => false,'message' => 'The minimum deposit amount is IDR '.number_format($gte_min).'.']);
    } else if($post_quantity > $gte_max) {
        ShennXit(['type' => false,'message' => 'The maximum deposit amount is IDR '.number_format($gte_max).'.']);
    } else if($call->query("SELECT id FROM deposit WHERE user = '$sess_username' AND status = 'unpaid'")->num_rows >= 1) {
        ShennXit(['type' => false,'message' => 'You still have unpaid deposit requests.']);
    } else if (date('H') >= '22') { 
        ShennXit(['type' => false,'message' => 'Deposit jam cut off! Back again 01.00']);
    } else if($call->query("SELECT wid FROM deposit WHERE wid = '$post_rid'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'Clashing System, please try again.']);
    } else {
        if($data_depo['payment_gateway'] == 'Paydisini') {
            $data_paydisini = $call->query("SELECT * FROM provider WHERE code = 'PAYDISINI'")->fetch_assoc();
            $totals = $post_kodeuniq+$gte_sal;
            $sign = md5($data_paydisini['apikey'] . $post_rid . $data_depo['kodepayment'] . ($gte_sal + $gte_fee) . '10800' . 'NewTransaction');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $data_paydisini['link']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'key='.$data_paydisini['apikey'].'&request=new&unique_code='.$post_rid.'&service='.$data_depo['kodepayment'].'&amount='.($gte_sal + $gte_fee).'&type_fee=1&note=Giat Pedia&valid_time=10800&signature='.$sign);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
            $headers = array();
            $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.5249.91 Safari/537.36';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
                            
            $response = json_decode($result, true);
            
            if($response['success'] == false) {
                ShennXit(['type' => false,'message' => $response['msg'] . '.']);
            } else {
                $checkout_url = $response['data']['checkout_url'];
                $post_note = $checkout_url;
                $in = $call->query("INSERT INTO deposit VALUES (null,'$post_rid','$sess_username','$post_vendr','$post_name','$post_note','$post_sender','0','$gte_fee','$gte_sal','unpaid','$date $time')");                
                redirect(0,$checkout_url);
            }
        } else {
                $in = $call->query("INSERT INTO deposit VALUES (null,'$post_rid','$sess_username','$post_vendr','$post_name','$post_note','$post_sender','$post_kodeuniq','$gte_fee','$gte_sal','unpaid','$date $time')");
            if($in == true) {
                redirect(0,base_url('deposit/invoice/'.$post_rid));
            } else {
                ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
            }
        }
    }
}