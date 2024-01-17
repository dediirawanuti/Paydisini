<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['serviceg_add'])) {
    $pst1 = filter($_POST['provider_name']);
    $pst2 = filter($_POST['provider_id']);
    $pst3 = filter($_POST['category']);
    $pst4 = filter($_POST['service']);
    $pst5 = filter($_POST['server']);
    $pst6 = filter($_POST['price']);
    $pst7 = filter($_POST['pbasic']);
    $pst8 = filter($_POST['ppremi']);
    $pst9 = filter($_POST['status']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$pst1 || !$pst2 || !$pst3 || !$pst4 || !$pst5 || !is_numeric($pst6) || !is_numeric($pst7) || !is_numeric($pst8) || !$pst9) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if($call->query("SELECT code FROM provider WHERE code = '$pst1'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Provider not found.']);
    } else if($call->query("SELECT id FROM srv_game WHERE code = '$pst2'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'The service is available or already registered.']);
    } else if($call->query("SELECT id FROM category WHERE code = '$pst3' AND `order` = 'game'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Game not found.']);
    } else if(!in_array($pst9, ['empty', 'available'])) {
        ShennXit(['type' => false,'message' => 'Status does not match.']);
    } else {
        if($call->query("INSERT INTO srv_game VALUES (null, '$pst2', '$pst3', '$pst4', '$pst5', '$pst6', '$pst7', '$pst8', '$pst9', '$pst1', '$dtme')") == true) {
            ShennXit(['type' => true,'message' => 'Service added successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['servicep_add'])) {
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
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$pst1 || !$pst2 || !$pst3 || !$pst4 || !$pst5 || !is_numeric($pst7) || !is_numeric($pst8) || !is_numeric($pst9) || !$pst10) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if($call->query("SELECT code FROM provider WHERE code = '$pst1'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Provider not found.']);
    } else if($call->query("SELECT id FROM srv_ppob WHERE code = '$pst2'")->num_rows > 0) {
        ShennXit(['type' => false,'message' => 'The service is available or already registered.']);
    } else if($call->query("SELECT id FROM category WHERE code = '$pst4' AND type = '$pst3' AND `order` IN ('prepaid', 'postpaid')")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Brand not found.']);
    } else if(!in_array($pst3, ['pascabayar','pulsa-reguler','pulsa-transfer','pulsa-internasional','paket-internet','paket-telepon','token-pln','saldo-emoney','voucher-game','streaming-tv','paket-lainnya'])) {
        ShennXit(['type' => false,'message' => 'Type does not match.']);
    } else if(!in_array($pst10, ['empty', 'available'])) {
        ShennXit(['type' => false,'message' => 'Status does not match.']);
    } else {
        if($call->query("INSERT INTO srv_ppob VALUES (null, '$pst3', '$pst2', '$pst5', '$pst6', '$pst7', '$pst8', '$pst9', '$pst10', '$pst4', '$pst1', '$dtme')") == true) {
            ShennXit(['type' => true,'message' => 'Service added successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['services_add'])) {
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
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$pst1 || !$pst2 || !$pst3 || !$pst4 || !is_numeric($pst6) || !is_numeric($pst7) || !is_numeric($pst8) || !is_numeric($pst9) || !is_numeric($pst10) || !$pst11) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if($call->query("SELECT code FROM provider WHERE code = '$pst1'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Provider not found.']);
    } else if($call->query("SELECT id FROM srv_socmed WHERE pid = '$pst2'")->num_rows > 0) {
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
        if($call->query("INSERT INTO srv_socmed VALUES (null, '$pst2', '$pst3', '$pst4', '$pst5', '$pst6', '$pst7', '$pst8', '$pst9', '$pst10', '$pst11', '$pst1', '$dtme')") == true) {
            ShennXit(['type' => true,'message' => 'Service added successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}