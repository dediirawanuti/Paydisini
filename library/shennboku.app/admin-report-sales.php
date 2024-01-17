<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");

$data = isset($_GET['data']) ? filter($_GET['data']) : date('Y-m');
$data = (strtotime($data) > strtotime(date('Y-m'))) ? date('Y-m') : $data;
$status = isset($_GET['status']) ? (in_array($_GET['status'],['error','partial','waiting','processing','success']) ? $_GET['status'] : 'All') : 'All';
$dbstatus = ($status != 'All') ? "AND status = '$status'" : '';

function getTransaction($from) {
    global $call, $data, $dbstatus;
    $search = $call->query("SELECT * FROM $from WHERE date_cr LIKE '$data-%' $dbstatus ORDER BY date_cr ASC");
    if($search->num_rows > 0) {
        while($row = $search->fetch_assoc()) {
            $tgl = explode(' ',$row['date_cr'])[0];
            $out[$tgl]['total'] += 1;
            $out[$tgl]['price'] += $row['price'];
            $out[$tgl]['profit'] += $row['profit'];
        }
        return $out;
    }
    return [];
}

$out_game = getTransaction('trx_game');
$out_pulsa = getTransaction('trx_ppob');
$out_sosmed = getTransaction('trx_socmed');