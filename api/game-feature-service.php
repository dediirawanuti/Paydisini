<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$post_ft = isset($_POST['filter_type']) ? filter($_POST['filter_type']) : '';
$post_fv = isset($_POST['filter_value']) ? filter($_POST['filter_value']) : '';

$value = "SELECT * FROM srv_game";
if($post_ft == 'game' && !empty($post_fv)) $value .= " WHERE game = '$post_fv'";
$value .= " ORDER BY game ASC, price ASC";
$search = $call->query($value);

if($search->num_rows == 0) {
    ShennDie(['result' => false,'data' => null,'message' => 'Layanan tidak ditemukan.']);
} else {
    while($row = $search->fetch_assoc()) {
        $profit = (in_array($data_user['level'],['Admin','Premium'])) ? $row['premium'] : $row['basic'];
        $out[] = [
            'code' => $row['code'],
            'game' => $row['game'],
            'name' => $row['name'],
            'price' => (int)$row['price']+$profit,
            'server' => $row['server'],
            'status' => $row['status'],
        ];
    }
    ShennDie(['result' => true,'data' => $out,'message' => 'Daftar layanan berhasil didapatkan.']);
}