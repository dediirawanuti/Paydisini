<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$date_start = isset($_GET['start']) ? filter($_GET['start']) : date('Y-m-d', strtotime("-3 days", strtotime($date)));
$date_end = isset($_GET['end']) ? filter($_GET['end']) : $date;
$status = isset($_GET['status']) ? (in_array($_GET['status'],['cancelled','unpaid','paid']) ? $_GET['status'] : 'All') : 'All';
$filter = ($date_start == $date_end) ? "date LIKE '$date_end%'" : ((strtotime($date_end) < strtotime($date_start)) ? "date LIKE '$date%'" : "DATE(date) BETWEEN '$date_start' AND '$date_end'");

$dbstatus = ($status != 'All') ? "AND status = '$status'" : '';
$search_deposit = $call->query("SELECT * FROM deposit WHERE $filter $dbstatus");
while($row = $search_deposit->fetch_assoc()) {
    $ProvName = (!isset($out_deposito[$row['payment']]))
                ? (($call->query("SELECT name FROM deposit_payment WHERE code = '".$row['payment']."'")->num_rows == 0) ? ucfirst($row['payment']) : $call->query("SELECT name FROM deposit_payment WHERE code = '".$row['payment']."'")->fetch_assoc()['name'])
                : $out_deposito[$row['payment']];
    $NoRek = explode(' A/n ',$row['note']);
    $out_deposit[$ProvName]['amount'] += explode('.',($row['amount']+$row['uniq']))[0];
    $out_deposit[$ProvName]['fee'] += explode('.',$row['fee'])[0];
    $out_deposit[$ProvName]['total'] += 1;
    if(!in_array($row['payment'],['transfer','voucher'])) {
        $out_deposit[$ProvName][$NoRek[0]]['amount'] += explode('.',($row['amount']+$row['uniq']))[0];
        $out_deposit[$ProvName][$NoRek[0]]['fee'] += explode('.',$row['fee'])[0];
        $out_deposit[$ProvName][$NoRek[0]]['total'] += 1;
    } else {
        $out_deposit[$ProvName]['-']['amount'] += explode('.',($row['amount']+$row['uniq']))[0];
        $out_deposit[$ProvName]['-']['fee'] += explode('.',$row['fee'])[0];
        $out_deposit[$ProvName]['-']['total'] += 1;
    }
    $out_deposit['All-Data']['amount'] += explode('.',($row['amount']+$row['uniq']))[0];
    $out_deposit['All-Data']['fee'] += explode('.',$row['fee'])[0];
    $out_deposit['All-Data']['total'] += 1;
}

function clearing($data) {
    $x = '<td colspan="2">All Payment</td><td>'.currency($data['total']).' Req</td><td>Rp '.currency($data['amount']).'</td><td>Rp '.currency($data['fee']).'</td>';
    print ($tr == true) ? '<tr>'.$x.'</tr>' : $x;
}