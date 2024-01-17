<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['addfaq'])) {
    $post_quest = filter($_POST['addfaq_quest']);
    $post_answer = base64_encode(str_replace(['<script','</script>'],'',$_POST['addfaq_ans']));
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(strlen($post_quest) > 128) {
        ShennXit(['type' => false,'message' => 'The question is too long, maximum 128 characters.']);
    } else {
        if($call->query("INSERT INTO general_quest VALUES (null,'$post_quest','$post_answer')") == true) {
            ShennXit(['type' => true,'message' => 'QnA added successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['editfaq'])) {
    $web_token = base64_decode($_POST['web_token']);
    $post_quest = filter($_POST['editfaq_quest']);
    $post_answer = base64_encode(str_replace(['<script','</script>'],'',$_POST['editfaq_ans']));
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(strlen($post_quest) > 128) {
        ShennXit(['type' => false,'message' => 'The question is too long, maximum 128 characters.']);
    } else if($call->query("SELECT id FROM general_quest WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Data not found.']);
    } else {
        if($call->query("UPDATE general_quest SET quest = '$post_quest', answer = '$post_answer' WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => 'QnA updated successfully.'],base_url('admin/others/faq/'));
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['deletefaq'])) {
    $web_token = base64_decode($_POST['web_token']);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT id FROM general_quest WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Data not found.']);
    } else {
        if($call->query("DELETE FROM general_quest WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => 'QnA deleted successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}