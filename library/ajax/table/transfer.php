<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2','3'])) exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($ctype == '1' && $data_user['level'] == 'Admin') {
        $table = 'deposit';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date','dt' => 'date'],
            ['db' => 'wid','dt' => 0,'formatter' => function($i) { return '#'.$i; }],
            ['db' => 'amount','dt' => 1,'formatter' => function($i) { return 'Rp '.currency($i); }],
            ['db' => 'note','dt' => 2],
            ['db' => 'id', 'dt' => 3, 'formatter' => function($i,$a) {
                $date = format_date('id',substr($a['date'],0,10));
                $time = substr(substr($a['date'],-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "payment = 'transfer'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2' && in_array($data_user['level'],['Admin','Premium'])) {
        $table = 'deposit';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date','dt' => 'date'],
            ['db' => 'wid','dt' => 0,'formatter' => function($i) { return '#'.$i; }],
            ['db' => 'amount','dt' => 1,'formatter' => function($i) { return 'Rp '.currency($i); }],
            ['db' => 'note','dt' => 2],
            ['db' => 'id', 'dt' => 3, 'formatter' => function($i,$a) {
                $date = format_date('id',substr($a['date'],0,10));
                $time = substr(substr($a['date'],-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "sender = '$sess_username' AND payment = 'transfer'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '3' && in_array($data_user['level'],['Admin','Premium'])) {
        $table = 'deposit';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date','dt' => 'date'],
            ['db' => 'wid','dt' => 0,'formatter' => function($i) { return '#'.$i; }],
            ['db' => 'amount','dt' => 1,'formatter' => function($i) { return 'Rp '.currency($i); }],
            ['db' => 'sender','dt' => 2],
            ['db' => 'id', 'dt' => 3, 'formatter' => function($i,$a) {
                $date = format_date('id',substr($a['date'],0,10));
                $time = substr(substr($a['date'],-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "user = '$sess_username' AND payment = 'transfer'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else {
        exit("No direct script access allowed!");
    }
} else {
    exit("No direct script access allowed!");
}