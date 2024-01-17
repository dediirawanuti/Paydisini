<?php
set_time_limit(240);
require '../../../connect.php';

$prov = $call->query("SELECT * FROM provider WHERE code = 'IRVAN'");
$reset = true;
$shows = isset($_GET['cjorg']) ? false : true;
if($prov->num_rows == 1) {
    $prov = $prov->fetch_assoc();
    $try = $curl->connectPost($prov['link'].'/services',['api_id' => $prov['userid'], 'api_key' => $prov['apikey']]);

    if(isset($try['status'])) {
        if($try['status'] == true) {
            if(count($try['data']) > 0) {
                for($i = 0; $i <= count($try['data'])-1; $i++) {
                    $data = $try['data'][$i];
                    $pid = $data['id'];
                    $min = $data['min'];
                    $max = $data['max'];
                    $name = $data['name'];
                    $note = $data['note'];
                    $price = $data['price'];
                    $priceb = $price * 0.20;
                    $pricep = $price * 0.15;
                    $category = $data['category'];
                    $type = $data['type'];
                    $status = $data['status'];
                    
                    if ($type == 'primary') {
                        $type = "Default";
                    } else if ($type == 'custom_comments') {
                        $type = "Custom Comments";
                    } else if ($type == 'custom_link') {
                        $tpye = "Comment Likes";
                    }
                    
                    if ($status == "1" && $category != "[-] Pembuatan Website") {

                    $check_category = $call->query("SELECT * FROM category WHERE code = '$category' AND type = 'social-media' AND `order` = 'social'");
                    $check_service = $call->query("SELECT * FROM srv_socmed WHERE pid = '$pid' AND provider = 'IRVAN'");

                    if($check_category->num_rows == 0)
                        $call->query("INSERT INTO category VALUES ('','$category','$category','social-media','social-media','social')");
                            
                    if($check_service->num_rows == 0) {
                        $call->query("INSERT INTO srv_socmed VALUES ('$pid','$pid','$category','$name','$note','$price','$priceb','$pricep','$min','$max','available','IRVAN','$date $time')");
                        if($shows == true) print '<font color="green"><pre>';
                        if($shows == true) print "[+] $name {Berhasil ditambahkan}<br>";
                        if($shows == true) print "Min: $min<br>";
                        if($shows == true) print "Max: $max<br>";
                        if($shows == true) print "Harga Pusat: $price<br>";
                        if($shows == true) print "Harga Basic: ".($price+$priceb)."<br>";
                        if($shows == true) print "Harga Premium: ".($price+$pricep)."<br>";
                        if($shows == true) print '</pre></font><hr>';
                    } else {
                        $data_service = $check_service->fetch_assoc();
                        if($data_service['price'] <> $price || $reset == true || $data_service['min'] <> $min || $data_service['max'] <> $max) {
                            $call->query("UPDATE srv_socmed SET note = '$note', price = '$price', basic = '$priceb', premium = '$pricep', min = '$min', max = '$max', date_up = '$date $time' WHERE pid = '$pid' AND provider = 'IRVAN'");
                            if($shows == true) print '<font color="green"><pre>';
                            if($shows == true) print "[+] $name {Berhasil diupdate}<br>";
                            if($shows == true) print "Min: ".$data_service['min']." -> $min<br>";
                            if($shows == true) print "Max: ".$data_service['max']." -> $max<br>";
                            if($shows == true) print "Harga Pusat: ".$data_service['price']." -> $price<br>";
                            if($shows == true) print "Harga Basic: ".($data_service['price']+$data_service['basic'])." -> ".($price+$priceb)."<br>";
                            if($shows == true) print "Harga Premium: ".($data_service['price']+$data_service['premium'])." -> ".($price+$pricep)."<br>";
                            if($shows == true) print '</pre></font><hr>';
                        } else {
                            if($shows == true) print '<font color="red"><pre>[!] '.$name.' {Data masih sama}</pre></font><hr>';
                        }
                    }
                }
            }
            } else {
                print '<font color="red"><pre>[!] No Service</pre></font>';
            }
        } else {
            print '<font color="red"><pre>[!] '.$try['message'].'</pre></font>';
        }
    } else {
        print '<font color="red"><pre>[!] Connection Failed</pre></font>';
    }
} else {
    print '<font color="red"><pre>[!] Provider not found</pre></font>';
}
?>