<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['send'])) {
    $pst_email = filter($_POST['email']);
    $su = $call->query("SELECT * FROM users WHERE email = '$pst_email'");
    if($su->num_rows == 1) {
        $du = $su->fetch_assoc();
        $dc = json_decode($du['info'], true);
        $_CONFIG['lock'] = check_lock($du['username']);
    }

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($su->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Email not registered.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else {
        $New_OTP = random_number(6);
        $dc['change_password']['code'] = $New_OTP;
        $dc['change_password']['date_create'] = "$date $time";
        $dc['change_password']['date_resend'] = "$date $time";
        $dc['change_password']['date_expired'] = rdate('Y-m-d H:i:s', '+8 hours');
        $dc['change_password']['count_resend'] = 0;
        
        $send = mailer($_MAILER, [
            'dest' => $du['email'],
            'name' => $du['name'],
            'subject' => 'Code for '.$_CONFIG['title'],
            'message' => base64_encode(file_get_contents(base_url('library/layout-mail/confirm-password?name='.urlencode($du['name']).'&code='.$New_OTP))),
            'is_template' => 'yes'
        ]);
        
        if($send == true) {
            if($call->query("UPDATE users SET info = '".json_encode($dc)."' WHERE username = '".$du['username']."'") == true) {
                $_SESSION['changepass'] = $du['email'];
                ShennXit(['type' => true,'message' => 'The one time password has been successfully sent to your Email.']);
            } else {
                ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
            }
        } else {
            ShennXit(['type' => false,'message' => 'Failed to Send OTP, please try again later.']);
        }
    }
}
    
if(isset($_POST['resend']) && isset($_SESSION['changepass'])) {
    $pst_email = filter($_SESSION['changepass']);
    $su = $call->query("SELECT * FROM users WHERE email = '$pst_email'");
    if($su->num_rows == 1) {
        $du = $su->fetch_assoc();
        $dc = json_decode($du['info'], true);
        $_CONFIG['lock'] = check_lock($du['username']);
    }
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($su->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Email not registered.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(strtotime($dc['change_password']['date_expired']) < strtotime($dtme)) {
        ShennXit(['type' => false,'message' => 'The code has exceeded the time limit, please repeat the password reset request.']);
    } else if($dc['change_password']['count_resend'] >= 3) {
        ShennXit(['type' => false,'message' => 'The limit for resending the code is 3 times.']);
    } else if(date_diffs($dc['change_password']['date_resend'],$dtme,'minute') < 45) {
        ShennXit(['type' => false,'message' => 'Resend code can only be done in 45 minutes.']);
    } else {
        $dc['change_password']['date_resend'] = $dtme;
        $dc['change_password']['date_expired'] = rdate('Y-m-d H:i:s', '+8 hours');
        $dc['change_password']['count_resend'] += 1;
        $send = mailer($_MAILER, [
            'dest' => $du['email'],
            'name' => $du['name'],
            'subject' => 'Code for '.$_CONFIG['title'],
            'message' => base64_encode(file_get_contents(base_url('library/layout-mail/confirm-password?name='.urlencode($du['name']).'&code='.$dc['change_password']['code']))),
            'is_template' => 'yes'
        ]);
        if($send == true) {
            $call->query("UPDATE users SET info = '".json_encode($dc)."' WHERE username = '".$du['username']."'");
            ShennXit(['type' => true,'message' => 'The one time password has been successfully sent to your Email.']);
        } else {
            ShennXit(['type' => false,'message' => 'Failed to Send OTP, please try again later.']);
        }
    }
}
    
if(isset($_POST['cancel']) && isset($_SESSION['changepass'])) {
    $pst_email = filter($_SESSION['changepass']);
    $su = $call->query("SELECT * FROM users WHERE email = '$pst_email'");
    if($su->num_rows == 0) ShennXit(['type' => false,'message' => 'Email not registered.']);
    $du = $su->fetch_assoc();
    $dc = json_decode($du['info'], true);
    $dc['change_password']['date_expired'] = $dtme;
    if($call->query("UPDATE users SET info = '".json_encode($dc)."' WHERE username = '".$du['username']."'") == true) {
        unset($_SESSION['changepass']);
        ShennXit(['type' => true,'message' => 'The password reset request was canceled successfully.']);
    } else {
        ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
    }
}
    
if(isset($_POST['confirm']) && isset($_SESSION['changepass'])) {
    $pst_email = filter($_SESSION['changepass']);
    $pst_onetime = filter($_POST['otp']);
    $pst_password = filter($_POST['password']);
    $su = $call->query("SELECT * FROM users WHERE email = '$pst_email'");
    if($su->num_rows == 1) {
        $du = $su->fetch_assoc();
        $dc = json_decode($du['info'], true);
        $_CONFIG['lock'] = check_lock($du['username']);
    }
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($su->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Email not registered.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(strtotime($dc['change_password']['date_expired']) < strtotime($dtme)) {
        ShennXit(['type' => false,'message' => 'The code has exceeded the time limit, please repeat the password reset request.']);
    } else if($pst_onetime <> $dc['change_password']['code']) {
        ShennXit(['type' => false,'message' => 'The code entered is wrong.']);
    } else {
        $dc['change_password']['date_expired'] = $dtme;
        if($call->query("UPDATE users SET password = '".bcrypt($pst_password)."', info = '".json_encode($dc)."' WHERE username = '".$du['username']."'") == true) {
            $call->query("DELETE FROM users_cookie WHERE username = '".$du['username']."'");
            unset($_SESSION['changepass']);
            ShennXit(['type' => true,'message' => 'Your password has been reset successfully, please log in.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}