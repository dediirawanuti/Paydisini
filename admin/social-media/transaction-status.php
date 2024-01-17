<?php
require '../../connect.php';
require _DIR_('library/session/session');

$did = isset($_POST['id']) ? filter($_POST['id']) : '';
$dst = isset($_POST['data']) ? filter(base64_decode($_POST['data'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit('No direct script access allowed!');
    if($data_user['level'] <> 'Admin') exit('No direct script access allowed!');
    if(!$did) exit('No direct script access allowed!');
    if(!in_array($dst,['error','partial','waiting','processing','success'])) exit('No direct script access allowed!');
    $search = $call->query("SELECT * FROM trx_socmed WHERE wid = '".filter($_POST['id'])."'");
    if($search->num_rows == 0) exit(sessResult(false,'Transaction not found.'));
    $data = $search->fetch_assoc();
    
    if(in_array($data['status'],['error','partial'])) {
        print sessResult(false,ucfirst($data['status']).' status cannot be changed.');
    } else {
        if($call->query("UPDATE trx_socmed SET status = '$dst', date_up = '$date $time' WHERE wid = '$did'") == true) {
            print sessResult(true,'Transaction status successfully changed to '.ucfirst($dst).'.');
        } else {
            print sessResult(false,'The system is in trouble, please try again later.');
        }
    }
} else {
	exit('No direct script access allowed!');
}