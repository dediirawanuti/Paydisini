<?php
require '../connect.php';

$data_paydisini = $call->query("SELECT * FROM provider WHERE code = 'PAYDISINI'")->fetch_assoc();
if($_POST['key'] == $data_paydisini['apikey'] AND $_SERVER['REMOTE_ADDR'] == '154.26.137.133'){
    $payment_id = 'YOUR PAYMENT ID (UNIQUE CODE)';
    $key = $_POST['key'];
    $unique_code = $_POST['unique_code'];
    $status = $_POST['status'];
    $signature = $_POST['signature'];
    $check_deposit = $call->query("SELECT * FROM deposit WHERE wid = '$unique_code' AND status = 'unpaid'");
    if (mysqli_num_rows($check_deposit) >= 1) {
    $data_deposit = $check_deposit->fetch_assoc();
    $sign = md5($data_paydisini['apikey'] . $unique_code . 'CallbackStatus');
        if($signature != $sign){
            $result = array('success' => false);
        } else if($status == 'Success'){
            $call->query("INSERT INTO mutation VALUES (null,'".$data_deposit['user']."','+','".$data_deposit['amount']."','Deposit :: ".$data_deposit['wid']."','$date $time')");
            $update = $call->query("UPDATE deposit SET status = 'paid' WHERE id = '{$data_deposit['id']}'");
            $update = $call->query("UPDATE users SET balance = balance+{$data_deposit['amount']} WHERE username = '{$data_deposit['user']}'");
            if ($update == true) {
                $result = array('success' => true);
            }
        } else if($status == 'Canceled'){
            $update = $call->query("UPDATE deposit SET status = 'cancelled' WHERE id = '{$data_deposit['id']}'");
            
            if ($update == true) {
                $result = array('success' => true);
            }
        } else {
            $result = array('success' => false);
        }
    } else {
        $result = array('success' => false);
    }
}

header('Content-type: application/json');
echo json_encode($result);
