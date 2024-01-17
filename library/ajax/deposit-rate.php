<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit('No direct script access allowed!');
    if(!isset($_POST['quantity']) || !isset($_POST['method'])) exit('No direct script access allowed!');
    if(!is_numeric($_POST['quantity']) || !is_numeric($_POST['method'])) exit('No direct script access allowed!');
    if($call->query("SELECT * FROM deposit_method WHERE id = '".filter($_POST['method'])."'")->num_rows == 0) exit('No direct script access allowed!');
    if(!$_POST['quantity'] || !$_POST['method']) exit(json_encode(['msg' => ['get' => 0,'fee' => 0,'rate' => 0,'min' => 0,'note' => '']]));
    $data_depo = $call->query("SELECT * FROM deposit_method WHERE id = '".filter($_POST['method'])."'")->fetch_assoc();
    
    $db_xsfee = ($data_depo['xfee'] == '-') ? $data_depo['fee'] : ($_POST['quantity'] * $data_depo['fee']);
    $db_xfee  = $_POST['quantity'] - $db_xsfee;
    $db_rate  = $db_xfee * $data_depo['rate'];
    $db_min   = $data_depo['min'];
    $to_qty   = $db_xfee - $db_rate;
    $note     = ($_POST['quantity'] < $db_min) ? 'Min '.currency($db_min) : '';
    
    print json_encode(['msg' => ['get' => currency($db_rate),'fee' => $db_xsfee,'rate' => $to_qty,'min' => $db_min,'note' => $note]]);
} else {
	exit('No direct script access allowed!');
}