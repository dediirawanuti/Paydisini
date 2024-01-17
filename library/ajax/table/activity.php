<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2','error'])) exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($ctype == '1') {
        $table = 'logs';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date','dt' => 'date'],
            ['db' => 'loc','dt' => 'loc'],
            ['db' => 'id','dt' => 0, 'formatter' => function($i,$a) {
                $date = format_date('id',substr($a['date'],0,10));
                $time = substr(substr($a['date'],-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
            ['db' => 'ip','dt' => 1, 'formatter' => function($i,$a) {
                return $i.'<br>('.$a['loc'].')';
            }],
            ['db' => 'text',  'dt' => 2, 'formatter' => function($i) { return nl2br($i); }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "user = '$sess_username'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2' && $data_user['level'] == 'Admin') {
        $table = 'logs';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date','dt' => 'date'],
            ['db' => 'loc','dt' => 'loc'],
            ['db' => 'id','dt' => 0, 'formatter' => function($i,$a) {
                $date = format_date('id',substr($a['date'],0,10));
                $time = substr(substr($a['date'],-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
            ['db' => 'user','dt' => 1],
            ['db' => 'ip','dt' => 2, 'formatter' => function($i,$a) {
                return $i.'<br>('.$a['loc'].')';
            }],
            ['db' => 'text',  'dt' => 3, 'formatter' => function($i) { return nl2br($i); }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "user != 'system'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == 'error' && $data_user['level'] == 'Admin') {
        $table = 'logs';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date','dt' => 'date'],
            ['db' => 'id','dt' => 0, 'formatter' => function($i,$a) {
                $date = format_date('id',substr($a['date'],0,10));
                $time = substr(substr($a['date'],-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
            ['db' => 'text',  'dt' => 1, 'formatter' => function($i) { return nl2br($i); }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "user = 'system' AND type = 'system'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else {
        exit("No direct script access allowed!");
    }
} else {
    exit("No direct script access allowed!");
}