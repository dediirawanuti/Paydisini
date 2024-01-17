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
            ['db' => 'date_cr','dt' => 'date_cr'],
            ['db' => 'refund','dt' => 'refund'],
            ['db' => 'status','dt' => 'status'],
            ['db' => 'id', 'dt' => 0, 'formatter' => function($i,$a) {
                $format = format_date('id',$a['date_cr']);
                return '<center>'.explode(' (',$format)[0].'<br>'.str_replace(')','',explode(' (',$format)[1]).'</center>';
            }],
            ['db' => 'name', 'dt' => 1, 'formatter' => function($i,$a) {
                if($a['status'] == 'error') $ic = 'far fa-times-circle text-danger';
                if($a['status'] == 'partial') $ic = 'far fa-dot-circle text-danger';
                if($a['status'] == 'waiting') $ic = 'fas fa-circle-notch fa-spin text-warning';
                if($a['status'] == 'processing') $ic = 'fas fa-circle-notch fa-spin text-info';
                if($a['status'] == 'success') $ic = 'far fa-check-circle text-success';
                $service = (strlen($i) > 26) ? substr($i,0,23).'...' : $i;
                return $service.'<br><small class="text-primary"><i class="'.$ic.'"></i> <shenn class="copy" style="cursor:pointer;" title="Click to copy!" data-clipboard-text="'.$a['wid'].'">Trx: '.$a['wid'].'</shenn></small>';
            }],
            ['db' => 'data', 'dt' => 2, 'formatter' => function($i) {
                return '<div style="vertical-align:middle;"><input type="text" value="'.$i.'" class="form-control form-control-sm" readonly></div>';
            }],
            ['db' => 'price','dt' => 3, 'formatter' => function($i) {
                return 'Rp '.currency($i);
            }],
            ['db' => 'wid','dt' => 4, 'formatter' => function($i,$a) {
                return '<center><a href="javascript:;" class="btn btn-primary text-white" onclick="modal(\'Order Details\',\''.base_url('order/detail/pulsa-ppob?id='.$i).'\',\'lg\')"><i class="fa fa-qrcode"></i></a></center>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "user = '$sess_username'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2') { // Social Media
        $table = 'trx_socmed';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date_cr','dt' => 'date_cr'],
            ['db' => 'refund','dt' => 'refund'],
            ['db' => 'status','dt' => 'status'],
            ['db' => 'id', 'dt' => 0, 'formatter' => function($i,$a) {
                $format = format_date('id',$a['date_cr']);
                return '<center>'.explode(' (',$format)[0].'<br>'.str_replace(')','',explode(' (',$format)[1]).'</center>';
            }],
            ['db' => 'name', 'dt' => 1, 'formatter' => function($i,$a) {
                if($a['status'] == 'error') $ic = 'far fa-times-circle text-danger';
                if($a['status'] == 'partial') $ic = 'far fa-dot-circle text-danger';
                if($a['status'] == 'waiting') $ic = 'fas fa-circle-notch fa-spin text-warning';
                if($a['status'] == 'processing') $ic = 'fas fa-circle-notch fa-spin text-info';
                if($a['status'] == 'success') $ic = 'far fa-check-circle text-success';
                $service = (strlen($i) > 26) ? substr($i,0,23).'...' : $i;
                return $service.'<br><small class="text-primary"><i class="'.$ic.'"></i> <shenn class="copy" style="cursor:pointer;" title="Click to copy!" data-clipboard-text="'.$a['wid'].'">Trx: '.$a['wid'].'</shenn></small>';
            }],
            ['db' => 'data', 'dt' => 2, 'formatter' => function($i) {
                return '<div style="vertical-align:middle;"><input type="text" value="'.$i.'" class="form-control form-control-sm" readonly>
                        </div>';
            }],
            ['db' => 'amount','dt' => 3, 'formatter' => function($i) {
                return currency($i);
            }],
            ['db' => 'price','dt' => 4, 'formatter' => function($i) {
                return 'Rp '.currency($i);
            }],
            ['db' => 'wid','dt' => 5, 'formatter' => function($i,$a) {
                return '<center><a href="javascript:;" class="btn btn-primary text-white" onclick="modal(\'Order Details\',\''.base_url('order/detail/social-media?id='.$i).'\',\'lg\')"><i class="fa fa-qrcode"></i></a></center>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "user = '$sess_username'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '3') { // Game Feature
        $table = 'trx_game';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date_cr','dt' => 'date_cr'],
            ['db' => 'refund','dt' => 'refund'],
            ['db' => 'status','dt' => 'status'],
            ['db' => 'id', 'dt' => 0, 'formatter' => function($i,$a) {
                $format = format_date('id',$a['date_cr']);
                return '<center>'.explode(' (',$format)[0].'<br>'.str_replace(')','',explode(' (',$format)[1]).'</center>';
            }],
            ['db' => 'name', 'dt' => 1, 'formatter' => function($i,$a) {
                if($a['status'] == 'error') $ic = 'far fa-times-circle text-danger';
                if($a['status'] == 'partial') $ic = 'far fa-dot-circle text-danger';
                if($a['status'] == 'waiting') $ic = 'fas fa-circle-notch fa-spin text-warning';
                if($a['status'] == 'processing') $ic = 'fas fa-circle-notch fa-spin text-info';
                if($a['status'] == 'success') $ic = 'far fa-check-circle text-success';
                $service = (strlen($i) > 26) ? substr($i,0,23).'...' : $i;
                return $service.'<br><small class="text-primary"><i class="'.$ic.'"></i> <shenn class="copy" style="cursor:pointer;" title="Click to copy!" data-clipboard-text="'.$a['wid'].'">Trx: '.$a['wid'].'</shenn></small>';
            }],
            ['db' => 'data', 'dt' => 2, 'formatter' => function($i) {
                return '<div style="vertical-align:middle;"><div class="input-group"><input type="text" value="'.$i.'" class="form-control form-control-sm" readonly>
                        <div class="input-group-append"><button class="btn btn-sm text-white bg-gradient-warning fw-bold copy" data-clipboard-text="'.$i.'">
                        <i class="far fa-copy"></i></button></div></div></div>';
            }],
            ['db' => 'price','dt' => 3, 'formatter' => function($i) {
                return 'Rp '.currency($i);
            }],
            ['db' => 'wid','dt' => 4, 'formatter' => function($i,$a) {
                return '<center><a href="javascript:;" class="btn btn-primary text-white" onclick="modal(\'Order Details\',\''.base_url('order/detail/game-feature?id='.$i).'\',\'lg\')"><i class="fas fa-qrcode"></i></a></center>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "user = '$sess_username'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else {
        exit("No direct script access allowed!");
    }
} else {
    exit("No direct script access allowed!");
}