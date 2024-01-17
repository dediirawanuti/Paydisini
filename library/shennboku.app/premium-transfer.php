<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['submit'])) {
    $post_rid = date('YmdHis').random_number(2);
    $post_user = filter($_POST['user']);
    $post_amnt = filter($_POST['amount']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Premium','Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$post_user || !$post_amnt) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if(strtolower($post_user) == strtolower($sess_username)) {
        ShennXit(['type' => false,'message' => 'You cannot transfer to yourself.']);
    } else if($call->query("SELECT * FROM users WHERE username = '$post_user'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'User not registered.']);
    } else if($post_amnt < 5000) {
        ShennXit(['type' => false,'message' => 'The minimum transfer amount is Rp '.currency(5000).'.']);
    } else if($data_user['balance'] < $post_amnt) {
        ShennXit(['type' => false,'message' => 'Your balance is not enough to send the balance.']);
    } else if($data_user['balance'] < ($post_amnt+$_CONFIG['hold'][$data_user['level']])) {
        ShennXit(['type' => false,'message' => 'Your minimum account balance is '.number_format($_CONFIG['hold'][$data_user['level']]).'.']);
    } else if($call->query("SELECT wid FROM deposit WHERE wid = '$post_rid'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'Clashing System, please try again.']);
    } else {
        $post_note = "Send IDR ".currency($post_amnt)." from $sess_username to $post_user.";
        $in = $call->query("INSERT INTO deposit VALUES (null,'$post_rid','$post_user','transfer','Transfer Saldo','$post_note','$sess_username','0','0','$post_amnt','paid','$date $time')");
        if($in == true) {
            $call->query("INSERT INTO mutation VALUES (null,'$sess_username','-','$post_amnt','Transfer to $post_user :: $post_rid','$date $time')");
            $call->query("INSERT INTO mutation VALUES (null,'$post_user','+','$post_amnt','Transfer from $sess_username :: $post_rid','$date $time')");
            $call->query("UPDATE users SET balance = balance-$post_amnt WHERE username = '$sess_username'");
            $call->query("UPDATE users SET balance = balance+$post_amnt WHERE username = '$post_user'");
            ShennXit(['type' => true,'message' => $post_note]);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}