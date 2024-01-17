<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit('No direct script access allowed!');
    if(!isset($_POST['type'])) exit('No direct script access allowed!');
    if(empty($_POST['type'])) exit("<option value='0' disabled selected>- Select One -</option>");
    
    $search = $call->query("SELECT * FROM deposit_method WHERE type = '".filter($_POST['type'])."' ORDER BY name ASC");
    print('<option value="0" disabled selected>- Select One -</option>');
    while($row = $search->fetch_assoc()) { 
        $note = $row['name'].' [Min '.currency($row['min']).']';
        print '<option value="'.$row['id'].'">'.$note.'</option>';
    }
} else {
	exit('No direct script access allowed!');
}