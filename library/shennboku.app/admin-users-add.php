<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['users_add'])) {
    $post_name = filter($_POST['u_name']);
    $post_email = filter($_POST['u_mail']);
    $post_phone = filter_phone('62',$_POST['u_phone']);
    $post_user = filter($_POST['u_user']);
    $post_level = filter($_POST['u_level']);
    $post_pass = random(12);

    $user_env = json_encode([
        'old_email' => '',
        'new_email' => $post_email,
        'otp_email' => ['code' => rand(111111,999999),'date_create' => date('Y-m-d H:i:s'),'date_resend' => date('Y-m-d H:i:s'),'date_expired' => rdate('Y-m-d H:i:s', '+3 days'),'count_resend' => 0],
        'old_phone' => '',
        'new_phone' => $post_phone,
        'otp_phone' => ['code' => rand(111111,999999),'date_create' => date('Y-m-d H:i:s'),'date_resend' => date('Y-m-d H:i:s'),'date_expired' => rdate('Y-m-d H:i:s', '+3 days'),'count_resend' => 0],
        'change_password' => ['code' => rand(111111,999999),'date_create' => date('Y-m-d H:i:s'),'date_expired' => rdate('Y-m-d H:i:s', '+1 days')],
        'store' => ['name' => $post_name],
    ]);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if($call->query("SELECT id FROM users WHERE username = '$post_user'")->num_rows == 1) {
        ShennXit(['type' => false,'message' => 'Username has been registered.']);
    } else if($call->query("SELECT phone FROM users WHERE phone = '$post_phone'")->num_rows == 1) {
        ShennXit(['type' => false,'message' => 'Phone number has been registered.']);
    } else if($call->query("SELECT phone FROM users WHERE info LIKE '%\"new_phone\": \"$post_phone\"%'")->num_rows == 1) {
        ShennXit(['type' => false,'message' => 'Phone number has been registered on change.']);
    } else if($call->query("SELECT email FROM users WHERE email = '$post_email'")->num_rows == 1) {
        ShennXit(['type' => false,'message' => 'Email address has been registered.']);
    } else if($call->query("SELECT email FROM users WHERE info LIKE '%\"new_email\": \"$post_email\"%'")->num_rows == 1) {
        ShennXit(['type' => false,'message' => 'Email address has been registered on change.']);
    } else if(!in_array($post_level,['Basic','Premium','Admin'])) {
        ShennXit(['type' => false,'message' => 'Invalid input.']);
    } else {
        if($call->query("INSERT INTO users VALUES (null, '$post_name', '$post_email', '$post_phone', '$post_user', '".bcrypt($post_pass)."', '".bcrypt('221120')."', '0', '0', '$post_level', '".random(16)."', '".$data_user['referral']."', 'active', '$dtme', '$user_env', '".sha1(sha1(strtotime(date('Y-m-d H:i:s'))))."')") == true) {
            $call->query("INSERT INTO logs VALUES (null, '$post_user', 'register', 'Welcome!', 'success', '$client_ip', '$client_iploc', '$dtme')");
            $call->query("INSERT INTO users_api VALUES ('$post_user', '".random(8)."', '".random(64)."', '', '', 'development')");
            ShennXit([
                'type' => true,
                'message' => 'User has been registered.<hr>
                    ------------------------------<br>
                    Account: '.$post_level.'<br>
                    Username: '.$post_user.'<br>
                    Password: '.$post_pass.'<br>
                    Default PIN: 221120<br>
                    '.base_url('auth/login').'<br>
                    ------------------------------'
            ]);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}