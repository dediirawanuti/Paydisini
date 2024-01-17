<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['users_edit1'])) {
    $post_d = filter(base64_decode($_POST['data_token']));
    $post_name = filter($_POST['u_name']);
    $post_email = filter($_POST['u_mail']);
    $post_phone = filter_phone('62',$_POST['u_phone']);
    $post_balance = filter($_POST['u_balance']);
    $post_level = filter($_POST['u_level']);
    $post_status = filter($_POST['u_status']);
    
    $user_search = $call->query("SELECT * FROM users WHERE id = '$post_d'");
    if($user_search->num_rows == 1) {
        $user_data = $user_search->fetch_assoc();
        $user_json = json_decode($user_data['info'], true);
    }
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if($user_search->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'User not found.']);
    } else if($call->query("SELECT phone FROM users WHERE phone = '$post_phone' AND id != '$post_d'")->num_rows == 1) {
        ShennXit(['type' => false,'message' => 'Phone number has been registered.']);
    } else if($call->query("SELECT phone FROM users WHERE info LIKE '%\"new_phone\": \"$post_phone\"%' AND id != '$post_d'")->num_rows == 1) {
        ShennXit(['type' => false,'message' => 'Phone number has been registered on change.']);
    } else if($call->query("SELECT email FROM users WHERE email = '$post_email' AND id != '$post_d'")->num_rows == 1) {
        ShennXit(['type' => false,'message' => 'Email address has been registered.']);
    } else if($call->query("SELECT email FROM users WHERE info LIKE '%\"new_email\": \"$post_email\"%' AND id != '$post_d'")->num_rows == 1) {
        ShennXit(['type' => false,'message' => 'Email address has been registered on change.']);
    } else if(!in_array($post_level,['Basic','Premium','Admin']) || !in_array($post_status,['active','suspend'])) {
        ShennXit(['type' => false,'message' => 'Invalid input.']);
    } else {
        if($user_data['email'] <> $post_email) {
            $user_json['new_email'] = $post_email;
            $user_json['otp_email']['date_create'] = date('Y-m-d H:i:s');
        } if($user_data['phone'] <> $post_phone) {
            $user_json['new_phone'] = $post_phone;
            $user_json['otp_phone']['date_create'] = date('Y-m-d H:i:s');
        }
        $user_env = json_encode($user_json, JSON_PRETTY_PRINT);
        
        if($call->query("UPDATE users SET name = '$post_name', balance = '$post_balance', level = '$post_level', status = '$post_status', info = '$user_env' WHERE id = '$post_d'") == true) {
            ShennXit(['type' => true,'message' => 'Successfully made changes to '.$user_data['name'].' account.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['users_edit2'])) {
    $post_d = filter(base64_decode($_POST['data_token']));
    $post_1 = filter($_POST['up_new']);
    $post_2 = filter($_POST['up_confirm']);

    $user_search = $call->query("SELECT * FROM users WHERE id = '$post_d'");
    if($user_search->num_rows == 1) $user_data = $user_search->fetch_assoc();
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if($user_search->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'User not found.']);
    } else if(strlen($post_1) < 6 || strlen($post_1) < 6) {
        ShennXit(['type' => false,'message' => 'Password at least 6 letters or numbers.']);
    } else if($post_1 <> $post_2) {
        ShennXit(['type' => false,'message' => 'Password not match.']);
    } else if(check_bcrypt($post_1,$user_data['password']) == true) {
        ShennXit(['type' => false,'message' => 'The new password is still the same as the old password.']);
    } else {
        if($call->query("UPDATE users SET password = '".bcrypt($post_2)."' WHERE id = '$post_d'") == true) {
            ShennXit(['type' => true,'message' => 'Password has been changed successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['users_edit3'])) {
    $post_d = filter(base64_decode($_POST['data_token']));
    $post_1 = filter($_POST['ul_status']);
    $post_2 = filter($_POST['ul_reason']);

    $user_search = $call->query("SELECT * FROM users WHERE id = '$post_d'");
    if($user_search->num_rows == 1) {
        $user_data = $user_search->fetch_assoc();
        $user_lock = $call->query("SELECT user FROM users_lock WHERE user = '".$user_data['username']."'");
    }
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if($user_search->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'User not found.']);
    } else if(!in_array($post_1,['false','true'])) {
        ShennXit(['type' => false,'message' => 'Invalid input.']);
    } else if($post_1 == 'true' && !$post_2) {
        ShennXit(['type' => false,'message' => 'Please fill the reason.']);
    } else if($post_1 == 'false' && $user_lock->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'User is not locked.']);
    } else {
        if($post_1 == 'false' && $call->query("DELETE FROM users_lock WHERE user = '".$user_data['username']."'")) {
            ShennXit(['type' => true,'message' => 'User has been unlocked.']);
        } else if($user_lock->num_rows == 0 && $call->query("INSERT INTO users_lock VALUES ('".$user_data['username']."', '$post_2', '$date $time')") == true) {
            ShennXit(['type' => true,'message' => 'User has been locked.']);
        } else if($user_lock->num_rows == 1 && $call->query("UPDATE users_lock SET reason = '$post_2', date = '$date $time' WHERE user = '".$user_data['username']."'") == true) {
            ShennXit(['type' => true,'message' => 'Locked User has been updated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['users_edit4'])) {
    $post_d = filter(base64_decode($_POST['data_token']));
    $post_1 = filter($_POST['ub_cut']);
    $post_2 = filter($_POST['ub_reason']);

    $user_search = $call->query("SELECT * FROM users WHERE id = '$post_d'");
    if($user_search->num_rows == 1) $user_data = $user_search->fetch_assoc();
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if($user_search->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'User not found.']);
    } else if(!is_numeric($post_1)) {
        ShennXit(['type' => false,'message' => 'The Amount must be a number!']);
    } else if($post_1 <= 100) {
        ShennXit(['type' => false,'message' => 'The number must be more than 100!']);
    } else if(!$post_2) {
        ShennXit(['type' => false,'message' => 'Please fill the reason.']);
    } else {
        if($call->query("UPDATE users SET balance = balance-$post_1 WHERE id = '$post_d'") == true) {
            $call->query("INSERT INTO mutation VALUES (null,'".$user_data['username']."','-','$post_1','$post_2','$date $time')");
            ShennXit(['type' => true,'message' => 'Balance has been deducted successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}