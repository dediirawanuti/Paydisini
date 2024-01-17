<?php
require '../../connect.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_POST['type'])) exit("No direct script access allowed!");
    if(empty($_POST['type'])) exit("<option value='0' disabled selected>- Select One -</option>");
    $reqAdmin = isset($_POST['admin']) ? true : false;
    
    $search = $call->query("SELECT * FROM category WHERE type = '".filter($_POST['type'])."' AND `order` IN ('prepaid', 'postpaid') ORDER BY name ASC");
    print('<option value="0" disabled selected>- Select One -</option>');
    while($row = $search->fetch_assoc()) {
        if($reqAdmin == false) {
            if($call->query("SELECT * FROM srv_ppob WHERE brand = '".$row['code']."' AND type = '".filter($_POST['type'])."' AND status = 'available'")->num_rows > 0)
                print select_opt('', $row['code'], $row['name']);
        } else {
            print select_opt('', $row['code'], $row['name']);
        }
    }
} else {
	exit("No direct script access allowed!");
}