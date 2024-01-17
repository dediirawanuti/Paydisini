<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    $ctype = filter($_GET['__s']);
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!in_array($ctype, ['1','2','ShennMethod'])) exit("No direct script access allowed!");
    
    require _DIR_('library/function/ssp.class');
    if($ctype == '1') {
        $table = 'deposit';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'id','dt' => 'id'],
            ['db' => 'wid','dt' => 'wid'],
            ['db' => 'payment','dt' => 'payment'],
            ['db' => 'date','dt' => 'date'],
            ['db' => 'status','dt' => 'status'],
            ['db' => 'note','dt' => 'note'],
            
            ['db' => 'id', 'dt' => 0, 'formatter' => function($i,$a) {
                if (strpos($a['note'], 'https://') === 0) {
                    return '<a href="'.$a['note'].'" style="text-decoration:none;">#'.$a['wid'].'</a>';
                } else { 
                    return '<a href="'.base_url('deposit/invoice/'.$a['wid']).'" style="text-decoration:none;">#'.$a['wid'].'</a>';
                }
            }],
            ['db' => 'amount', 'dt' => 1, 'formatter' => function($i,$a) {
                if($a['status'] == 'cancelled') $ic = 'fa fa-times-circle text-danger';
                if($a['status'] == 'unpaid') $ic = 'fa fa-circle fa-spin text-warning';
                if($a['status'] == 'paid') $ic = 'fa fa-check-circle text-success';
                $payname = squery("SELECT * FROM deposit_payment WHERE code = '".$a['payment']."' ORDER BY name ASC LIMIT 1");
                $payname = ($payname->num_rows == 1) ? $payname->fetch_assoc()['name'] : 'Unknown';
                return $payname.'<br><i class="'.$ic.'"></i>   Rp '.currency($i);
            }],
            ['db' => 'note', 'dt' => 2, 'formatter' => function($i,$a) {
                if (strpos($i, 'A/n') !== false) {
                    $exploded = explode(' A/n ', $i);
                    if (in_array($a['payment'], ['telkomsel', 'axiata'])) {
                        return $exploded[0];
                    } else {
                        return $exploded[0] . '<br>' . $exploded[1];
                    }
                } else if (strpos($i, 'https://') === 0) {
                    return '<a href="'.$i.'">Klik</a>';
                } else {
                    return $i;
                }
            }],
            ['db' => 'sender','dt' => 3, 'formatter' => function($i) { return (!empty($i)) ? $i : '<center>?</center>'; }],
            ['db' => 'date', 'dt' => 4, 'formatter' => function($i) {
                $date = format_date('id',substr($i,0,10));
                $time = substr(substr($i,-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "user = '$sess_username' AND payment NOT IN ('transfer','voucher')";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == '2' && $data_user['level'] == 'Admin') {
        $table = 'deposit';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'wid','dt' => 'wid'],
            ['db' => 'uniq','dt' => 'uniq'],
            ['db' => 'sender','dt' => 'sender'],
            ['db' => 'amount','dt' => 'amount'],
            ['db' => 'status','dt' => 'status'],
            ['db' => 'fee','dt' => 'fee'],
            
            ['db' => 'user', 'dt' => 0, 'formatter' => function($i,$a) {
                return $i.'<br>#'.$a['wid'];
            }],
            ['db' => 'method', 'dt' => 1,'formatter' => function($i,$a) {
                return (!$a['sender']) ? $i : $i.'<br>Send: '.$a['sender'];
            }],
            ['db' => 'wid', 'dt' => 2, 'formatter' => function($i,$a) {
                $qty = currency($a['amount']+$a['fee']+$a['uniq']);
                $amn = currency($a['amount']+$a['uniq']);
                return "<li>Trf: $qty</li><li>Get: $amn</li>";
            }],
            ['db' => 'date', 'dt' => 3, 'formatter' => function($i) {
                $date = format_date('id',substr($i,0,10));
                $time = substr(substr($i,-8),0,5);
                return "<center>$date<br>$time WIB</center>";
            }],
            ['db' => 'id',  'dt' => 4, 'formatter' => function($i,$a) {
                $t_paid = base_url('admin/deposit/status-deposit?id='.base64_encode($i).'&data='.base64_encode('paid'));
                $t_cancel = base_url('admin/deposit/status-deposit?id='.base64_encode($i).'&data='.base64_encode('cancelled'));
                if($a['status'] == 'unpaid') return '<center>
    <div class="dropdown">
        <button class="btn bg-warning dropdown-toggle" type="button" id="drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Unpaid</button>
        <div class="dropdown-menu" aria-labelledby="drop1">
            <a class="dropdown-item" href="javascript:;" onclick="ShennStDeposit(\''.$t_paid.'\')">Paid</a>
            <a class="dropdown-item" href="javascript:;" onclick="ShennStDeposit(\''.$t_cancel.'\')">Cancelled</a>
        </div>
    </div>
</center>';

                if($a['status'] == 'paid') return '<center>
    <div class="dropdown">
        <button class="btn bg-success dropdown-toggle" type="button" disabled>Paid</button>
    </div>
</center>';
                                        
                if($a['status'] == 'cancelled') return '<center>
    <div class="dropdown">
        <button class="btn bg-danger dropdown-toggle" type="button" disabled>Cancelled</button>
    </div>
</center>';
            }],
        ];
        $sql_details = ['user' => $aiy['user'],'pass' => $aiy['pass'],'db' => $aiy['name'],'host' => $aiy['host']];
        $joinQuery = null;
        $extraWhere = "payment NOT IN ('transfer','voucher')";
        $groupBy = '';
        $having = '';
        print(json_encode(SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$extraWhere,$groupBy,$having)));
    } else if($ctype == 'ShennMethod' && $data_user['level'] == 'Admin') {
        $table = 'deposit_method';
        $primaryKey = 'id';
        $columns = [
            ['db' => 'xfee', 'dt' => 'xfee'],
            ['db' => 'data', 'dt' => 'data'],
            ['db' => 'method', 'dt' => 'method'],
            ['db' => 'name', 'dt' => 0,'formatter' => function($i,$a) {
                $paym = squery("SELECT * FROM deposit_payment WHERE code = '".$a['method']."' ORDER BY name ASC LIMIT 1");
                $paym = ($paym->num_rows == 1) ? $paym->fetch_assoc()['name'] : 'Unknown';
                return "<li>$paym</li><li>$i</li>";
            }],
            ['db' => 'rate', 'dt' => 1,'formatter' => function($i) { return ($i*100).'%'; }],
            ['db' => 'fee', 'dt' => 2,'formatter' => function($i,$a) { return ($a['xfee'] == '-') ? '-'.currency($i) : ($i*100).'%'; }],
            ['db' => 'min', 'dt' => 3,'formatter' => function($i) { return 'Rp '.currency($i); }],
            ['db' => 'data', 'dt' => 4,'formatter' => function($i) {
                $acc = explode(' A/n ',$i)[1];
                $num = explode(' A/n ',$i)[0];
                return "$num [$acc]";
            }],
            ['db' => 'id',  'dt' => 5, 'formatter' => function($i) {
                $lann_edit = base_url('admin/deposit/method-edit?s='.base64_encode($i));
                $lann_delete = base_url('admin/deposit/method-delete?s='.base64_encode($i));
                return "<center>
    <a href=\"javascript:;\" class=\"font-medium-5 mr-1\" style=\"text-decoration:none;\" ".onclick_modal('Edit Method',$lann_edit,'lg').">
        <i class=\"fa fa-pencil\"></i>
    </a>
    <a href=\"javascript:;\" class=\"font-medium-5 ml-1\" style=\"text-decoration:none;\" ".onclick_modal('Delete Method',$lann_delete,'lg').">
        <i class=\"fa fa-trash\"></i>
    </a>
</center>";
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