<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['save_game'])) {
    $post_type = (in_array($_POST['ptype'],['+','%'])) ? $_POST['ptype'] : '+';
    $post_amount = (is_numeric($_POST['pamnt'])) ? $_POST['pamnt'] : '0';
    $post_amount = ($post_type == '+') ? $post_amount : ($post_amount/100);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("UPDATE conf SET c1 = '$post_type', c2 = '$post_amount' WHERE code = 'trxpoint'") == true) {
        ShennXit(['type' => true,'message' => 'The referral point setting is set successfully.']);
    } else {
        ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
    }
} if(isset($_POST['save_ppob'])) {
    $post_type = (in_array($_POST['ptype'],['+','%'])) ? $_POST['ptype'] : '+';
    $post_amount = (is_numeric($_POST['pamnt'])) ? $_POST['pamnt'] : '0';
    $post_amount = ($post_type == '+') ? $post_amount : ($post_amount/100);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("UPDATE conf SET c3 = '$post_type', c4 = '$post_amount' WHERE code = 'trxpoint'") == true) {
        ShennXit(['type' => true,'message' => 'The referral point setting is set successfully.']);
    } else {
        ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
    }
} if(isset($_POST['save_socmed'])) {
    $post_type = (in_array($_POST['ptype'],['+','%'])) ? $_POST['ptype'] : '+';
    $post_amount = (is_numeric($_POST['pamnt'])) ? $_POST['pamnt'] : '0';
    $post_amount = ($post_type == '+') ? $post_amount : ($post_amount/100);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("UPDATE conf SET c5 = '$post_type', c6 = '$post_amount' WHERE code = 'trxpoint'") == true) {
        ShennXit(['type' => true,'message' => 'The referral point setting is set successfully.']);
    } else {
        ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
    }
}