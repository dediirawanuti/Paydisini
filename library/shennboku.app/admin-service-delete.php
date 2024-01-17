<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['serviceg_delete'])) {
    $web_token = base64_decode($_POST['web_token']);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT id FROM srv_game WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Service not found.']);
    } else {
        if($call->query("DELETE FROM srv_game WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => 'Service deleted successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['servicep_delete'])) {
    $web_token = base64_decode($_POST['web_token']);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT id FROM srv_ppob WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Service not found.']);
    } else {
        if($call->query("DELETE FROM srv_ppob WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => 'Service deleted successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['services_delete'])) {
    $web_token = base64_decode($_POST['web_token']);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT id FROM srv_socmed WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Service not found.']);
    } else {
        if($call->query("DELETE FROM srv_socmed WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => 'Service deleted successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}