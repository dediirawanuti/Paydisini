<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['addnews'])) {
    $post_type = filter($_POST['addnews_type']);
    $post_content = base64_encode(str_replace(['<script','</script>'],'',$_POST['addnews_content']));
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!in_array($post_type,['news','info','update','maintenance'])) {
        ShennXit(['type' => false,'message' => 'Incompatible type.']);
    } else {
        if($call->query("INSERT INTO information VALUES (null,'$date $time','$post_type','$post_content')") == true) {
            ShennXit(['type' => true,'message' => ucfirst($post_type).' content added successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['editnews'])) {
    $web_token = base64_decode($_POST['web_token']);
    $post_type = filter($_POST['editnews_type']);
    $post_content = base64_encode(str_replace(['<script','</script>'],'',$_POST['editnews_content']));
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!in_array($post_type,['news','info','update','maintenance'])) {
        ShennXit(['type' => false,'message' => 'Incompatible type.']);
    } else if($call->query("SELECT id FROM information WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Data not found.']);
    } else {
        if($call->query("UPDATE information SET `type` = '$post_type', content = '$post_content' WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => ucfirst($post_type).' content updated successfully.'],base_url('admin/others/news/'));
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['deletenews'])) {
    $web_token = base64_decode($_POST['web_token']);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT id FROM information WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Data not found.']);
    } else {
        if($call->query("DELETE FROM information WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => 'Content deleted successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}