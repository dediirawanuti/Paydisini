<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_GET['shennboku']) && isset($_POST['app']) && isset($_POST['type'])) {
    if(!in_array($_POST['app'],['browser'])) die(sessResult(false, 'Invalid App.'));
    if($result_csrf == false) {
        print sessResult(false, 'System Error, please try again later.');
    } else if($_CONFIG['lock']['status'] == true) {
        print sessResult(false, $_CONFIG['lock']['reason']);
    } else if(!in_array($data_user['level'],['Admin'])) {
        print sessResult(false, 'You do not have access to use this feature.');
    } else {
        $json_user['notification'][$_POST['app']][filter($_POST['type'])] = (getUserNotif($sess_username, $_POST['app'], filter($_POST['type'])) == true) ? 'false' : 'true';
        if($call->query("UPDATE users SET info = '".json_encode($json_user)."' WHERE username = '$sess_username'")) {
            print sessResult(true, 'The changes have been successfully made.');
        } else {
            print sessResult(false, 'Our server is in trouble, please try again later.');
        }
    }
    die;
}