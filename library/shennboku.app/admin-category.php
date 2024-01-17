<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['category_add'])) {
    $web_token = base64_decode($_POST['web_token']);
    $post_code = str_replace(['&','*'],'',filter($_POST['category_code']));
    $post_name = filter($_POST['category_name']);
    $post_isty = (isset($_POST['category_type'])) ? true : false;
    $post_type = ($post_isty == true) ? filter($_POST['category_type']) : 'input';
    if($web_token == 'prepost') $web_token = ($post_type == 'pascabayar') ? 'postpaid' : 'prepaid';
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!in_array($web_token,['prepaid','postpaid','social','game'])) {
        ShennXit(['type' => false,'message' => 'Wrong Token.']);
    } else if($post_isty == true && !in_array($post_type,['pulsa-reguler','pulsa-internasional','paket-internet','paket-telepon','token-pln','saldo-emoney','voucher-game','streaming-tv','paket-lainnya','pascabayar'])) {
        ShennXit(['type' => false,'message' => 'Incompatible type.']);
    } else if($post_isty == true && $call->query("SELECT id FROM category WHERE code = '$post_code' AND `type` = '$post_type' AND `order` = '$web_token'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'Categories with these codes and types already exist.']);
    } else if($post_isty == false && $call->query("SELECT id FROM category WHERE code = '$post_code' AND `order` = '$web_token'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'The category with the code already exists.']);
    } else {
        if($call->query("INSERT INTO category VALUES (null,'$post_code','$post_name','$post_type','$post_type-manual','$web_token')") == true) {
            ShennXit(['type' => true,'message' => 'Category added successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['category_edit'])) {
    $web_token = base64_decode($_POST['web_token']);
    $post_name = filter($_POST['category_name']);

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT id FROM category WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Category not found.']);
    } else {
        if($call->query("UPDATE category SET name = '$post_name' WHERE id = '$web_token'") == true) {
            ShennXit(['type' => true,'message' => 'Category updated successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['category_delete'])) {
    $web_token = base64_decode($_POST['web_token']);
    $post_deltoo = (isset($_POST['category_delete_service'])) ? filter_entities($_POST['category_delete_service']) : 'false';

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT id FROM category WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Category not found.']);
    } else {
        $shenn_old_data = $call->query("SELECT * FROM category WHERE id = '$web_token'")->fetch_assoc();
        if(in_array($shenn_old_data['order'],['prepaid','postpaid'])) $query = "DELETE FROM srv_ppob WHERE type = '".$shenn_old_data['type']."' AND brand = '".$shenn_old_data['code']."'";
        if($shenn_old_data['order'] == 'social') $query = "DELETE FROM srv_socmed WHERE cid = '".$shenn_old_data['code']."'";
        if($shenn_old_data['order'] == 'game') $query = "DELETE FROM srv_game WHERE game = '".$shenn_old_data['code']."'";
        
        if($call->query("DELETE FROM category WHERE id = '$web_token'") == true) {
            $OpoIki = ($post_deltoo == 'true' && isset($query)) ? $call->query($query) : false;
            ShennXit([
                'type' => true,
                'message' => ($OpoIki == true) ? 'Its categories and services have been deleted successfully.' : 'Category deleted successfully.'
            ]);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['category_clear'])) {
    $web_token = base64_decode($_POST['web_token']);
    $clear_option = ($web_token == 'prepost') ? filter($_POST['clear_option']) : 'ca';
    $clear_type = isset($_POST['clear_type']) ? filter($_POST['clear_type']) : '';
    $web_tokens = "IN ('".str_replace('prepost',"prepaid', 'postpaid",$web_token)."')";
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!in_array($web_token,['prepost','social','game'])) {
        ShennXit(['type' => false,'message' => 'Invalid Order.']);
    } else if($web_token == 'prepost' && $clear_option == 'co' && !in_array($clear_type,['pulsa-reguler','pulsa-internasional','paket-internet','paket-telepon','token-pln','saldo-emoney','voucher-game','streaming-tv','paket-lainnya','pascabayar'])) {
        ShennXit(['type' => false,'message' => 'Incompatible type.']);
    } else {
        $query = ($clear_option == 'ca')
                ? "DELETE FROM category WHERE `order` $web_tokens"
                : "DELETE FROM category WHERE `type` = '$clear_type' AND `order` $web_tokens";
        if($call->query($query) == true) {
            ShennXit(['type' => true,'message' => 'Category cleared successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}