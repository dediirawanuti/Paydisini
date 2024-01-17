<?php
set_time_limit(240);
require '../../connect.php';


$getkey = isset($_GET['noresult']) ? false : true;
$search = $call->query("SELECT * FROM trx_socmed WHERE status IN ('error','partial') AND refund = '0'");
if($search->num_rows == 0) {
} else {
    while($row = $search->fetch_assoc()) {
        $wid = $row['wid'];
        $user = $row['user'];
        $point = $row['point'];
        $service = $row['name'];
        $profit = $row['profit'] + $point;
        $uplink = $call->query("SELECT * FROM users WHERE username = '$user'")->fetch_assoc()['uplink'];
        $usr_data = $call->query("SELECT * FROM users WHERE username = '$user'")->fetch_assoc();
        
        
        
        $remains = ($row['remain'] > $row['amount']) ? $row['amount'] : $row['remain'];
        $min_price = ($row['price'] / $row['amount']) * $remains;
        $min_profit = ($profit / $row['amount']) * $remains;
        if($row['status'] == 'error') {
            $remains = 0;
            $min_price = $row['price'];
            $min_profit = $profit;
        }
        
        $befbal = $usr_data['balance'];
        $afbal = $usr_data['balance']+$min_price;
        
        
        $up = $call->query("UPDATE users SET balance = balance+$min_price WHERE username = '$user'");
        $up = $call->query("INSERT INTO mutation VALUES (null,'$user','+','$min_price','Socmed Refunds :: $wid','','','$date $time')");
        $up = $call->query("UPDATE trx_socmed SET price = price-$min_price, profit = profit-$min_profit, refund = '1' WHERE wid = '$wid'");
        if($up == true) {
            if($getkey == true);
            if($row['spoint'] == '1' && $call->query("SELECT * FROM users WHERE referral = '$uplink'")->num_rows == 1) {
                $call->query("UPDATE users SET point = point-$point WHERE referral = '$uplink'");
                $call->query("UPDATE trx_socmed SET point = '0' WHERE wid = '$wid'");
            }
        } else {
            if($getkey == true);
            }
    }
}
squery("UPDATE conf SET c3 = '$date $time' WHERE code = 'status-refund-access'");