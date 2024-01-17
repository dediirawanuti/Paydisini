<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['serviceg_edit'])) {
    $pstt = filter(base64_decode($_POST['web_token']));
    $pst1 = filter($_POST['provider_name']);
    $pst2 = filter($_POST['provider_id']);
    $pst3 = filter($_POST['category']);
    $pst4 = filter($_POST['service']);
    $pst5 = filter($_POST['server']);
    $pst6 = filter($_POST['price']);
    $pst7 = filter($_POST['pbasic']);
    $pst8 = filter($_POST['ppremi']);
    $pst9 = filter($_POST['status']);
    
    $s = $call->query("SELECT * FROM srv_game WHERE id = '$pstt'");
    if($s->num_rows > 0) $r = $s->fetch_assoc();
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$pst1 || !$pst2 || !$pst3 || !$pst4 || !$pst5 || !is_numeric($pst6) || !is_numeric($pst7) || !is_numeric($pst8) || !$pst9) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if($s->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Service not found.']);
    } else if($call->query("SELECT code FROM provider WHERE code = '$pst1'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Provider not found.']);
    } else if($r['code'] <> $pst2 && $call->query("SELECT id FROM srv_game WHERE code = '$pst2'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'The service is available or already registered.']);
    } else if($call->query("SELECT id FROM category WHERE code = '$pst3' AND `order` = 'game'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Game not found.']);
    } else if(!in_array($pst9, ['empty', 'available'])) {
        ShennXit(['type' => false,'message' => 'Status does not match.']);
    } else {
        if($call->query("UPDATE srv_game SET code = '$pst2', game = '$pst3', name = '$pst4', server = '$pst5', price = '$pst6', basic = '$pst7', premium = '$pst8', status = '$pst9', provider = '$pst1', date_up = '$dtme' WHERE id = '$pstt'") == true) {
            ShennXit(['type' => true,'message' => 'Service updated successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['servicep_edit'])) {
    $pstt = filter(base64_decode($_POST['web_token']));
    $pst1  = filter($_POST['provider_name']);
    $pst2  = filter($_POST['provider_id']);
    $pst3  = filter($_POST['type']);
    $pst4  = filter($_POST['category']);
    $pst5  = filter($_POST['service']);
    $pst6  = filter($_POST['description']);
    $pst7  = filter($_POST['price']);
    $pst8  = filter($_POST['pbasic']);
    $pst9  = filter($_POST['ppremi']);
    $pst10 = filter($_POST['status']);
    
    $s = $call->query("SELECT * FROM srv_ppob WHERE id = '$pstt'");
    if($s->num_rows > 0) $r = $s->fetch_assoc();
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$pst1 || !$pst2 || !$pst3 || !$pst4 || !$pst5 || !is_numeric($pst7) || !is_numeric($pst8) || !is_numeric($pst9) || !$pst10) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if($s->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Service not found.']);
    } else if($call->query("SELECT code FROM provider WHERE code = '$pst1'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Provider not found.']);
    } else if($r['code'] <> $pst2 && $call->query("SELECT id FROM srv_ppob WHERE code = '$pst2'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'The service is available or already registered.']);
    } else if($call->query("SELECT id FROM category WHERE code = '$pst4' AND type = '$pst3' AND `order` IN ('prepaid', 'postpaid')")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Brand not found.']);
    } else if(!in_array($pst3, ['pascabayar','pulsa-reguler','pulsa-transfer','pulsa-internasional','paket-internet','paket-telepon','token-pln','saldo-emoney','voucher-game','streaming-tv','paket-lainnya'])) {
        ShennXit(['type' => false,'message' => 'Type does not match.']);
    } else if(!in_array($pst10, ['empty', 'available'])) {
        ShennXit(['type' => false,'message' => 'Status does not match.']);
    } else {
        if($call->query("UPDATE srv_ppob SET type = '$pst3', code = '$pst2', name = '$pst5', note = '$pst6', price = '$pst7', basic = '$pst8', premium = '$pst9', status = '$pst10', brand = '$pst4', provider = '$pst1', date_up = '$dtme' WHERE id = '$pstt'") == true) {
            ShennXit(['type' => true,'message' => 'Service updated successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['services_edit'])) {
    $pstt = filter(base64_decode($_POST['web_token']));
    $pst1  = filter($_POST['provider_name']);
    $pst2  = filter($_POST['provider_id']);
    $pst3  = filter($_POST['category']);
    $pst4  = filter($_POST['service']);
    $pst5  = filter($_POST['description']);
    $pst6  = filter($_POST['price']);
    $pst7  = filter($_POST['pbasic']);
    $pst8  = filter($_POST['ppremi']);
    $pst9  = filter($_POST['ordmin']);
    $pst10 = filter($_POST['ordmax']);
    $pst11 = filter($_POST['status']);
    
    $s = $call->query("SELECT * FROM srv_socmed WHERE id = '$pstt'");
    if($s->num_rows > 0) $r = $s->fetch_assoc();
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$pst1 || !$pst2 || !$pst3 || !$pst4 || !is_numeric($pst6) || !is_numeric($pst7) || !is_numeric($pst8) || !is_numeric($pst9) || !is_numeric($pst10) || !$pst11) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if($s->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Service not found.']);
    } else if($call->query("SELECT code FROM provider WHERE code = '$pst1'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Provider not found.']);
    } else if($r['pid'] <> $pst2 && $call->query("SELECT id FROM srv_socmed WHERE pid = '$pst2'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'The service is available or already registered.']);
    } else if($call->query("SELECT id FROM category WHERE code = '$pst3' AND `order` = 'social'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Category not found.']);
    } else if(!in_array($pst11, ['empty', 'available'])) {
        ShennXit(['type' => false,'message' => 'Status does not match.']);
    } else if($pst9 > $pst10) {
        ShennXit(['type' => false,'message' => 'The minimum number of orders exceeds the maximum.']);
    } else if($pst9 < 0 || $pst10 < 0) {
        ShennXit(['type' => false,'message' => 'The minimum or maximum number of orders cannot be less than 0.']);
    } else {
        if($call->query("UPDATE srv_socmed SET pid = '$pst2', cid = '$pst3', name = '$pst4', note = '$pst5', price = '$pst6', basic = '$pst7', premium = '$pst8', min = '$pst9', max = '$pst10', status = '$pst11', provider = '$pst1', date_up = '$dtme' WHERE id = '$pstt'") == true) {
            ShennXit(['type' => true,'message' => 'Service updated successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}