<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_GET['send']) && $_POST) {
    $old_phone = $data_user['phone'];
    $new_phone = filter_phone('62',$_POST['u_phone']);
    
    if($result_csrf == false) {
        print sessResult(false, 'System Error, please try again later.');
    } else if($_CONFIG['lock']['status'] == true) {
        print sessResult(false, $_CONFIG['lock']['reason']);
    } else if($old_phone == $new_phone) {
        print sessResult(false, 'You didn\'t change your phone number.');
    } else if($json_user['new_phone'] == $new_phone) {
        print sessResult(false, 'Please re-open this modal to resend code.');
    } else if($call->query("SELECT phone FROM users WHERE phone = '$new_phone' AND username != '$sess_username'")->num_rows == 1) {
        print sessResult(false, 'Phone number has been registered.');
    } else if($call->query("SELECT phone FROM users WHERE info LIKE '%\"new_phone\": \"$new_phone\"%' AND username != '$sess_username'")->num_rows == 1) {
        print sessResult(false, 'Phone number has been registered on change.');
    } else {
        $New_OTP = random_number(6);
        $json_user['new_phone'] = $new_phone;
        $json_user['otp_phone']['code'] = $New_OTP;
        $json_user['otp_phone']['date_create'] = $dtme;
        $json_user['otp_phone']['date_resend'] = $dtme;
        $json_user['otp_phone']['date_expired'] = rdate('Y-m-d H:i:s', '+1 days');
        $json_user['otp_phone']['count_resend'] = 0;
        
        $waValid = (!empty(conf('atlantic-cfg', 4))) ? true : false;
        $send['result'] = ($waValid == true) ? @$WATL->sendMessage($new_phone, "*Halo $sess_username*\n*Kode OTP anda adalah* ```$New_OTP```\n*- ".$_CONFIG['title']."*")['result'] : mailer($_MAILER, [
            'dest' => $data_user['email'],
            'name' => $data_user['name'],
            'subject' => 'Code for '.$_CONFIG['title'],
            'message' => base64_encode(file_get_contents(base_url('library/layout-mail/change-phone?name='.urlencode($data_user['name']).'&code='.$New_OTP))),
            'is_template' => 'yes'
        ]);
        
        if($send['result'] == true) {
            if($call->query("UPDATE users SET info = '".json_encode($json_user)."' WHERE username = '$sess_username'") == true) {
                $waMsg = ($waValid == true) ? 'WhatsApp' : 'Email Address';
                print sessResult(true, 'The confirmation code has been successfully sent to your '.$waMsg.'.');
            } else {
                print sessResult(false, 'Our server is in trouble, please try again later.');
            }
        } else {
            print sessResult(false, 'Failed to Send OTP, please try again later.');
        }
    }
    die;
}
    
if(isset($_GET['resend']) && $_POST) {
    if($result_csrf == false) {
        print sessResult(false, 'System Error, please try again later.');
    } else if($_CONFIG['lock']['status'] == true) {
        print sessResult(false, $_CONFIG['lock']['reason']);
    } else if(strtotime($json_user['otp_phone']['date_expired']) < strtotime($dtme)) {
        print sessResult(false, 'The code has exceeded the time limit, please repeat the request for a change of phone number.');
    } else if($json_user['otp_phone']['count_resend'] >= 3) {
        print sessResult(false, 'The limit for resending the code is 3 times.');
    } else if(date_diffs($json_user['otp_phone']['date_resend'],$dtme,'minute') < 3) {
        print sessResult(false, 'Resend code can only be done in '.(3 - date_diffs($json_user['otp_phone']['date_resend'],$dtme,'minute')).' minutes.');
    } else {
        $json_user['otp_phone']['date_resend'] = $dtme;
        $json_user['otp_phone']['count_resend'] += 1;
        
        $waValid = (!empty(conf('atlantic-cfg', 4))) ? true : false;
        $send['result'] = ($waValid == true) ? @$WATL->sendMessage($new_phone, "*Halo $sess_username*\n*Kode OTP anda adalah* ```".$json_user['otp_phone']['code']."```\n*- ".$_CONFIG['title']."*")['result'] : mailer($_MAILER, [
            'dest' => $data_user['email'],
            'name' => $data_user['name'],
            'subject' => 'Code for '.$_CONFIG['title'],
            'message' => base64_encode(file_get_contents(base_url('library/layout-mail/change-phone?name='.urlencode($data_user['name']).'&code='.$json_user['otp_phone']['code']))),
            'is_template' => 'yes'
        ]);
        
        if($send['result'] == true) {
            $call->query("UPDATE users SET info = '".json_encode($json_user)."' WHERE username = '$sess_username'");
            $waMsg = ($waValid == true) ? 'WhatsApp' : 'Email Address';
            print sessResult(true, 'The confirmation code has been successfully sent to your '.$waMsg.'.');
        } else {
            print sessResult(false, 'Failed to Send OTP, please try again later.');
        }
    }
    die;
}
    
if(isset($_GET['cancel']) && $_POST) {
    if($result_csrf == false) {
        print sessResult(false, 'System Error, please try again later.');
    } else if($_CONFIG['lock']['status'] == true) {
        print sessResult(false, $_CONFIG['lock']['reason']);
    } else if($json_user['old_phone'] == $json_user['new_phone']) {
        print sessResult(false, 'Phone number change already canceled.');
    } else {
        $json_user['new_phone'] = $data_user['phone'];
        if($call->query("UPDATE users SET info = '".json_encode($json_user)."' WHERE username = '$sess_username'") == true) {
            print sessResult(true, 'Phone number change was canceled successfully.');
        } else {
            print sessResult(false, 'Our server is in trouble, please try again later.');
        }
    }
    die;
}
    
if(isset($_GET['confirm']) && $_POST) {
    $cotp = filter($_POST['c_phone']);
    if($result_csrf == false) {
        print sessResult(false, 'System Error, please try again later.');
    } else if($_CONFIG['lock']['status'] == true) {
        print sessResult(false, $_CONFIG['lock']['reason']);
    } else if(strtotime($json_user['otp_phone']['date_expired']) < strtotime($dtme)) {
        print sessResult(false, 'The code has exceeded the time limit, please repeat the request for a change of phone number.');
    } else if($cotp <> $json_user['otp_phone']['code']) {
        print sessResult(false, 'The code entered is wrong.');
    } else {
        $NPhone = $json_user['new_phone'];
        $json_user['old_phone'] = $NPhone;
        
        if($call->query("UPDATE users SET phone = '$NPhone', info = '".json_encode($json_user)."' WHERE username = '$sess_username'") == true) {
            print sessResult(true, 'Phone number change was successfully made.');
        } else {
            print sessResult(false, 'Our server is in trouble, please try again later.');
        }
    }
    die;
}