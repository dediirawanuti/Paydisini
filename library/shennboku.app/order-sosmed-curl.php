<?php
if(!isset($call) && !isset($provider) && !isset($data_prv))
    die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
    
if($provider == 'IRVAN') {
    $try = $curl->connectPost($data_prv['link'].'/order',['api_id' => $data_prv['userid'],'api_key' => $data_prv['apikey'],'service' => $provid,'target' => $post_tgt,'quantity' => $post_qty]);
    if($try['status'] == true) {
        $req_result = true;
        $req_provid = $try['data']['id'];
        $req_remain = 0;
        $req_count = 0;
    } else {
        $req_result = false;
        $req_message = isset($try['msg']) ? $try['msg'] : 'Connection Failed!';
    }
} else if($provider == 'X') {
    $req_result = true;
    $req_provid = $ShennTRX;
    $req_note = 'Your order will be processed immediately.';
   
    // $try = TrxNotifier($sess_username,$service,$post_tgt,$post_qty);
    // if($try['result'] == true) {
    //    $req_result = true;
    //    $req_provid = $ShennTRX;
    //    $req_remain = 0;
    //    $req_count = 0;
    // } else {
    //    $req_result = false;
    //    $req_message = 'Gagal melakukan pemesanan, silahkan coba lagi nanti.';
    // }
}