<?php
header('Content-Type: application/json');
require '../connect.php';

if($_CONFIG['mt']['api'] == 'true') ShennDie(['result' => false,'data' => null,'message' => 'Ada pemeliharaan sistem API, coba lagi nanti.']);
if(isset($_POST['key']) && isset($_POST['sign'])) {
    $key = filter($_POST['key']);
    $sign = filter($_POST['sign']);

    $s_api = $call->query("SELECT * FROM users_api WHERE ukey = '$key'");
    if($s_api->num_rows == 0) ShennDie(['result' => false,'data' => null,'message' => 'API Key not registered.']);
    $r_api = $s_api->fetch_assoc();
    $username = $r_api['user'];
    $data_user = data_user($username);
    if($data_user == false) ShennDie(['result' => false,'data' => null,'message' => 'User not found.']);
    if($sign <> md5($r_api['uid'].$r_api['ukey'])) ShennDie(['result' => false,'data' => null,'message' => 'API Signature not valid.']);
    if(check_ip($client_ip, $r_api['whitelist']) == false) ShennDie(['result' => false,'data' => null,'message' => 'IP '.$client_ip.' is not permitted']);
    $sess_username = $data_user['username'];
    
    ShennDie(['result' => true,'data' => [
        'full_name' => $data_user['name'],
        'username' => $sess_username,
        'balance' => (int)$data_user['balance'],
        'point' => (int)$data_user['point'],
        'level' => $data_user['level'],
        'registered' => $data_user['date'],
    ],'message' => 'Successfully got your account details.']);
} else {
    ShennDie(['result' => false,'data' => $_POST,'message' => 'Request not detected.']);
}