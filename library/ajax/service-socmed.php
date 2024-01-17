<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit('No direct script access allowed!');
    if(!isset($_POST['category'])) exit('No direct script access allowed!');
    if(empty($_POST['category'])) exit("<option value='0' disabled selected>- Select One -</option>");
    
    $search = $call->query("SELECT * FROM srv_socmed WHERE cid = '".filter(base64_decode($_POST['category']))."' AND status = 'available' ORDER BY price ASC");
    print('<option value="0" disabled selected>- Select One -</option>');
    while($row = $search->fetch_assoc()) {
        print('<option value="'.$row['id'].'">'.$row['name'].'</option>');
    }
} else {
	exit('No direct script access allowed!');
}