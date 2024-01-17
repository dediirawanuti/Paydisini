<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_GET['feature']) && $_POST) {
    $val = strtr($_POST['value'],['trxpostpaid'=>'c1','trxgame'=>'c2','trxsocmed'=>'c3','hofpage'=>'c4','ssodevice'=>'c5','reqlocfwa'=>'c6','devmode'=>'c7']);
    if($result_csrf == false) {
        print sessResult(false, 'System Error, please try again later.');
    } else if($_CONFIG['lock']['status'] == true) {
        print sessResult(false, $_CONFIG['lock']['reason']);
    } else if(!in_array($data_user['level'],['Admin'])) {
        print sessResult(false, 'You do not have access to use this feature.');
    } else if(!in_array($val,['c1','c2','c3','c4','c5','c6','c7'])) {
        print sessResult(false, 'Value does not match.');
    } else {
        $upd = (conf('xtra-fitur', $val) == 'true') ? 'false' : 'true';
        if($call->query("UPDATE conf SET $val = '$upd' WHERE code = 'xtra-fitur'")) {
            print sessResult(true, 'The changes have been successfully made.');
        } else {
            print sessResult(false, 'Our server is in trouble, please try again later.');
        }
    }
    die;
}

if(isset($_GET['maintenance']) && $_POST) {
    $val = strtr($_POST['value'],['website'=>'c1','restapi'=>'c2','wabot'=>'c3','telebot'=>'c4','trx'=>'c5','topup'=>'c6',]);
    if($result_csrf == false) {
        print sessResult(false, 'System Error, please try again later.');
    } else if($_CONFIG['lock']['status'] == true) {
        print sessResult(false, $_CONFIG['lock']['reason']);
    } else if(!in_array($data_user['level'],['Admin'])) {
        print sessResult(false, 'You do not have access to use this feature.');
    } else if(!in_array($val,['c1','c2','c3','c4','c5','c6'])) {
        print sessResult(false, 'Value does not match.');
    } else {
        $upd = (conf('webmt', $val) == 'true') ? 'false' : 'true';
        if($call->query("UPDATE conf SET $val = '$upd' WHERE code = 'webmt'")) {
            print sessResult(true, 'The changes have been successfully made.');
        } else {
            print sessResult(false, 'Our server is in trouble, please try again later.');
        }
    }
    die;
}