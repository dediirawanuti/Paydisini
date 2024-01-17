<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");    
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2'])) exit("No direct script access allowed!");
            
    require _DIR_('library/function/ssp.class');
    
    if($ctype == '1') {
        $table = 'mutasi_gopay';
        $primaryKey = 'id';
        $columns = [        
        ['db' => 'status','dt' => 'status'],
            ['db' => 'datetime','dt' => 0, 'formatter' => function($i) {
                return ''.LannCenter(format_date('id',$i)).'';           
            }],
            ['db' => 'descript','dt' => 1, 'formatter' => function($i) {
                return ''.$i.'';
            }],
            ['db' => 'amount','dt' => 2, 'formatter' => function($i) {
                return 'Rp '.LannCurr($i).'';
            }],
            ['db' => 'status','dt' => 3, 'formatter' => function($i) {
                return ''.LannStat($i).'';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = '';
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2') {
        $table = 'gopay';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'nomor', 'dt' => 1],
            ['db' => 'device', 'dt' => 2],
            ['db' => 'balance', 'dt' => 3, 'formatter' => function($i) {
                return 'Rp '.LannCurr($i).'';
            }],
            ['db' => 'token', 'dt' => 4, 'formatter' => function($i) {
                return ''.substr($i,0, -1000).'...';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = '';
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else {
        exit("No direct script access allowed!");
    }
} else {
    exit("No direct script access allowed!");
}