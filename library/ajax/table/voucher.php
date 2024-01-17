<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2','3'])) exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($ctype == '1' && $data_user['level'] == 'Admin') {
        $table = 'voucher';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date_up','dt' => 'date_up'],
            ['db' => 'status','dt' => 'status'],
            
            ['db' => 'id','dt' => 0],
            ['db' => 'own','dt' => 1],
            ['db' => 'code','dt' => 2,'formatter' => function($i,$a) {
                if($a['status'] == 'available') return '<b class="text-success copy" title="Click to Copy!">'.$i.'</b>';
                else return '<b class="text-danger">'.$i.'</b>';
            }],
            ['db' => 'value','dt' => 3,'formatter' => function($i) { return 'Rp '.currency($i); }],
            ['db' => 'user','dt' => 4, 'formatter' => function($i,$a) {
                if($a['status'] == 'available') return 'Available!';
                else return "Used by $i on ".format_date('en',$a['date_up']);
            }],
            ['db' => 'date_cr', 'dt' => 5, 'formatter' => function($i) {
                $date = format_date('id',substr($i,0,10));
                $time = substr(substr($i,-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = '';
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2' && in_array($data_user['level'],['Admin','Premium'])) {
        $table = 'voucher';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date_up','dt' => 'date_up'],
            ['db' => 'status','dt' => 'status'],
            
            ['db' => 'code','dt' => 0,'formatter' => function($i,$a) {
                if($a['status'] == 'available') return '<b class="text-success copy" title="Click to Copy!">'.$i.'</b>';
                else return '<b class="text-danger">'.$i.'</b>';
            }],
            ['db' => 'value','dt' => 1,'formatter' => function($i) { return 'Rp '.currency($i); }],
            ['db' => 'user','dt' => 2, 'formatter' => function($i,$a) {
                if($a['status'] == 'available') return 'Available!';
                else return "Used by $i on ".format_date('en',$a['date_up']);
            }],
            ['db' => 'date_cr', 'dt' => 3, 'formatter' => function($i) {
                $date = format_date('id',substr($i,0,10));
                $time = substr(substr($i,-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "own = '$sess_username'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '3') {
        $table = 'deposit';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date','dt' => 'date'],
            ['db' => 'wid','dt' => 0,'formatter' => function($i) { return '#'.$i; }],
            ['db' => 'amount','dt' => 1,'formatter' => function($i) { return 'Rp '.currency($i); }],
            ['db' => 'note','dt' => 2,'formatter' => function($i) { return str_replace('Reff: ','',$i); }],
            ['db' => 'id', 'dt' => 3, 'formatter' => function($i,$a) {
                $date = format_date('id',substr($a['date'],0,10));
                $time = substr(substr($a['date'],-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "user = '$sess_username' AND payment = 'voucher'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else {
        exit("No direct script access allowed!");
    }
} else {
    exit("No direct script access allowed!");
}