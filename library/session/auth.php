<?php
if(isset($_SESSION['user'])) {
    redirect(0,base_url());
} else {
    if(isset($_COOKIE['token']) && isset($_COOKIE['ssid'])) {
        $ShennUID = preg_replace('/[^\d]+/i','',$_COOKIE['ssid']) + 0;
        $ShennKey = filter($_COOKIE['token']);
        $ShennSSO = sha1(sha1(strtotime(date('Y-m-d H:i:s'))));
        $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();
        if(is_array($ShennUser)) {
            $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '".$ShennUser['username']."'");
            if($ShennCheck->num_rows == 1) {
                $check_lock = check_lock($ShennUser['username']);
                if($ShennUser['level'] <> 'Admin' && $_CONFIG['mt']['web'] == 'true') {
                } else if($check_lock['status'] == true && $_CONFIG['mt']['web'] == 'true') {
                } else {
                    $_SESSION['sso'] = $ShennSSO;
                    $_SESSION['user'] = $ShennUser;
                    redirect(0,visited());
                    $call->query("UPDATE users SET sso = '$ShennSSO' WHERE id = ".$ShennUser['id']."");
                    $call->query("UPDATE users_cookie SET active = '$date $time', ua = '$user_agent', ip = '$client_ip' WHERE cookie = '$ShennKey'");
                }
            } else {
                exit(redirect(0,base_url('auth/logout')));
            }
        } else {
            exit(redirect(0,base_url('auth/logout')));
        }
    }
}