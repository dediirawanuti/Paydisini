<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['service_clear'])) {
    $deleted = false;
    $web_token = base64_decode($_POST['web_token']);
    $clear_opt = filter($_POST['clear_option']);
    $clear_type = isset($_POST['clear_type']) ? filter($_POST['clear_type']) : '';
    $clear_catg = isset($_POST['clear_category']) ? filter($_POST['clear_category']) : '';
    $clear_prov = isset($_POST['clear_provider']) ? filter($_POST['clear_provider']) : '';

    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($web_token == 'ppob') {
        if(in_array($clear_opt, ['type','type-provider']) && in_array($clear_type, ['pulsa-reguler','pulsa-internasional','paket-internet','paket-telepon','token-pln','saldo-emoney','voucher-game','streaming-tv','paket-lainnya','pascabayar'])) {
            if($clear_opt == 'type-provider' && $call->query("SELECT code FROM provider WHERE code = '$clear_prov'")->num_rows == 0) ShennXit(['type' => false,'message' => 'Invalid Option or Provider not valid.']);
            if($clear_opt == 'type') $deleted = ($call->query("DELETE FROM srv_ppob WHERE type = '$clear_type'") == true) ? true : false;
            if($clear_opt == 'type-provider') $deleted = ($call->query("DELETE FROM srv_ppob WHERE type = '$clear_type' AND provider = '$clear_prov'") == true) ? true : false;
        } else if(in_array($clear_opt,['category','category-provider']) && $call->query("SELECT code FROM category WHERE code = '$clear_catg'")->num_rows == 1) {
            if($clear_opt == 'category-provider' && $call->query("SELECT code FROM provider WHERE code = '$clear_prov'")->num_rows == 0) ShennXit(['type' => false,'message' => 'Invalid Option or Provider not valid.']);
            if($clear_opt == 'category') $deleted = ($call->query("DELETE FROM srv_ppob WHERE brand = '$clear_catg'") == true) ? true : false;
            if($clear_opt == 'category-provider') $deleted = ($call->query("DELETE FROM srv_ppob WHERE brand = '$clear_catg' AND provider = '$clear_prov'") == true) ? true : false;
        } else if($clear_opt == 'provider' && $call->query("SELECT code FROM provider WHERE code = '$clear_prov'")->num_rows == 1) {
            $deleted = ($call->query("DELETE FROM srv_ppob WHERE provider = '$clear_prov'") == true) ? true : false;
        } else {
            ShennXit(['type' => false,'message' => 'Invalid Option.']);
        }
    } else if($web_token == 'socmed') {
        if(in_array($clear_opt,['category','category-provider']) && $call->query("SELECT code FROM category WHERE code = '$clear_catg'")->num_rows == 1) {
            if($clear_opt == 'category-provider' && $call->query("SELECT code FROM provider WHERE code = '$clear_prov'")->num_rows == 0) ShennXit(['type' => false,'message' => 'Invalid Option or Provider not valid.']);
            if($clear_opt == 'category') $deleted = ($call->query("DELETE FROM srv_socmed WHERE cid = '$clear_catg'") == true) ? true : false;
            if($clear_opt == 'category-provider') $deleted = ($call->query("DELETE FROM srv_socmed WHERE cid = '$clear_catg' AND provider = '$clear_prov'") == true) ? true : false;
        } else if($clear_opt == 'provider' && $call->query("SELECT code FROM provider WHERE code = '$clear_prov'")->num_rows == 1) {
            $deleted = ($call->query("DELETE FROM srv_socmed WHERE provider = '$clear_prov'") == true) ? true : false;
        } else {
            ShennXit(['type' => false,'message' => 'Invalid Option.']);
        }
    } else if($web_token == 'game') {
        if(in_array($clear_opt,['category','category-provider']) && $call->query("SELECT code FROM category WHERE code = '$clear_catg'")->num_rows == 1) {
            if($clear_opt == 'category-provider' && $call->query("SELECT code FROM provider WHERE code = '$clear_prov'")->num_rows == 0) ShennXit(['type' => false,'message' => 'Invalid Option or Provider not valid.']);
            if($clear_opt == 'category') $deleted = ($call->query("DELETE FROM srv_game WHERE game = '$clear_catg'") == true) ? true : false;
            if($clear_opt == 'category-provider') $deleted = ($call->query("DELETE FROM srv_game WHERE game = '$clear_catg' AND provider = '$clear_prov'") == true) ? true : false;
        } else if($clear_opt == 'provider' && $call->query("SELECT code FROM provider WHERE code = '$clear_prov'")->num_rows == 1) {
            $deleted = ($call->query("DELETE FROM srv_game WHERE provider = '$clear_prov'") == true) ? true : false;
        } else {
            ShennXit(['type' => false,'message' => 'Invalid Option.']);
        }
    } else {
        ShennXit(['type' => false,'message' => 'Invalid Order.']);
    }
    
    if($deleted == true) {
        ShennXit(['type' => true,'message' => 'Service cleared successfully.']);
    } else {
        ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
    }
}