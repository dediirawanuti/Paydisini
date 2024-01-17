<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2','3'])) exit("No direct script access allowed!");
            
    require _DIR_('library/function/ssp.class');
       
    if($ctype == '1') { // Pulsa PPOB
        $table = 'trx_ppob';
        $primaryKey = 'id';
        $columns = [        
        ['db' => 'status','dt' => 'status'],
            ['db' => 'date_cr','dt' => 0, 'formatter' => function($i) {
                return ''.LannCenter(format_date('id',$i)).'';           
            }],
            ['db' => 'name','dt' => 1, 'formatter' => function($i,$a) {
                return ''.$i.'<br>'.LannStatus($a['status']).'';
            }],
            ['db' => 'data','dt' => 2, 'formatter' => function($i) {
                return ''.substr($i,0,-5).'xxxxx';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = '';
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2') { // Social Media
        $table = 'trx_socmed';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'status','dt' => 'status'],
            ['db' => 'date_cr','dt' => 0, 'formatter' => function($i) {
                return ''.LannCenter(format_date('id',$i)).'';           
            }],
            ['db' => 'name','dt' => 1, 'formatter' => function($i,$a) {
                return ''.$i.'<br>'.LannStatusSocmed($a['status']).'';
            }],
            ['db' => 'amount','dt' => 2, 'formatter' => function($i) {
                return ''.currency($i).'';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = '';
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '3') { // Game Feature
        $table = 'trx_game';
        $primaryKey = 'id';
        $columns = [        
        ['db' => 'status','dt' => 'status'],
            ['db' => 'date_cr','dt' => 0, 'formatter' => function($i) {
                return ''.LannCenter(format_date('id',$i)).'';           
            }],
            ['db' => 'name','dt' => 1, 'formatter' => function($i,$a) {
                return ''.$i.'<br>'.LannStatusGame($a['status']).'';
            }],
            ['db' => 'data','dt' => 2, 'formatter' => function($i) {
                return ''.substr($i,0,-5).'xxxxx';
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