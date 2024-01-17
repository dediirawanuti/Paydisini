<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_GET['unlock'])) {
    $post_1 = filter(base64_decode($_GET['unlock']));

    if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT user FROM users_lock WHERE user = '$post_1'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'User is not locked.']);
    } else {
        if($call->query("DELETE FROM users_lock WHERE user = '$post_1'") == true) {
            ShennXit(['type' => true,'message' => 'User '.$post_1.' successfully unlocked.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}