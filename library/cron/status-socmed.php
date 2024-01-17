<?php
set_time_limit(240);
require '../../connect.php';
require 'helper.php';

$getkey = isset($_GET['noresult']) ? false : true;
$showpw = isset($_SESSION['user']['level']) ? $_SESSION['user']['level'] : 'invalid';
$stdate = date('Y-m-d', strtotime('-3 Months', strtotime($date)));
$search = $call->query("SELECT * FROM trx_socmed WHERE status IN ('waiting','processing','') AND provider != 'X' AND DATE(date_cr) BETWEEN '$stdate' AND '$date' ORDER BY rand() LIMIT 20");
if($search->num_rows == 0) {
} else {
    while($row = $search->fetch_assoc()) {
        $wid = $row['wid'];
        $tid = $row['tid'];
        $user = $row['user'];
        $server = $row['provider'];
        $ostatus = $row['status'];
        $prov = $call->query("SELECT * FROM provider WHERE code = '$server'")->fetch_assoc();
        $uplink = $call->query("SELECT * FROM users WHERE username = '$user'")->fetch_assoc()['uplink'];
        
        if($server == 'IRVAN') {
            $try = $curl->connectPost($prov['link'].'/status',['api_id' => $prov['userid'],'api_key' => $prov['apikey'],'id' => $tid]);
            $data['success'] = isset($try['status']) ? $try['status'] : false;
            $data['status'] = $data['success'] == true ? $try['data']['status'] : 'waiting';
            $data['remain'] = $data['success'] == true ? $try['data']['remains'] : 0;
            $data['counts'] = $data['success'] == true ? $try['data']['start_count'] : 0;
            $data['errors'] = $data['success'] == false ? isset($try['msg']) ? $try['msg'] : 'Connection Failed!' : '';
        } else {
            $data = [
                'success' => false,
                'status' => 'error',
                'remain' => 0,
                'counts' => 0,
                'errors' => 'Provider not supported / still in the making stage.',
            ];
        }
        
        if($data['success'] == true) {
            $status = $helper->status($data['status']);
            $remain = $data['remain'];
            $count = $data['counts'];
            $point = point($row['price'],$row['profit'],'socmed');
            
            if($call->query("UPDATE trx_socmed SET count = '$count', remain = '$remain', status = '$status', date_up = '$date $time' WHERE wid = '$wid'") == true) {
                if($status == 'success' && $row['spoint'] == '0' && $call->query("SELECT * FROM users WHERE referral = '$uplink'")->num_rows == 1) {
                    $call->query("UPDATE users SET point = point+$point WHERE referral = '$uplink'");
                    $call->query("UPDATE trx_socmed SET profit = profit-$point, spoint = '1', point = '$point' WHERE wid = '$wid'");
                }
                
                if($getkey == true) {
                    print '<font color="green"><pre>[+] '.$tid.' {Update Success}</pre></font>';
                    if($showpw == 'Admin') {
                        print '<font color="green"><pre>User: '.$row['user'].'</pre></font>';
                        print '<font color="green"><pre>Prov: '.$server.'</pre></font>';
                        print '<font color="green"><pre>Count: '.currency($count).'</pre></font>';
                        print '<font color="green"><pre>Remain: '.currency($remain).'</pre></font>';
                        print '<font color="green"><pre>Status: '.$ostatus.' -> '.$status.'</pre></font>';
                    }
                    print '<hr>';
                }
            } else {
                if($getkey == true) {
                    print '<font color="red"><pre>[!] '.$tid.' {Update Failed}</pre></font>';
                    if($showpw == 'Admin') {
                        print '<font color="red"><pre>User: '.$row['user'].'</pre></font>';
                        print '<font color="red"><pre>Prov: '.$server.'</pre></font>';
                        print '<font color="red"><pre>Count: '.currency($count).'</pre></font>';
                        print '<font color="red"><pre>Remain: '.currency($remain).'</pre></font>';
                        print '<font color="red"><pre>Status: '.$status.'</pre></font>';
                    }
                    print '<hr>';
                }
            }
        } else {
            if($getkey == true) {
                print '<font color="red"><pre>[!] '.$tid.' {'.$data['errors'].'} - {'.$row['provider'].'}</pre></font>';
                if($showpw == 'Admin') {
                    print '<font color="red"><pre>User: '.$row['user'].'</pre></font>';
                    print '<font color="red"><pre>Prov: '.$server.'</pre></font>';
                }
                print '<hr>';
            }
        }
    }
}
squery("UPDATE conf SET c6 = '$date $time' WHERE code = 'status-refund-access'");