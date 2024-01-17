<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit('No direct script access allowed!');
    if(!isset($_POST['service'])) exit('No direct script access allowed!');
    if(empty($_POST['service'])) exit('0');
    
    $datanya = $call->query("SELECT * FROM srv_socmed WHERE id = '".filter($_POST['service'])."' AND status = 'available'")->fetch_assoc();
    if(isset($datanya['price'])) {
        $pricing = (in_array($data_user['level'],['Admin','Premium'])) ? $datanya['premium'] : $datanya['basic'];
        print (($datanya['price']+$pricing) / 1000);
    } else {
        print '0';
    }
} else {
	exit('No direct script access allowed!');
}