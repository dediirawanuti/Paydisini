<?php
require '../connect.php';

if(isset($_SESSION['user']['username'])) {
    $ip = client_ip();
    $geolocation = client_iploc($ip);
    $call->query("INSERT INTO logs VALUES ('','".$_SESSION['user']['username']."','logout','Thank you and see you soon.','success','$ip','$geolocation','$date $time')");
}

if(isset($_COOKIE['token'])) $call->query("DELETE FROM users_cookie WHERE cookie = '".filter($_COOKIE['token'])."'");
setcookie('ssid', '', time() - 3600, '/', '');
setcookie('token', '', time() - 3600, '/', '');
unset($_SESSION['user']);
unset($_SESSION['sso']);
session_destroy();

$_SESSION['result'] = ['type' => true,'message' => 'Successfully logged out.'];
redirect('0',base_url('auth/login'));