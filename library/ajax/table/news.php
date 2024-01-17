<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2','3','4'])) exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($ctype == '1') {
        $table = 'information';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'content', 'dt' => 'content'],
            ['db' => 'type', 'dt' => 'type'],
            ['db' => 'date', 'dt' => 'date'],
            
            ['db' => 'id', 'dt' => 0, 'formatter' => function($i,$a) {
                return '<br><b><i class="far fa-calendar-alt mr-1"></i>'.format_date('id',$a['date']).' | '.strtoupper($a['type']).'</b><br>'.base64_decode($a['content']).'<hr>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "type != 'banner'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2' && $data_user['level'] == 'Admin') {
        $table = 'information';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'content', 'dt' => 'content'],
            ['db' => 'date', 'dt' => 'date'],
            
            ['db' => 'type', 'dt' => 0, 'formatter' => function($i,$a) {
                return '<br><b><i class="far fa-calendar-alt mr-1"></i>'.format_date('id',$a['date']).' | '.strtoupper($i).'</b><br>'.base64_decode($a['content']).'<hr>';
            }],
            ['db' => 'id', 'dt' => 1, 'formatter' => function($i) {
                $shenn_edit = base_url('admin/others/news/edit?s='.base64_encode($i));
                $shenn_delete = base_url('admin/others/news/delete?s='.base64_encode($i));
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_href($shenn_edit).'>
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Delete News / Info',$shenn_delete,'lg').'>
        <i class="fa fa-trash"></i>
    </a>
</center>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "type != 'banner'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '3' && $data_user['level'] == 'Admin') {
        $table = 'information';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'content', 'dt' => 'content'],
            ['db' => 'date', 'dt' => 'date'],
            
            ['db' => 'content', 'dt' => 0, 'formatter' => function($i) {
                return '<a href="'.$i.'" class="image-popup"><img class="d-block img-fluid" src="'.$i.'"></a>';
            }],
            ['db' => 'id', 'dt' => 1, 'formatter' => function($i) {
                $shenn_edit = base_url('admin/others/banner/edit?s='.base64_encode($i));
                $shenn_delete = base_url('admin/others/banner/delete?s='.base64_encode($i));
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_modal('Edit Banner',$shenn_edit,'lg').'>
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Delete Banner',$shenn_delete,'lg').'>
        <i class="fa fa-trash"></i>
    </a>
</center>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "type = 'banner'";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '4' && $data_user['level'] == 'Admin') {
        $table = 'general_quest';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'quest', 'dt' => 0],
            ['db' => 'answer', 'dt' => 1, 'formatter' => function($i) {
                return base64_decode($i).'<hr>';
            }],
            ['db' => 'id', 'dt' => 2, 'formatter' => function($i) {
                $shenn_edit = base_url('admin/others/faq/edit?s='.base64_encode($i));
                $shenn_delete = base_url('admin/others/faq/delete?s='.base64_encode($i));
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_href($shenn_edit).'>
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Delete News / Info',$shenn_delete,'lg').'>
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