<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['profile'])) {
    $post_1 = filter($_POST['profile_name']);
    $json_user['store']['name'] = filter($_POST['profile_sname']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else {
        if($call->query("UPDATE users SET name = '$post_1', info = '".json_encode($json_user, JSON_PRETTY_PRINT)."' WHERE username = '$sess_username'") == true) {
            ShennXit(['type' => true,'message' => 'Account Name and Phone updated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['changepass'])) {
    $post_1 = filter($_POST['oldpass']);
    $post_2 = filter($_POST['password']);
    $post_3 = filter($_POST['conpassword']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(strlen($post_2) < 6 || strlen($post_2) < 6) {
        ShennXit(['type' => false,'message' => 'Password at least 6 letters or numbers.']);
    } else if($post_2 <> $post_3) {
        ShennXit(['type' => false,'message' => 'Password not match.']);
    } else {
        if(check_bcrypt($post_1,$data_user['password']) == true) {
            if($call->query("UPDATE users SET password = '".bcrypt($post_2)."' WHERE username = '$sess_username'") == true) {
                $call->query("INSERT INTO logs VALUES (null,'$sess_username','logout','Thank you and see you soon.','success','$client_ip','$client_iploc','$date $time')");
                $call->query("DELETE FROM users_cookie WHERE cookie = '".$_COOKIE['token']."'");
                setcookie('ssid', '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
                setcookie('token', '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
                unset($_SESSION['user']);
                ShennXit(['type' => true,'message' => 'Password changed successfully, please log in again.'],base_url('auth/login'));
            } else {
                ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
            }
        } else {
            ShennXit(['type' => false,'message' => 'Invalid Old Password.']);
        }
    }
} if(isset($_POST['changepin'])) {
    $post_1 = filter($_POST['oldpin']);
    $post_2 = filter($_POST['pin']);
    $post_3 = filter($_POST['conpin']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!is_numeric($post_2) || !is_numeric($post_2)) {
        ShennXit(['type' => false,'message' => 'The PIN must be a number!']);
    } else if(strlen($post_2) <> 6 || strlen($post_2) <> 6) {
        ShennXit(['type' => false,'message' => 'The PIN must contain 6 digits.']);
    } else if($post_2 <> $post_3) {
        ShennXit(['type' => false,'message' => 'PIN not match.']);
    } else {
        if(check_bcrypt($post_1,$data_user['password']) == true) {
            if($call->query("UPDATE users SET secure = '".bcrypt($post_2)."' WHERE username = '$sess_username'") == true) {
                ShennXit(['type' => true,'message' => 'PIN changed successfully.']);
            } else {
                ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
            }
        } else {
            ShennXit(['type' => false,'message' => 'Invalid Password.']);
        }
    }
} if(isset($_POST['exchange'])) {
    $post_1 = filter($_POST['amount']);
    $post_2 = filter($_POST['password']);

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!is_numeric($post_1)) {
        ShennXit(['type' => false,'message' => 'The Amount must be a number!']);
    } else if($post_1 < 20000) {
        ShennXit(['type' => false,'message' => 'Minimum exchange of points is 20,000.']);
    } else if($data_user['point'] < $post_1) {
        ShennXit(['type' => false,'message' => 'Your points are not enough to make an exchange of '.currency($post_1)]);
    } else {
        if(check_bcrypt($post_2,$data_user['password']) == true) {
            if($call->query("UPDATE users SET balance = balance+$post_1 WHERE username = '$sess_username'") == true) {
                $call->query("UPDATE users SET point = point-$post_1 WHERE username = '$sess_username'");
                $call->query("INSERT INTO mutation VALUES (null,'$sess_username','+','$post_1','".currency($post_1)." Points Redemption','$date $time')");
                ShennXit(['type' => true,'message' => 'Points were successfully exchanged.']);
            } else {
                ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
            }
        } else {
            ShennXit(['type' => false,'message' => 'Invalid Password.']);
        }
    }
} if(isset($_POST['changeapi'])) {
    $post_1 = filter($_POST['ipstat']);
    $post_2 = filter($_POST['apistatus']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($post_2,['development','production'])) {
        ShennXit(['type' => false,'message' => 'Status not match.']);
    } else {
        if($call->query("UPDATE users_api SET whitelist = '$post_1', status = '$post_2' WHERE user = '$sess_username'") == true) {
            ShennXit(['type' => true,'message' => 'API Updated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['rebuildapi_uid'])) {
    $post_uid = random(8);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else {
        if($call->query("UPDATE users_api SET uid = '$post_uid' WHERE user = '$sess_username'") == true) {
            ShennXit(['type' => true,'message' => 'User ID Updated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['rebuildapi_key'])) {
    $post_ukey = random(64);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if($call->query("SELECT ukey FROM users_api WHERE ukey = '$post_ukey'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'Clashing System, please try again.']);
    } else {
        if($call->query("UPDATE users_api SET ukey = '$post_ukey' WHERE user = '$sess_username'") == true) {
            ShennXit(['type' => true,'message' => 'API Key Updated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}