<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] <> 'Admin') exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2','3'])) exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($ctype == '1') { // Pulsa PPOB
        $table = 'trx_ppob';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'date_cr','dt' => 'date_cr'],
            ['db' => 'status','dt' => 'status'],
            ['db' => 'price','dt' => 'price'],
            ['db' => 'profit','dt' => 'profit'],
            ['db' => 'provider','dt' => 'provider'],

            ['db' => 'id', 'dt' => 0, 'formatter' => function($i,$a) {
                $format = format_date('id',$a['date_cr']);
                return '<center>'.explode(' (',$format)[0].'<br>'.str_replace(')','',explode(' (',$format)[1]).'</center>';
            }],
            ['db' => 'user', 'dt' => 1, 'formatter' => function($i,$a) {
                return $i.'<br><small class="text-primary"><shenn class="copy" title="Click to copy!" data-clipboard-text="'.$a['wid'].'">'.$a['wid'].'</shenn></small>';
            }],
            ['db' => 'name', 'dt' => 2, 'formatter' => function($i,$a) {
                $service = (strlen($i) > 26) ? substr($i,0,25).'...' : $i;
                $tid = '<font color="red" class="copy" title="Click to copy!" data-clipboard-text="'.$a['tid'].'">'.$a['provider'].': '.$a['tid'].'</font>';
                $prc = 'Rp '.currency($a['price']).' [+'.currency($a['profit']).']';
                return "<br><li>$service</li><li>$tid</li><li>$prc</li><br>";
            }],
            ['db' => 'data', 'dt' => 3, 'formatter' => function($i) {
                return '<div style="vertical-align:middle;"><div class="input-group"><input type="text" value="'.$i.'" class="form-control form-control-sm" readonly>
                        <div class="input-group-append"><button class="btn btn-sm text-white bg-warning fw-bold copy" data-clipboard-text="'.$i.'"><i class="far fa-copy">
                        </i></button></div></div></div>';
            }],
            ['db' => 'tid','dt' => 4, 'formatter' => function($i,$a) {
                if($a['status'] == 'error') $ic = 'bg-danger';
                if($a['status'] == 'waiting') $ic = 'bg-warning';
                if($a['status'] == 'success') $ic = 'bg-success';
                
                return '<center>
    <div class="dropdown">
        <button class="btn '.$ic.' text-white dropdown-toggle mr-1 waves-effect waves-light" type="button" id="drop2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.ucfirst($a['status']).'</button>
        <div class="dropdown-menu" aria-labelledby="drop2" x-placement="bottom-start" style="position:absolute;will-change:transform;top:0px;left:0px;transform:translate3d(0px, 38px, 0px);">
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('success').'\')">Sucess</a>
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('error').'\')">Error</a>
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('waiting').'\')">Waiting</a>
        </div>
    </div>
</center>';
            }],
            ['db' => 'wid','dt' => 5, 'formatter' => function($i,$a) {
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_modal('Order Details',base_url('order/detail/pulsa-ppob?id='.$i),'lg').'>
        <i class="feather icon-eye"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Edit Order',base_url('admin/pulsa-ppob/transaction-edit?s='.$i),'lg').'>
        <i class="feather icon-edit"></i>
    </a>
</center>';
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
            ['db' => 'date_cr','dt' => 'date_cr'],
            ['db' => 'status','dt' => 'status'],
            ['db' => 'price','dt' => 'price'],
            ['db' => 'profit','dt' => 'profit'],
            ['db' => 'amount','dt' => 'amount'],
            ['db' => 'provider','dt' => 'provider'],

            ['db' => 'id', 'dt' => 0, 'formatter' => function($i,$a) {
                $format = format_date('id',$a['date_cr']);
                return '<center>'.explode(' (',$format)[0].'<br>'.str_replace(')','',explode(' (',$format)[1]).'</center>';
            }],
            ['db' => 'user', 'dt' => 1, 'formatter' => function($i,$a) {
                return $i.'<br><small class="text-primary"><shenn class="copy" title="Click to copy!" data-clipboard-text="'.$a['wid'].'">'.$a['wid'].'</shenn></small>';
            }],
            ['db' => 'name', 'dt' => 2, 'formatter' => function($i,$a) {
                $service = (strlen($i) > 26) ? substr($i,0,25).'...' : $i;
                $tid = '<font color="red" class="copy" title="Click to copy!" data-clipboard-text="'.$a['tid'].'">'.$a['provider'].': '.$a['tid'].'</font>';
                $qty = 'Qty: '.$a['amount'];
                $prc = 'Rp '.currency($a['price']).' [+'.currency($a['profit']).']';
                return "<br><li>$service</li><li>$tid</li><li>$qty</li><li>$prc</li><br>";
            }],
            ['db' => 'data', 'dt' => 3, 'formatter' => function($i) {
                return '<div style="vertical-align:middle;"><input type="text" value="'.$i.'" class="form-control form-control-sm" readonly>
                        </div>';
            }],
            ['db' => 'tid','dt' => 4, 'formatter' => function($i,$a) {
                if($a['status'] == 'error') $ic = 'bg-danger';
                if($a['status'] == 'partial') $ic = 'bg-danger';
                if($a['status'] == 'waiting') $ic = 'bg-warning';
                if($a['status'] == 'processing') $ic = 'bg-info';
                if($a['status'] == 'success') $ic = 'bg-success';
                
                return '<center>
    <div class="dropdown">
        <button class="btn '.$ic.' text-white dropdown-toggle mr-1 waves-effect waves-light" type="button" id="drop2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.ucfirst($a['status']).'</button>
        <div class="dropdown-menu" aria-labelledby="drop2" x-placement="bottom-start" style="position:absolute;will-change:transform;top:0px;left:0px;transform:translate3d(0px, 38px, 0px);">
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('success').'\')">Sucess</a>
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('error').'\')">Error</a>
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('partial').'\')">Partial</a>
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('processing').'\')">Processing</a>
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('waiting').'\')">Waiting</a>
        </div>
    </div>
</center>';
            }],
            ['db' => 'wid','dt' => 5, 'formatter' => function($i,$a) {
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_modal('Order Details',base_url('order/detail/social-media?id='.$i),'lg').'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Edit Order',base_url('admin/social-media/transaction-edit?s='.$i),'lg').'>
        <i class="fa fa-pencil"></i>
    </a>
</center>';
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
            ['db' => 'date_cr','dt' => 'date_cr'],
            ['db' => 'status','dt' => 'status'],
            ['db' => 'price','dt' => 'price'],
            ['db' => 'zone','dt' => 'zone'],
            ['db' => 'profit','dt' => 'profit'],
            ['db' => 'provider','dt' => 'provider'],

            ['db' => 'id', 'dt' => 0, 'formatter' => function($i,$a) {
                $format = format_date('id',$a['date_cr']);
                return '<center>'.explode(' (',$format)[0].'<br>'.str_replace(')','',explode(' (',$format)[1]).'</center>';
            }],
            ['db' => 'user', 'dt' => 1, 'formatter' => function($i,$a) {
                return $i.'<br><small class="text-primary"><shenn class="copy" title="Click to copy!" data-clipboard-text="'.$a['wid'].'">'.$a['wid'].'</shenn></small>';
            }],
            ['db' => 'name', 'dt' => 2, 'formatter' => function($i,$a) {
                $service = (strlen($i) > 26) ? substr($i,0,25).'...' : $i;
                $tid = '<font color="red" class="copy" title="Click to copy!" data-clipboard-text="'.$a['tid'].'">'.$a['provider'].': '.$a['tid'].'</font>';
                $prc = 'Rp '.currency($a['price']).' [+'.currency($a['profit']).']';
                return "<br><li>$service</li><li>$tid</li><li>$prc</li><br>";
            }],
            ['db' => 'data', 'dt' => 3, 'formatter' => function($i,$a) {
                return '<div style="vertical-align:middle;"><div class="input-group"><input type="text" value="'.$i.' ('.$a['zone'].')" class="form-control form-control-sm" readonly>
                        <div class="input-group-append"><button class="btn btn-sm text-white bg-warning fw-bold copy" data-clipboard-text="'.$i.' ('.$a['zone'].')"><i class="far fa-copy">
                        </i></button></div></div></div>';
            }],
            ['db' => 'tid','dt' => 4, 'formatter' => function($i,$a) {
                if($a['status'] == 'error') $ic = 'bg-danger';
                if($a['status'] == 'waiting') $ic = 'bg-warning';
                if($a['status'] == 'success') $ic = 'bg-success';
                
                return '<center>
    <div class="dropdown">
        <button class="btn '.$ic.' text-white dropdown-toggle mr-1 waves-effect waves-light" type="button" id="drop2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.ucfirst($a['status']).'</button>
        <div class="dropdown-menu" aria-labelledby="drop2" x-placement="bottom-start" style="position:absolute;will-change:transform;top:0px;left:0px;transform:translate3d(0px, 38px, 0px);">
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('success').'\')">Sucess</a>
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('error').'\')">Error</a>
            <a class="dropdown-item" href="javascript:;" onclick="ShennStOrder(\''.$a['wid'].'\',\''.base64_encode('waiting').'\')">Waiting</a>
        </div>
    </div>
</center>';
            }],
            ['db' => 'wid','dt' => 5, 'formatter' => function($i,$a) {
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_modal('Order Details',base_url('order/detail/game-feature?id='.$i),'lg').'>
        <i class="feather icon-eye"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Edit Order',base_url('admin/game-feature/transaction-edit?s='.$i),'lg').'>
        <i class="feather icon-edit"></i>
    </a>
</center>';
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