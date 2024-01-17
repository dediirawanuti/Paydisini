<?php 
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_POST['server']) || !isset($_POST['jumlah']) || !isset($_POST['layanan']) || !isset($_POST['category'])) exit("No direct script access allowed!");
    
    $datanya = $call->query("SELECT * FROM srv_game WHERE server = '".filter($_POST['server'])."' AND code = '".filter($_POST['layanan'])."' AND game = '".filter($_POST['category'])."' AND status = 'available'")->fetch_assoc();
    $pricing = (in_array($data_user['level'],['Admin','Premium'])) ? $datanya['premium'] : $datanya['basic'];
    print 'Rp '.currency($datanya['price'] + $pricing);
} else {
	exit("No direct script access allowed!");
}