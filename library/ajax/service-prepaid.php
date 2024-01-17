<?php
require '../../connect.php';
require _DIR_('library/session/session');

function err($x) {
    return '<div class="col-12"><div class="alert alert-danger bg-danger text-white border-0" role="alert">'.$x.'</div></div>';
}

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit(err('No direct script access allowed!'));
    if(!isset($_POST['category'])) exit(err('No direct script access allowed!'));
    if(empty($_POST['category'])) exit(err('Please select a category.'));
    $post_type = filter($_POST['type']);
    $post_data = filter($_POST['shenn']);
    
    $search = $call->query("SELECT * FROM srv_ppob WHERE brand = '".filter($_POST['category'])."' AND type = '$post_type' AND status = 'available' ORDER BY price ASC");
    if($search->num_rows == 0) {
        exit(err('Service not found.'));
    } else {
        $out_srv = '';
        while($row = $search->fetch_assoc()) {
            $onclick = "prepaid('".base_url("confirm-etc/{$row['code']}/")."')";
            $priceny = (in_array($data_user['level'],['Premium','Admin'])) ? $row['price'] + $row['premium'] : $row['price'] + $row['basic'];
            $out_srv .= '<div class="col-md-6" onclick="'.$onclick.'"><label class="custom control-label"><input type="radio" name="shennboku" class="card-input-element d-no'.
                        'ne" value="shennboku"><div class="card card-body"><div style="font-size:0.8rem;display:inline;">'.$row['name'].'<span class="justify-content-end" st'.
                        'yle="float:right;font-size:0.8rem;">Rp '.currency($priceny).',-</span></div><span style="font-size:0.8rem;">'.$row['note'].'</span></div></label></div>';
        }
        exit($out_srv);
    }
} else {
	exit(err('No direct script access allowed!'));
}