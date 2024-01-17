<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
function ShennCheck($code,$uid,$ukey) {
    global $curl; global $call;
    if($call->query("SELECT * FROM provider WHERE code = '$code'")->num_rows == 1) {
        $data = $call->query("SELECT * FROM provider WHERE code = '$code'")->fetch_assoc();
        if($code == 'IRVAN') {
            $json = $curl->connectPost($data['link'].'/profile',['api_id' => $uid, 'api_key' => $ukey]);
            if(isset($json['status'])) {
                if($json['status'] == true) {
                    $res = ['type' => true,'data' => $json['data']];
                    $call->query("UPDATE provider SET balance = '".$json['data']['balance']."' WHERE code = '$code'");
                }
                if($json['status'] == false) $res = ['type' => false,'msg' => $json['data']];
            } else {
                $res = ['type' => false,'msg' => 'Connection Failed!'];
            }
        } else if($code == 'PAYDISINI') {
            $sign = md5($ukey . 'PaymentChannel');
            $json = $curl->connectHeaderPost($data['link'],['User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.5249.91 Safari/537.36'],['key' => $ukey,'request' => 'payment_channel', 'signature' => $sign]);
            if(isset($json['success'])) {
                if($json['success'] == true) {
                    $res = ['type' => true,'data' => $json['data']['name']];
                }
                if($json['success'] == false) $res = ['type' => false,'msg' => $json['msg']];
            } else {
                $res = ['type' => false,'msg' => 'Connection Failed!'];
            }
        } else {
            $res = ['type' => false,'msg' => 'Connection not found!'];
        }
    } else {
        $res = ['type' => false,'msg' => 'Provider not registered!'];
    }
    return $res;
}

if(isset($_POST['save'])) {
    $web_token = base64_decode($_POST['web_token']);
    $api_id = (isset($_POST['userid'])) ? filter($_POST['userid']) : '-';
    $apikey = (!empty($_POST['apikey'])) ? filter($_POST['apikey']) : '';
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else {
        $try = (!$apikey) ? ['type' => true] : ShennCheck($web_token,$api_id,$apikey);
        if($try['type'] == true) {
            if($call->query("UPDATE provider SET userid = '$api_id', apikey = '$apikey' WHERE code = '$web_token'") == true) {
                ShennXit(['type' => true,'message' => 'Connection success, data updated.']);
            } else {
                ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
            }
        } else {
            ShennXit(['type' => false,'message' => $try['msg']]);
        }
    }
}