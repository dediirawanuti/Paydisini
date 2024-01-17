<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($data_user['level'] == 'Admin') {
        $table = 'provider';
        $primaryKey = 'code';
        $columns = [
            ['db' => 'name','dt' => 0],
            ['db' => 'balance','dt' => 1,'formatter' => function($i) { return 'Rp '.currency($i); }],
            ['db' => 'code','dt' => 2,'formatter' => function($i,$a) {
                $shenn_name = $a['name'];
                $shenn_edit = base_url('admin/provider/edit?s='.base64_encode($i));
                $shenn_check = base_url('admin/provider/check?s='.base64_encode($i));
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" onclick="modal(\'Edit '.$shenn_name.'\',\''.$shenn_edit.'\',\'lg\')">
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" onclick="modal(\'Check '.$shenn_name.'\',\''.$shenn_check.'\',\'lg\')">
        <i class="fa fa-signal"></i>
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