<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['login'])) {
    $post_user = filter($_POST['user']);
    $post_pass = filter($_POST['pass']);
    
    $post_remember = (isset($_POST['remember'])) ? filter_entities($_POST['remember']) : false;
    $cookie_time = ($post_remember == 'true') ? time() + (86400 * 90) : time() + 10800;
    $cookie_expr = date('Y-m-d H:i:s', $cookie_time);
	$ShennCookie = random(86);
	$ShennSSO = sha1(sha1(strtotime(date('Y-m-d H:i:s'))));

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if(!$post_user || !$post_pass) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else {
        if($call->query("SELECT * FROM users WHERE username = '$post_user' OR email = '$post_user' OR phone = '$post_user'")->num_rows == 0) {
            ShennXit(['type' => false,'message' => 'Account not registered.']);
        } else {
            $data_user = $call->query("SELECT * FROM users WHERE username = '$post_user' OR email = '$post_user' OR phone = '$post_user'")->fetch_assoc();
            if($data_user['status'] == 'suspend') {
                ShennXit(['type' => false,'message' => 'Account suspended, please contact admin.']);
            } else if($data_user['status'] !== 'active') {
                ShennXit(['type' => false,'message' => 'Your account is not active, please contact admin.']);
            } else {
                $post_user = $data_user['username'];
                if(check_bcrypt($post_pass,$data_user['password']) == true) {
                    $check_lock = check_lock($data_user['username']);
                    if($data_user['level'] <> 'Admin' && $_CONFIG['mt']['web'] == 'true') {
                        ShennXit(['type' => false,'message' => 'There is a website system maintenance, please try again later.']);
                    } else if($check_lock['status'] == true && $_CONFIG['mt']['web'] == 'true') {
                        ShennXit(['type' => false,'message' => 'There is a website system maintenance, please try again later.']);
                    } else {
                        setcookie('ssid', 'SHENN-'.$data_user['id'].'SAFA', $cookie_time, '/', '');
                        setcookie('token', $ShennCookie, $cookie_time, '/', '');
                        $call->query("INSERT INTO users_cookie VALUES ('$ShennCookie', '', '$post_user', '$date $time', '$cookie_expr', '$user_agent', 'unknown', '$client_ip', '$client_iploc', 'unknown', '-', 'unknown')");
                        $call->query("UPDATE users SET sso = '$ShennSSO' WHERE id = ".$data_user['id']."");
                        
                        $_SESSION['sso'] = $ShennSSO;
                        $_SESSION['user'] = $data_user;
                        $call->query("INSERT INTO logs VALUES (null,'$post_user','login','Welcome back.','success','$client_ip','$client_iploc','$date $time')");
                        
                        sendFCMnotif($FCM, $post_user, 'Halo '.$post_user.', anda baru saja login di tempat lain dengan IP '.$client_ip.'. Jika ini bukan anda, silahkan login dan segera ganti password anda.', 'browser', 'account-login');
                        ShennXit(['type' => true,'message' => 'Welcome, '.ucwords(strtolower($data_user['name'])).'.'],base_url());
                    }
                } else {
                    ShennXit(['type' => false,'message' => 'Invalid Password.']);
                }
            }
        }
    }
}