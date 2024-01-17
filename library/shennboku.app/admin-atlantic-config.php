<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$sky = 'FAIL';
$smu = 'FAIL';
$swa = 'FAIL';

if(isset($_POST['save'])) {
    $post_apiid = filter($_POST['apiid']);
    $post_apikey = filter($_POST['apikey']);
    $post_musid = filter($_POST['musid']);
    $post_wasid = filter($_POST['wasid']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!$post_apiid || !$post_apikey) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$post_apiid || !$post_apikey) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else {
        $try = $curl->connectPost('https://atlantic-group.co.id/api/v1/validation', ['key' => $post_apikey,'sign' => md5($post_apiid.$post_apikey)]);
        if(isset($try['result'])) {
            if($try['result'] == true) {
                $sky = 'OK';
                $smu = (isset($try['data']['mutation'][$post_musid])) ? $try['data']['mutation'][$post_musid] : 'FAIL';
                $swa = (isset($try['data']['whatsapp'][$post_wasid])) ? $try['data']['whatsapp'][$post_wasid] : 'FAIL';
                
                $post_musid = ($smu == 'FAIL') ? '' : $post_musid;
                $post_wasid = ($swa == 'FAIL') ? '' : $post_wasid;
                
                if($call->query("UPDATE conf SET c1 = '$post_apiid', c2 = '$post_apikey', c3 = '$post_musid', c4 = '$post_wasid' WHERE code = 'atlantic-cfg'") == true) {
                    ShennXit(['type' => true,'message' => 'Atlantic Group config updated.']);
                } else {
                    ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
                }
            } else {
                ShennXit(['type' => false,'message' => $try['message']]);
            }
        } else {
            ShennXit(['type' => false,'message' => 'Connection Failed.']);
        }
    }
} else {
    $try = $curl->connectPost('https://atlantic-group.co.id/api/v1/validation', ['key' => conf('atlantic-cfg', 2),'sign' => md5(conf('atlantic-cfg', 1).conf('atlantic-cfg', 2))]);
    if(isset($try['result'])) {
        if($try['result'] == true) {
            $sky = 'OK';
            $smu = (isset($try['data']['mutation'][conf('atlantic-cfg', 3)])) ? $try['data']['mutation'][conf('atlantic-cfg', 3)] : 'FAIL';
            $swa = (isset($try['data']['whatsapp'][conf('atlantic-cfg', 4)])) ? $try['data']['whatsapp'][conf('atlantic-cfg', 4)] : 'FAIL';
            $post_musid = ($smu == 'FAIL') ? '' : conf('atlantic-cfg', 3);
            $post_wasid = ($swa == 'FAIL') ? '' : conf('atlantic-cfg', 4);
            $call->query("UPDATE conf SET c3 = '$post_musid', c4 = '$post_wasid' WHERE code = 'atlantic-cfg'");
        }
    }
}