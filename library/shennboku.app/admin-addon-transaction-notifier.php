<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['save'])) {
    $post_1 = filter($_POST['number']);
    $post_2 = $_POST['message'];
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else {
        $send = $WATL->sendMessage($post_1, $post_2);
        if($send['result'] == true) $call->query("UPDATE conf SET c1 = '$post_1', c2 = '".base64_encode($post_2)."' WHERE code = 'addon1'");
        ShennXit(['type' => $send['result'],'message' => $send['message']]);
    }
}