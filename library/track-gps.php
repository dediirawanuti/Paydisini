<?php
require '../connect.php';
require _DIR_('library/session/session');

if(isset($_POST) && isset($sess_username) && isset($data_user['id'])) {
    $device_os = isset($_POST['os_name']) ? filter($_POST['os_name']) : 'unknown';
    $device_type = isset($_POST['device_type']) ? filter($_POST['device_type']) : 'unknown';
    $device_browser = isset($_POST['browser']) ? filter($_POST['browser']) : 'unknown';
    $device_latitude = isset($_POST['latitude']) ? filter($_POST['latitude']) : '-';
    $device_longitude = isset($_POST['longitude']) ? filter($_POST['longitude']) : '-';
    $device_longlat = ($device_latitude == '-' && $device_longitude == '-') ? '-' : "$device_latitude, $device_longitude";
    
    if($device_longlat <> '-') {
        $WHERE = "WHERE user = '$sess_username' AND lat = '$device_latitude' AND lon = '$device_longitude'";
        if($call->query("SELECT id FROM users_location $WHERE")->num_rows == 1) {
            $check = $call->query("SELECT date_up FROM users_location $WHERE")->fetch_assoc();
            if(substr($check['date_up'],0,10) == $date) {
                $qry = "UPDATE users_location SET ua = '$user_agent', ud = '$device_type', ip = '$client_ip', loc = '$client_iploc', dev = '$device_os', date_up = '$date $time' $WHERE";
            } else {
                $qry = "UPDATE users_location SET ua = '$user_agent', ud = '$device_type', ip = '$client_ip', loc = '$client_iploc', dev = '$device_os', total = total+1, date_up = '$date $time' $WHERE";
            }
            $call->query($qry);
        } else {
            $call->query("INSERT INTO users_location VALUES ('','$sess_username','$device_longitude','$device_latitude','$user_agent','$device_type','$client_ip','$client_iploc','$device_os','1','$date $time','$date $time')");
        }
    }
}