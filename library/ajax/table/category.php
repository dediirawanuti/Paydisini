<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2','3'])) exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($ctype == '1') { // Pulsa PPOB
        $table = 'category';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'order','dt' => 'order'],
            ['db' => 'code','dt' => 0],
            ['db' => 'name','dt' => 1],
            ['db' => 'type','dt' => 2,'formatter' => function($i) {
                $new = strtr($i,[
                    'pulsa-reguler'       => 'Pulsa Reguler',           'voucher-game'  => 'Voucher Game',
                    'pulsa-internasional' => 'Pulsa Internasional',     'streaming-tv'  => 'Streaming & TV',
                    'paket-internet'      => 'Paket Internet',          'saldo-emoney'  => 'Saldo E-Money',
                    'paket-telepon'       => 'Paket Telepon dan SMS',   'paket-lainnya' => 'Kategori Lainnya',
                    'token-pln'           => 'Token Listrik (PLN)',     'pascabayar'    => 'Pascabayar',
                ]);
                return "$new [$i]";
            }],
            ['db' => 'id','dt' => 3,'formatter' => function($i) {
                $shenn_edit = base_url('admin/pulsa-ppob/category-edit?s='.base64_encode($i));
                $shenn_delete = base_url('admin/pulsa-ppob/category-delete?s='.base64_encode($i));
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" onclick="modal(\'Edit Category\',\''.$shenn_edit.'\',\'lg\')">
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" onclick="modal(\'Delete Category\',\''.$shenn_delete.'\',\'lg\')">
        <i class="fa fa-trash"></i>
    </a>
</center>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "`order` IN ('prepaid','postpaid')";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2') { // Social Media
        $table = 'category';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'order','dt' => 'order'],
            ['db' => 'code','dt' => 0],
            ['db' => 'name','dt' => 1],
            ['db' => 'id','dt' => 2,'formatter' => function($i) {
                $shenn_edit = base_url('admin/social-media/category-edit?s='.base64_encode($i));
                $shenn_delete = base_url('admin/social-media/category-delete?s='.base64_encode($i));
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" onclick="modal(\'Edit Category\',\''.$shenn_edit.'\',\'lg\')">
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" onclick="modal(\'Delete Category\',\''.$shenn_delete.'\',\'lg\')">
        <i class="fa fa-trash"></i>
    </a>
</center>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "`order` = 'social'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '3') { // Game Feature
        $table = 'category';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'order','dt' => 'order'],
            ['db' => 'code','dt' => 0],
            ['db' => 'name','dt' => 1],
            ['db' => 'id','dt' => 2,'formatter' => function($i) {
                $shenn_edit = base_url('admin/game-feature/category-edit?s='.base64_encode($i));
                $shenn_delete = base_url('admin/game-feature/category-delete?s='.base64_encode($i));
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" onclick="modal(\'Edit Category\',\''.$shenn_edit.'\',\'lg\')">
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" onclick="modal(\'Delete Category\',\''.$shenn_delete.'\',\'lg\')">
        <i class="fa fa-trash"></i>
    </a>
</center>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "`order` = 'game'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else {
        exit("No direct script access allowed!");
    }
} else {
    exit("No direct script access allowed!");
}