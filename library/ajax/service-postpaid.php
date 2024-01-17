<?php
require '../../connect.php';
require _DIR_('library/session/session');

function out($x,$y) {
    return json_encode(['n' => $x,'d' => $y]);
}

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit('No direct script access allowed!');
    if(!isset($_POST['category'])) exit('No direct script access allowed!');
    if(empty($_POST['category'])) exit(out(0,'<option value="0" disabled selected>- Select One -</option>'));
    
    $search = $call->query("SELECT * FROM srv_ppob WHERE brand = '".filter(base64_decode($_POST['category']))."' AND status = 'available' ORDER BY name ASC");
    if($search->num_rows == 0) {
        $count = 0;
        $select = '<option value="0" disabled selected>- Select One -</option>';
    } else if($search->num_rows > 1) {
        $select = '<option value="0" disabled selected>- Select One -</option>';
        $count = $search->num_rows;
        while($row = $search->fetch_assoc()) {
            $select .= '<option value="'.$row['code'].'">'.$row['name'].'</option>';
        }
    } else {
        $row = $search->fetch_assoc();
        $count = 1;
        $select = '<option value="'.$row['code'].'" selected>'.$row['name'].'</option>';
    }
    
    exit(out($count,$select));
} else {
	exit('No direct script access allowed!');
}