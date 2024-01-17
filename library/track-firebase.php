<?php
require '../connect.php';
require _DIR_('library/session/session');

if(isset($_COOKIE['token']) && isset($_POST) && isset($data_user['id'])) {
    if($call->query("SELECT cookie FROM users_cookie WHERE cookie = '".filter($_COOKIE['token'])."'")->num_rows == 1) {
        $fcm_1 = isset($_POST['validate']) ? filter($_POST['validate']) : 'unknown';
        $fcm_2 = isset($_POST['token']) ? filter($_POST['token']) : 'unknown';
        if($data_usercookie['token'] <> $fcm_2) $call->query("UPDATE users_cookie SET token = '$fcm_2' WHERE cookie = '".filter($_COOKIE['token'])."'");
    }
}