<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$date_start = isset($_GET['start']) ? filter($_GET['start']) : date('Y-m-d', strtotime("-3 days", strtotime($date)));
$date_end = isset($_GET['end']) ? filter($_GET['end']) : $date;
$status = isset($_GET['status']) ? (in_array($_GET['status'],['error','partial','waiting','processing','success']) ? $_GET['status'] : 'All') : 'All';
$filter = ($date_start == $date_end) ? "date_cr LIKE '$date_end%'" : ((strtotime($date_end) < strtotime($date_start)) ? "date_cr LIKE '$date%'" : "DATE(date_cr) BETWEEN '$date_start' AND '$date_end'");

$dbstatus = ($status != 'All') ? "AND status = '$status'" : '';
function getTransaction($from) {
    global $call, $filter, $dbstatus;
    $search = $call->query("SELECT * FROM $from WHERE $filter $dbstatus ORDER BY provider ASC");
    while($row = $search->fetch_assoc()) {
        if($call->query("SELECT code FROM provider WHERE code = '".$row['provider']."'")->num_rows == 1) {
            $out_data[$row['provider']]['modal'] += $row['price']-$row['profit'];
            $out_data[$row['provider']]['margin'] += $row['profit'];
            $out_data[$row['provider']]['total'] += 1;
        } else {
            $out_data['?-'.$row['provider']]['modal'] += $row['price']-$row['profit'];
            $out_data['?-'.$row['provider']]['margin'] += $row['profit'];
            $out_data['?-'.$row['provider']]['total'] += 1;
        }
        $out_data['All-Data']['modal'] += $row['price']-$row['profit'];
        $out_data['All-Data']['margin'] += $row['profit'];
        $out_data['All-Data']['total'] += 1;
    }
    return $out_data;
}

function clearing($data) {
    $x = '<td>All Server</td><td>Rp '.currency($data['modal']).'</td><td>'.currency($data['total']).' Trx</td><td>Rp '.currency($data['margin']).'</td>';
    print ($tr == true) ? '<tr>'.$x.'</tr>' : $x;
}

$out_game = getTransaction('trx_game');
$out_pulsa = getTransaction('trx_ppob');
$out_sosmed = getTransaction('trx_socmed');