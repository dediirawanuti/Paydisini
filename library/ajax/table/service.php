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
        $table = 'srv_ppob';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'price','dt' => 'price'],
            ['db' => 'basic','dt' => 'basic'],
            ['db' => 'premium','dt' => 'premium'],
            ['db' => 'status','dt' => 'status'],
            
            ['db' => 'code','dt' => 0],
            ['db' => 'brand','dt' => 1, 'formatter' => function($i,$a) {
                $status = ($a['status'] == 'available') ? '<font class="text-success">Available</font>' : '<font class="text-danger">Out of Stock</font>';
                return $i.'<br><small class="text-primary">'.$a['name'].'<br>[ '.$status.' ]</small>';
            }],
            ['db' => 'name','dt' => 2, 'formatter' => function($i,$a) {
                $basic = currency($a['price']+$a['basic']);
                $premium = currency($a['price']+$a['premium']);
                return '<li class="mt-1">Rp '.currency($a['price']).' [Source]</li><li>Rp '.$basic.' [Basic]</li><li class="mb-1">Rp '.$premium.' [Premium]</li>';
            }],
            ['db' => 'provider','dt' => 3, 'formatter' => function($i,$a) {
                $data = squery("SELECT * FROM provider WHERE code = '$i'");
                if($data->num_rows == 1) $data = $data->fetch_assoc();
                return (is_array($data)) ? $data['name'] : $i;
            }],
            ['db' => 'id','dt' => 4, 'formatter' => function($i) {
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_modal('Detail Service', base_url('admin/pulsa-ppob/service-detail?id='.$i), 'lg').'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="javascript:;" class="font-medium-5" style="text-decoration:none;" '.onclick_modal('Edit Service', base_url('admin/pulsa-ppob/service-edit?id='.$i), 'lg').'>
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Delete Service', base_url('admin/pulsa-ppob/service-delete?id='.$i), 'sm').'>
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
    } else if($ctype == '2') { // Social Media
        $table = 'srv_socmed';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'pid','dt' => 'pid'],
            ['db' => 'price','dt' => 'price'],
            ['db' => 'basic','dt' => 'basic'],
            ['db' => 'premium','dt' => 'premium'],
            ['db' => 'status','dt' => 'status'],
            
            ['db' => 'id','dt' => 0],
            ['db' => 'cid','dt' => 1, 'formatter' => function($i,$a) {
                $data = squery("SELECT * FROM category WHERE code = '$i'");
                if($data->num_rows == 1) $data = $data->fetch_assoc();
                $name = (is_array($data)) ? $data['name'] : $i;
                $status = ($a['status'] == 'available') ? '<font class="text-success">Available</font>' : '<font class="text-danger">Out of Stock</font>';
                return $name.'<br><small class="text-primary">'.$a['name'].'<br>[ '.$status.' ]</small>';
            }],
            ['db' => 'name','dt' => 2, 'formatter' => function($i,$a) {
                $basic = currency($a['price']+$a['basic']);
                $premium = currency($a['price']+$a['premium']);
                return '<li class="mt-1">Rp '.currency($a['price']).' [Source]</li><li>Rp '.$basic.' [Basic]</li><li class="mb-1">Rp '.$premium.' [Premium]</li>';
            }],
            ['db' => 'provider','dt' => 3, 'formatter' => function($i,$a) {
                $data = squery("SELECT * FROM provider WHERE code = '$i'");
                if($data->num_rows == 1) $data = $data->fetch_assoc();
                $name = (is_array($data)) ? $data['name'] : $i;
                return '<li class="mt-1">'.$a['pid'].'</li><li class="mb-1">'.$name.'</li>';
            }],
            ['db' => 'id','dt' => 4, 'formatter' => function($i) {
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_modal('Detail Service', base_url('admin/social-media/service-detail?id='.$i), 'lg').'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="javascript:;" class="font-medium-5" style="text-decoration:none;" '.onclick_modal('Edit Service', base_url('admin/social-media/service-edit?id='.$i), 'lg').'>
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Delete Service', base_url('admin/social-media/service-delete?id='.$i), 'md').'>
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
    } else if($ctype == '3') { // Game Feature
        $table = 'srv_game';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'price','dt' => 'price'],
            ['db' => 'basic','dt' => 'basic'],
            ['db' => 'premium','dt' => 'premium'],
            ['db' => 'status','dt' => 'status'],
            
            ['db' => 'code','dt' => 0],
            ['db' => 'game','dt' => 1, 'formatter' => function($i,$a) {
                $status = ($a['status'] == 'available') ? '<font class="text-success">Available</font>' : '<font class="text-danger">Out of Stock</font>';
                return $i.'<br><small class="text-primary">'.$a['name'].'<br>[ '.$status.' ]</small>';
            }],
            ['db' => 'name','dt' => 2, 'formatter' => function($i,$a) {
                $basic = currency($a['price']+$a['basic']);
                $premium = currency($a['price']+$a['premium']);
                return '<li class="mt-1">Rp '.currency($a['price']).' [Source]</li><li>Rp '.$basic.' [Basic]</li><li class="mb-1">Rp '.$premium.' [Premium]</li>';
            }],
            ['db' => 'provider','dt' => 3, 'formatter' => function($i,$a) {
                $data = squery("SELECT * FROM provider WHERE code = '$i'");
                if($data->num_rows == 1) $data = $data->fetch_assoc();
                return (is_array($data)) ? $data['name'] : $i;
            }],
            ['db' => 'id','dt' => 4, 'formatter' => function($i) {
                return '<center>
    <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" '.onclick_modal('Detail Service', base_url('admin/game-feature/service-detail?id='.$i), 'lg').'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="javascript:;" class="font-medium-5" style="text-decoration:none;" '.onclick_modal('Edit Service', base_url('admin/game-feature/service-edit?id='.$i), 'lg').'>
        <i class="fa fa-pencil"></i>
    </a>
    <a href="javascript:;" class="font-medium-5 ml-1" style="text-decoration:none;" '.onclick_modal('Delete Service', base_url('admin/game-feature/service-delete?id='.$i), 'sm').'>
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