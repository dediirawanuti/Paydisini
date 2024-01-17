<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$post_ft = isset($_POST['filter_type']) ? filter($_POST['filter_type']) : '';
$post_fv = isset($_POST['filter_value']) ? filter($_POST['filter_value']) : '';

$value = "SELECT * FROM srv_ppob WHERE type != 'pascabayar'";
if($post_ft == 'type' && !empty($post_fv)) $value .= " AND type = '$post_fv'";
if($post_ft == 'brand' && !empty($post_fv)) $value .= " AND brand = '$post_fv'";
$value .= " ORDER BY name ASC, price ASC";
$search = $call->query($value);

if($search->num_rows == 0) {
    ShennDie(['result' => false,'data' => null,'message' => 'Layanan tidak ditemukan.']);
} else {
    while($row = $search->fetch_assoc()) {
        $profit = (in_array($data_user['level'],['Admin','Premium'])) ? $row['premium'] : $row['basic'];
        $out[] = [
            'brand' => $row['brand'],
            'code' => $row['code'],
            'name' => $row['name'],
            'note' => $row['note'],
            'price' => (int)$row['price']+$profit,
            'status' => $row['status'],
            'type' => $row['type'],
        ];
    }
    ShennDie(['result' => true,'data' => $out,'message' => 'Daftar layanan berhasil didapatkan.']);
}