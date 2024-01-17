<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if($_POST) {
    $token = isset($_POST['web_token']) ? filter(base64_decode($_POST['web_token'])) : '';
    if($ShennConfirm == 'Pulsa PPOB') {
        $newctt = filter($_POST['trx_note']);
        if($result_csrf == false) {
            print sessResult(false,'System Error, please try again later.');
        } else if($_CONFIG['lock']['status'] == true) {
            print sessResult(false,$_CONFIG['lock']['reason']);
        } else if(!in_array($data_user['level'],['Admin'])) {
            print sessResult(false,'You do not have access to use this feature.');
        } else if($row = $call->query("SELECT id FROM trx_ppob WHERE wid = '$token'")->num_rows == false) {
            print sessResult(false,'Transaction not found.');
        } else {
            if($call->query("UPDATE trx_ppob SET note = '$newctt' WHERE wid = '$token'") == true) {
                print sessResult(true,'Transaction data updated successfully.');
            } else {
                print sessResult(false,'Our server is in trouble, please try again later.');
            }
        }
        die;
    } if($ShennConfirm == 'Social Media') {
        $newstr = filter($_POST['trx_count']);
        $newrmn = filter($_POST['trx_remain']);
        $newctt = filter($_POST['trx_note']);
        if($result_csrf == false) {
            print sessResult(false,'System Error, please try again later.');
        } else if($_CONFIG['lock']['status'] == true) {
            print sessResult(false,$_CONFIG['lock']['reason']);
        } else if(!in_array($data_user['level'],['Admin'])) {
            print sessResult(false,'You do not have access to use this feature.');
        } else if($row = $call->query("SELECT id FROM trx_socmed WHERE wid = '$token'")->num_rows == false) {
            print sessResult(false,'Transaction not found.');
        } else {
            if($call->query("UPDATE trx_socmed SET note = '$newctt', count = '$newstr', remain = '$newrmn' WHERE wid = '$token'") == true) {
                print sessResult(true,'Transaction data updated successfully.');
            } else {
                print sessResult(false,'Our server is in trouble, please try again later.');
            }
        }
        die;
    } if($ShennConfirm == 'Game Feature') {
        $newctt = filter($_POST['trx_note']);
        if($result_csrf == false) {
            print sessResult(false,'System Error, please try again later.');
        } else if($_CONFIG['lock']['status'] == true) {
            print sessResult(false,$_CONFIG['lock']['reason']);
        } else if(!in_array($data_user['level'],['Admin'])) {
            print sessResult(false,'You do not have access to use this feature.');
        } else if($row = $call->query("SELECT id FROM trx_game WHERE wid = '$token'")->num_rows == false) {
            print sessResult(false,'Transaction not found.');
        } else {
            if($call->query("UPDATE trx_game SET note = '$newctt' WHERE wid = '$token'") == true) {
                print sessResult(true,'Transaction data updated successfully.');
            } else {
                print sessResult(false,'Our server is in trouble, please try again later.');
            }
        }
        die;
    }
}