<?php
require '../connect.php';
require _DIR_('library/session/session');

if(isset($_COOKIE['token']) && isset($_POST) && isset($data_user['id'])) {
    if($call->query("SELECT cookie FROM users_cookie WHERE cookie = '".filter($_COOKIE['token'])."'")->num_rows == 1) {
        $device_os = isset($_POST['os_name']) ? filter($_POST['os_name']) : 'unknown';
        $device_type = isset($_POST['device_type']) ? filter($_POST['device_type']) : 'unknown';
        $device_browser = isset($_POST['browser']) ? filter($_POST['browser']) : 'unknown';
        $device_latitude = isset($_POST['latitude']) ? filter($_POST['latitude']) : '-';
        $device_longitude = isset($_POST['longitude']) ? filter($_POST['longitude']) : '-';
        $device_longlat = ($device_latitude == '-' && $device_longitude == '-') ? '-' : "$device_latitude, $device_longitude";
        $call->query("UPDATE users_cookie SET active = '$date $time', ua = '$user_agent', ud = '$device_type', ip = '$client_ip', loc = '$client_iploc', dev = '$device_os', coor = '$device_longlat', browser = '$device_browser' WHERE cookie = '".filter($_COOKIE['token'])."'");
    }
}