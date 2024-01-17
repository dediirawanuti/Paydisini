<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_GET['send']) && $_POST) {
    $old_email = $data_user['email'];
    $new_email = filter($_POST['u_email']);
    
    if($result_csrf == false) {
        print sessResult(false, 'System Error, please try again later.');
    } else if($_CONFIG['lock']['status'] == true) {
        print sessResult(false, $_CONFIG['lock']['reason']);
    } else if($old_email == $new_email) {
        print sessResult(false, 'You didn\'t change your email address.');
    } else if($json_user['new_email'] == $new_email) {
        print sessResult(false, 'Please re-open this modal to resend code.');
    } else if($call->query("SELECT email FROM users WHERE email = '$new_email' AND username != '$sess_username'")->num_rows == 1) {
        print sessResult(false, 'Email address has been registered.');
    } else if($call->query("SELECT email FROM users WHERE info LIKE '%\"new_email\": \"$new_email\"%' AND username != '$sess_username'")->num_rows == 1) {
        print sessResult(false, 'Email address has been registered on change.');
    } else {
        $New_OTP = random(12);
        $json_user['new_email'] = $new_email;
        $json_user['otp_email']['code'] = $New_OTP;
        $json_user['otp_email']['date_create'] = "$date $time";
        $json_user['otp_email']['date_resend'] = "$date $time";
        $json_user['otp_email']['date_expired'] = rdate('Y-m-d H:i:s', '+1 days');
        $json_user['otp_email']['count_resend'] = 0;
        
        $send = mailer($_MAILER, [
            'dest' => $new_email,
            'name' => $data_user['name'],
            'subject' => 'Code for '.$_CONFIG['title'],
            'message' => base64_encode(file_get_contents(base_url('library/layout-mail/confirm-email?name='.urlencode($data_user['name']).'&code='.$New_OTP))),
            'is_template' => 'yes'
        ]);
        
        if($send == true) {
            if($call->query("UPDATE users SET info = '".json_encode($json_user)."' WHERE username = '$sess_username'") == true) {
                print sessResult(true, 'The confirmation code has been successfully sent to your Email.');
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
    } else if(strtotime($json_user['otp_email']['date_expired']) < strtotime($dtme)) {
        print sessResult(false, 'The code has exceeded the time limit, please repeat the request for a change of email address.');
    } else if($json_user['otp_email']['count_resend'] >= 3) {
        print sessResult(false, 'The limit for resending the code is 3 times.');
    } else if(date_diffs($json_user['otp_email']['date_resend'],$dtme,'minute') < 45) {
        print sessResult(false, 'Resend code can only be done in '.(45 - date_diffs($json_user['otp_email']['date_resend'],$dtme,'minute')).' minutes.');
    } else {
        $json_user['otp_email']['date_resend'] = $dtme;
        $json_user['otp_email']['count_resend'] += 1;
        $send = mailer($_MAILER, [
            'dest' => $json_user['new_email'],
            'name' => $data_user['name'],
            'subject' => 'Code for '.$_CONFIG['title'],
            'message' => base64_encode(file_get_contents(base_url('library/layout-mail/confirm-email?name='.urlencode($data_user['name']).'&code='.$json_user['otp_email']['code']))),
            'is_template' => 'yes'
        ]);
        if($send == true) {
            $call->query("UPDATE users SET info = '".json_encode($json_user)."' WHERE username = '$sess_username'");
            print sessResult(true, 'The confirmation code has been successfully sent to your Email.');
        } else {
            print sessResult(false, 'Failed to Send OTP, please try again later.');
        }
    }
    die;
}
    
if(isset($_GET['cancel']) && $_POST) {
    if($json_user['old_email'] == $json_user['new_email']) {
        print sessResult(false, 'Email address change already canceled.');
    } else {
        $json_user['new_email'] = $data_user['email'];
        if($call->query("UPDATE users SET info = '".json_encode($json_user)."' WHERE username = '$sess_username'") == true) {
            print sessResult(true, 'Email address change was canceled successfully.');
        } else {
            print sessResult(false, 'Our server is in trouble, please try again later.');
        }
    }
    die;
}
    
if(isset($_GET['confirm']) && $_POST) {
    $cotp = filter($_POST['c_email']);
    if($result_csrf == false) {
        print sessResult(false, 'System Error, please try again later.');
    } else if($_CONFIG['lock']['status'] == true) {
        print sessResult(false, $_CONFIG['lock']['reason']);
    } else if(strtotime($json_user['otp_email']['date_expired']) < strtotime($dtme)) {
        print sessResult(false, 'The code has exceeded the time limit, please repeat the request for a change of phone number.');
    } else if($cotp <> $json_user['otp_email']['code']) {
        print sessResult(false, 'The code entered is wrong.');
    } else {
        $NEmail = $json_user['new_email'];
        $json_user['old_email'] = $NEmail;
        
        if($call->query("UPDATE users SET email = '$NEmail', info = '".json_encode($json_user)."' WHERE username = '$sess_username'") == true) {
            print sessResult(true, 'Email address change was successfully made.');
        } else {
            print sessResult(false, 'Our server is in trouble, please try again later.');
        }
    }
    die;
}