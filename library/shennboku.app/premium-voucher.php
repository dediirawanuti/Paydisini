<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['submit'])) {
    $kodenya = strtoupper(random(8));
    $saldonya = filter($_POST['amount']);

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Premium','Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($saldonya < 500) {
        ShennXit(['type' => false,'message' => 'The minimum voucher balance is 500.']);
    } else if($data_user['balance'] < $saldonya) {
        ShennXit(['type' => false,'message' => 'Your balance is not enough to create voucher.']);
    } else if($data_user['balance'] < ($saldonya+$_CONFIG['hold'][$data_user['level']])) {
        ShennXit(['type' => false,'message' => 'Your minimum account balance is '.number_format($_CONFIG['hold'][$data_user['level']]).'.']);
    } else if($call->query("SELECT code FROM voucher WHERE code = '$kodenya'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'Clashing System, please try again.']);
    } else {
        $up = $call->query("UPDATE users SET balance = balance-$saldonya WHERE username = '$sess_username'");
        $up = $call->query("INSERT INTO mutation VALUES (null,'$sess_username','-','$saldonya','Voucher Rp ".currency($saldonya)." :: $kodenya','$date $time')");
        $up = $call->query("INSERT INTO voucher VALUES (null,'$kodenya','$saldonya','$sess_username','','available','$date $time','$date $time')");
        if($up == TRUE) {
            ShennXit(['type' => true,'message' => 'Voucher code has been successfully generated, '.$kodenya.'.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}