<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['save'])) {
    $post_1 = filter($_POST['hold_basic']);
    $post_2 = filter($_POST['hold_premium']);
    $post_3 = filter($_POST['hold_admin']);

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!is_numeric($post_1) || !is_numeric($post_2) || !is_numeric($post_3)) {
        ShennXit(['type' => false,'message' => 'Value must be numeric.']);
    } else if($post_1 < 0 || $post_2 < 0 || $post_3 < 0) {
        ShennXit(['type' => false,'message' => 'The minimum value is 0.']);
    } else {
        if($call->query("UPDATE conf SET c1 = '$post_1', c2 = '$post_2', c3 = '$post_3' WHERE code = 'hold-balance'") == true) {
            ShennXit(['type' => true,'message' => 'Hold Balance updated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}