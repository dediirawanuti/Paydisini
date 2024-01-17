<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['method_add'])) {
    $post_1 = filter($_POST['method_payment']);
    $post_2 = filter($_POST['method_name']);
    $post_3 = ucwords(strtolower(filter($_POST['method_accna'])));
    $post_4 = (is_numeric($_POST['method_accno'])) ? filter($_POST['method_accno']) : 'xxx';
    $post_5 = (in_array($_POST['method_xfee'],['-','%'])) ? $_POST['method_xfee'] : '-';
    $post_6 = (is_numeric($_POST['method_fee'])) ? $_POST['method_fee'] : '0';
    $post_7 = (is_numeric($_POST['method_rate'])) ? $_POST['method_rate'] : '0';
    $post_8 = (is_numeric($_POST['method_min'])) ? $_POST['method_min'] : '0';
    $post_9 = (in_array($_POST['method_auto'],['0','1'])) ? $_POST['method_auto'] : '0';
    $post_10 = filter($_POST['paymentgateway']);
    $post_11 = filter($_POST['kodepayment']);
    
    $search = $call->query("SELECT * FROM deposit_payment WHERE code = '$post_1'");
    if($search->num_rows == 1) { $data = $search->fetch_assoc(); $post_type = $data['type']; }
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($search->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Payment Method not found.']);
    } else if(!$post_2 || !$post_3 || !is_numeric($post_4) || !in_array($post_type,['bank','emoney','pulsa', 'gerai-ritel','va','qris'])) {
        ShennXit(['type' => false,'message' => 'Input Data not detected.']);
    } else {
        if($post_type == 'pulsa') $post_3 = '-';
        if($post_type == 'pulsa') $post_4 = filter_phone('0',$post_4);
        $post_6 = ($post_5 == '-') ? $post_6 : ($post_6/100);
        $post_7 = $post_7/100;
        $post_data = "$post_4 A/n $post_3";
        
        if($call->query("INSERT INTO deposit_method VALUES (null,'$post_1','$post_2','$post_data','$post_7','$post_6','$post_5','$post_8','$post_type','$post_9','$post_10','$post_11')") == true) {
            ShennXit(['type' => true,'message' => 'Deposit Method added successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['method_edit'])) {
    $web_token = base64_decode($_POST['web_token']);
    $post_1 = filter($_POST['method_payment']);
    $post_2 = filter($_POST['method_name']);
    $post_3 = ucwords(strtolower(filter($_POST['method_accna'])));
    $post_4 = (is_numeric($_POST['method_accno'])) ? filter($_POST['method_accno']) : 'xxx';
    $post_5 = (in_array($_POST['method_xfee'],['-','%'])) ? $_POST['method_xfee'] : '-';
    $post_6 = (is_numeric($_POST['method_fee'])) ? $_POST['method_fee'] : '0';
    $post_7 = (is_numeric($_POST['method_rate'])) ? $_POST['method_rate'] : '0';
    $post_8 = (is_numeric($_POST['method_min'])) ? $_POST['method_min'] : '0';
    $post_9 = (in_array($_POST['method_auto'],['0','1'])) ? $_POST['method_auto'] : '0';
    $post_10 = filter($_POST['paymentgateway']);
    $post_11 = filter($_POST['kodepayment']);
    
    $search = $call->query("SELECT * FROM deposit_payment WHERE code = '$post_1'");
    if($search->num_rows == 1) { $data = $search->fetch_assoc(); $post_type = $data['type']; }

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT * FROM deposit_method WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Deposit Method not found.']);
    } else if($search->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Payment Method not found.']);
    } else if(!$post_2 || !$post_3 || !is_numeric($post_4) || !in_array($post_type,['bank','emoney','pulsa'])) {
        ShennXit(['type' => false,'message' => 'Input Data not detected.']);
    } else {
        if($post_type == 'pulsa') $post_3 = '-';
        if($post_type == 'pulsa') $post_4 = filter_phone('0',$post_4);
        $post_6 = ($post_5 == '-') ? $post_6 : ($post_6/100);
        $post_7 = $post_7/100;
        $post_data = "$post_4 A/n $post_3";
        
        if($call->query("UPDATE deposit_method SET method = '$post_1', name = '$post_2', data = '$post_data', rate = '$post_7', fee = '$post_6', xfee = '$post_5', min = '$post_8', type = '$post_type', auto = '$post_9', payment_gateway = '$post_10', kodepayment = '$post_11' WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => 'Deposit Method updated successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['method_delete'])) {
    $web_token = base64_decode($_POST['web_token']);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT id FROM deposit_method WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Deposit Method not found.']);
    } else {
        if($call->query("DELETE FROM deposit_method WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => 'Deposit Method deleted successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}