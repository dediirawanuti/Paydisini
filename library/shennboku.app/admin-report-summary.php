<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$date_start = isset($_GET['start']) ? filter($_GET['start']) : date('Y-m-d', strtotime("-3 days", strtotime($date)));
$date_end = isset($_GET['end']) ? filter($_GET['end']) : $date;
$filterd = ($date_start == $date_end) ? "date LIKE '$date_end%'" : ((strtotime($date_end) < strtotime($date_start)) ? "date LIKE '$date%'" : "DATE(date) BETWEEN '$date_start' AND '$date_end'");
$filter = ($date_start == $date_end) ? "date_cr LIKE '$date_end%'" : ((strtotime($date_end) < strtotime($date_start)) ? "date_cr LIKE '$date%'" : "DATE(date_cr) BETWEEN '$date_start' AND '$date_end'");

$search1 = $call->query("SELECT * FROM deposit WHERE $filterd AND status = 'paid'");
while($row = $search1->fetch_assoc()) {
    $payment = (strlen($row['payment']) > 3) ? ucfirst($row['payment']) : strtoupper($row['payment']);
    $method = (in_array($row['payment'],['transfer','voucher'])) ? $payment : '['.$payment.'] '.explode(' A/n ',$row['note'])[0];
    $out_depos_amount[$row['user']] += $row['amount'] + $row['uniq'] + $row['fee'];
    $out_depo_amount[$method] += $row['amount'] + $row['uniq'] + $row['fee'];
    $out_depo_total[$method] += 1;
}

$search2 = $call->query("SELECT * FROM trx_ppob WHERE $filter");
while($row = $search2->fetch_assoc()) {
    $out_status1_amount[$row['status']] += $row['price'];
    if($row['status'] == 'success') $out_users1_amount[$row['user']] += $row['price'];
    $out_status1_total[$row['status']] += 1;
}

$search3 = $call->query("SELECT * FROM trx_socmed WHERE $filter");
while($row = $search3->fetch_assoc()) {
    $out_status2_amount[$row['status']] += $row['price'];
    if(in_array($row['status'],['success','partial'])) $out_users2_amount[$row['user']] += $row['price'];
    $out_status2_total[$row['status']] += 1;
}

$search4 = $call->query("SELECT * FROM trx_game WHERE $filter");
while($row = $search4->fetch_assoc()) {
    $out_status3_amount[$row['status']] += $row['price'];
    if($row['status'] == 'success') $out_users3_amount[$row['user']] += $row['price'];
    $out_status3_total[$row['status']] += 1;
}