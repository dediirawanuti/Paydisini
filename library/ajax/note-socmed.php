<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit('No direct script access allowed!');
    if(!isset($_POST['pid'])) exit('No direct script access allowed!');
    if(empty($_POST['pid'])) exit(json_encode([
        'msg' => [
            'price' => '0',
            'min' => '0',
            'max' => '0',
            'note' => '',
        ]
    ]));
    
    $search = $call->query("SELECT * FROM srv_socmed WHERE id = '".filter($_POST['pid'])."' AND status = 'available'");
	if($search->num_rows == 1):
        $row = $search->fetch_assoc();
        $pricing = (in_array($data_user['level'],['Admin','Premium'])) ? $row['premium'] : $row['basic'];
        print json_encode([
            'msg' => [
                'price' => currency($row['price']+$pricing),
                'min' => currency($row['min']),
                'max' => currency($row['max']),
                'note' => nl2br($row['note']),
            ]
        ]);
    else:
        print json_encode([
            'msg' => [
                'price' => '0',
                'min' => '0',
                'max' => '0',
                'note' => '',
            ]
        ]);
    endif;
} else {
	exit('No direct script access allowed!');
}