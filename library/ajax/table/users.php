<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2','3'])) exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($ctype == '1') {
        $table = 'users';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'referral','dt' => 'referral'],
            ['db' => 'id','dt' => 0],
            ['db' => 'name','dt' => 1],
            ['db' => 'username','dt' => 2],
            ['db' => 'phone','dt' => 3, 'formatter' => function($i,$a) {
                $trx_game = squery("SELECT id FROM trx_game WHERE user = '".$a['username']."'")->num_rows;
                $trx_ppob = squery("SELECT id FROM trx_ppob WHERE user = '".$a['username']."'")->num_rows;
                $trx_socmed = squery("SELECT id FROM trx_socmed WHERE user = '".$a['username']."'")->num_rows;
                $trx_all = currency($trx_game+$trx_ppob+$trx_socmed);
                $deposit = currency(squery("SELECT id FROM deposit WHERE user = '".$a['username']."'")->num_rows);
                $downline = currency(squery("SELECT id FROM users WHERE uplink = '".$a['referral']."'")->num_rows);
                return "<li>Transaction: $trx_all Trx</li><li>Downline: $downline User</li><li>Deposit: $deposit Request</li>";
            }],
            ['db' => 'date','dt' => 4, 'formatter' => function($i) {
                $date = format_date('id',substr($i,0,10));
                $time = substr(substr($i,-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "uplink = '".$data_user['referral']."'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2' && $data_user['level'] == 'Admin') {
        $table = 'users';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'status', 'dt' => 'status'],
            ['db' => 'username', 'dt' => 0, 'formatter' => function($i,$a) {
                $icon = 'feather icon-x-circle text-danger';
                if($a['status'] == 'active') $icon = 'feather icon-check-circle text-success';
                if($a['status'] == 'active' && squery("SELECT user FROM users_lock WHERE user = '$i'")->num_rows == 1) $icon = 'feather icon-lock text-danger';
                return $i.' <i class="'.$icon.'"></i>';
            }],
            ['db' => 'name', 'dt' => 1],
            ['db' => 'email', 'dt' => 2],
            ['db' => 'phone', 'dt' => 3],
            ['db' => 'balance', 'dt' => 4, 'formatter' => function($i) { return 'Rp '.currency($i); }],
            ['db' => 'date', 'dt' => 5, 'formatter' => function($i) {
                $date = format_date('id',substr($i,0,10));
                $time = substr(substr($i,-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
            ['db' => 'id', 'dt' => 6, 'formatter' => function($i) {
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_modal('Edit User', base_url('admin/users/edit?uid='.$i), 'lg').'>
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Detail User', base_url('admin/users/detail?uid='.$i), 'lg').'>
        <i class="fa fa-eye"></i>
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
    } else if($ctype == '3' && $data_user['level'] == 'Admin') {
        $table = 'users_lock';
        $primaryKey = 'user';
        $columns = [
            ['db' => 'date', 'dt' => 0, 'formatter' => function($i) {
                $date = format_date('id',substr($i,0,10));
                $time = substr(substr($i,-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
            ['db' => 'user', 'dt' => 1],
            ['db' => 'reason', 'dt' => 2],
            ['db' => 'user', 'dt' => 3, 'formatter' => function($i) {
                return '<center>
    <a href="javascript:;" class="font-medium-5" style="text-decoration:none;" '.onclick_href(base_url('admin/users/locked?unlock='.base64_encode($i))).'>
        <i class="fa fa-trash"></i>
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