<?php
if(!isset($_SESSION['user'])) {
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
    } else {
        ShennXit(['type' => false,'message' => 'Authentication required, please log in first.'],base_url('auth/login'));
    }
}

if(isset($_SESSION['user'])) {
    $sess_username = $_SESSION['user']['username'];
    if($call->query("SELECT * FROM users WHERE username = '$sess_username'")->num_rows == 0) exit(redirect(0,base_url('auth/logout')));

    $data_user = $call->query("SELECT * FROM users WHERE username = '$sess_username'")->fetch_assoc();
    $json_user = json_decode($data_user['info'], true);
    $data_userapi = $call->query("SELECT * FROM users_api WHERE user = '$sess_username'")->fetch_assoc();
    
    $sess_cookie = isset($_COOKIE['token']) ? filter($_COOKIE['token']) : '';
    $data_usercookie = $call->query("SELECT * FROM users_cookie WHERE cookie = '$sess_cookie' AND username = '$sess_username'");
    if($data_usercookie->num_rows == 1) $data_usercookie = $data_usercookie->fetch_assoc();
    $data_usercookie = (is_array($data_usercookie)) ? $data_usercookie : exit(redirect(0,base_url('auth/logout')));
    
    $equalUserMail = ($json_user['old_email'] == $json_user['new_email']) ? true : false;
    $equalUserPhone = ($json_user['old_phone'] == $json_user['new_phone']) ? true : false;
    
    $sess_username = $data_user['username'];
    $avatar = gravatar($data_user['email']);
    if($data_user['status'] <> 'active') {
        exit(redirect(0,base_url('auth/logout')));
    } else if($data_user['level'] <> 'Admin' && $_CONFIG['mt']['web'] == 'true') {
        exit(redirect(0,base_url('auth/logout')));
    } else if($_CONFIG['lock']['status'] == true && $_CONFIG['mt']['web'] == 'true') {
        exit(redirect(0,base_url('auth/logout')));
    } else if(conf('xtra-fitur',5) == 'true' && $data_user['sso'] <> $_SESSION['sso']) {
        exit(redirect(0,base_url('auth/logout')));
    } else if($equalUserMail == false && $json_user['old_email'] == '' && !isset($STOP_REDIRECT)) {
        ShennXit(['type' => false,'message' => 'Please validate your email address.'],base_url('account/profile'));
    } else if($equalUserPhone == false && $json_user['old_phone'] == '' && !isset($STOP_REDIRECT)) {
        ShennXit(['type' => false,'message' => 'Please validate your phone number.'],base_url('account/profile'));
    } else if($_SESSION['user']['password'] <> $data_user['password']) {
        ShennXit(['type' => false,'message' => 'Password has been changed, please log back in.'],base_url('auth/logout'));
    }
}