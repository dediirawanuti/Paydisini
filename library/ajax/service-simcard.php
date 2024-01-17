<?php
require '../../connect.php';
require _DIR_('library/session/session');

function err($x) {
    return '<div class="col-12"><div class="alert alert-danger bg-danger text-white border-0" role="alert">'.$x.'</div></div>';
}

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit(json_encode(['service' => err('No direct script access allowed!'),'class' => '']));
    if(!isset($_POST['phone'])) exit(json_encode(['service' => err('No direct script access allowed!'),'class' => '']));
    if(!isset($_POST['type']) || !in_array($_POST['type'],['pulsa-reguler','pulsa-transfer','paket-internet','paket-telepon'])) exit(json_encode(['service' => err('No direct script access allowed!'),'class' => '']));
    if(empty($_POST['phone'])) exit(json_encode(['service' => err('Enter your mobile number.'),'class' => '']));
    
    $post_type = $_POST['type'];
    $post_phone = filter_phone('0',$_POST['phone']);
    $brand = strtr(strtoupper($SimCard->operator($post_phone)),[
        'THREE' => 'TRI',
        'SMARTFREN' => 'SMART'
    ]);
    $brand = ($brand == 'BY.U' && !in_array($post_type,['pulsa-reguler'])) ? 'TELKOMSEL' : $brand;
    $class = strtr($brand,[
        'TELKOMSEL' => 'sc-telkomsel',
        'BY.U' => 'sc-byu',
        'INDOSAT' => 'sc-indosat',
        'XL' => 'sc-axiata',
        'AXIS' => 'sc-axis',
        'SMART' => 'sc-smartfren',
        'TRI' => 'sc-three'
    ]);
    
    if(strtolower($brand) != 'unknown') {
        $search = $call->query("SELECT * FROM srv_ppob WHERE brand = '$brand' AND type = '$post_type' AND status = 'available' ORDER BY price ASC");
        if($search->num_rows == 0) {
            exit(json_encode(['service' => err('Service not found.'),'class' => $class]));
        } else {
            $out_srv = '';
            while($row = $search->fetch_assoc()) {
                $onclick = "prepaid('".base_url("confirm-prepaid/{$row['code']}/")."')";
                $priceny = (in_array($data_user['level'],['Premium','Admin'])) ? $row['price'] + $row['premium'] : $row['price'] + $row['basic'];
                $out_srv .= '<div class="col-md-4" onclick="'.$onclick.'"><label class="custom control-label"><input type="radio" name="shennboku" class="card-input-element d-no'.
                            'ne" value="shennboku"><div class="card card-body"><div style="font-size:0.8rem;display:inline;height:auto !important;">'.$row['name'].''.
                            '</div><span style="font-size:0.8rem;">Rp '.currency($priceny).',-</span></div></label></div>';
            }
        }
        print json_encode(['service' => $out_srv,'class' => $class]);
    } else {
        exit(json_encode(['service' => err('SIM Card not detected.'),'class' => '']));
    }
} else {
	exit(json_encode(['service' => err('No direct script access allowed!'),'class' => '']));
}