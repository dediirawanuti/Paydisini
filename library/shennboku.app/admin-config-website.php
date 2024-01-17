<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['save'])) {
    $pst1 = filter($_POST['title']);
    $pst2 = filter($_POST['navbar']);
    $pst3 = filter($_POST['description']);
    $pst4 = filter($_POST['keyword']);
    $pst5 = filter($_POST['banner']);
    $pst6 = filter($_POST['icon']);
    $pst7 = filter($_POST['recsite']);
    $pst8 = filter($_POST['recsecret']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$pst1 || !$pst2) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else {
        if($call->query("UPDATE conf SET c1 = '$pst1', c2 = '$pst2', c3 = '$pst3', c4 = '$pst4', c5 = '$pst5', c6 = '$pst6', c7 = '$pst7', c8 = '$pst8' WHERE code = 'webcfg'") == true) {
            ShennXit(['type' => true,'message' => 'Website updated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}