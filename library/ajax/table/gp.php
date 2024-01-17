<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2'])) exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($ctype == '1') {
        $table = 'gopay';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'nomor',  'dt' => 0, 'formatter' => function($i) { 
                return $i; 
            }],
            
            ['db' => 'device',  'dt' => 1, 'formatter' => function($i) { 
                return $i; 
            }],
            
            ['db' => 'kode',  'dt' => 2, 'formatter' => function($i) { 
                return $i; 
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = '';
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2') {
        $table = 'mutation_gopay';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'invoice',  'dt' => 0, 'formatter' => function($i) { 
                return $i; 
            }],
            
            ['db' => 'amount',  'dt' => 1, 'formatter' => function($i) { 
                return $i; 
            }],
            
            ['db' => 'des',  'dt' => 2, 'formatter' => function($i) { 
                return $i; 
            }],
            
            ['db' => 'date',  'dt' => 3, 'formatter' => function($i) { 
                return $i; 
            }],
            
            ['db' => 'status',  'dt' => 4, 'formatter' => function($i) { 
                return $i; 
            }],
            
            ['db' => 'provider',  'dt' => 5, 'formatter' => function($i) { 
                return $i; 
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