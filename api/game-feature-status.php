<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$post_t = isset($_POST['trxid']) ? filter($_POST['trxid']) : '';
$post_l = isset($_POST['limit']) ? (is_numeric($_POST['limit']) ? 'LIMIT '.$_POST['limit'] : '') : '';

$value = "SELECT * FROM trx_game WHERE user = '$username'";
if(!empty($post_t)) $value .= " AND wid = '$post_t'";
$value .= " ORDER BY id DESC $post_l";
$search = $call->query($value);

if($search->num_rows == 0) {
    ShennDie(['result' => false,'data' => null,'message' => 'Transaksi tidak ditemukan.']);
} else {
    while($row = $search->fetch_assoc()) {
        $out[] = [
            'trxid' => $row['wid'],
            'data' => $row['data'],
            'zone' => $row['zone'],
            'service' => $row['name'],
            'status' => $row['status'],
            'note' => $row['note'],
            'price' => (int)$row['price'],
        ];
    }
    ShennDie(['result' => true,'data' => $out,'message' => 'Detail transaksi berhasil didapatkan.']);
}