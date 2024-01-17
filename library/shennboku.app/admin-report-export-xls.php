<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(conf('addon1',3) == '') { 
    $call->query("UPDATE conf SET c3 = '".json_encode([
        'transaction' => [
            1 => ['name' => ''],                8  => ['name' => '','show' => 0],
            2 => ['name' => '','show' => 0],    9  => ['name' => '','show' => 0],
            3 => ['name' => '','show' => 0],    10 => ['name' => '','show' => 0],
            4 => ['name' => '','show' => 0],    11 => ['name' => '','show' => 0],
            5 => ['name' => '','show' => 0],    12 => ['name' => '','show' => 0],
            6 => ['name' => '','show' => 0],    13 => ['name' => '','show' => 0],
            7 => ['name' => '','show' => 0],    14 => ['name' => '','show' => 0]
        ],'deposit' => [
            1 => ['name' => ''],                7  => ['name' => '','show' => 0],
            2 => ['name' => '','show' => 0],    8  => ['name' => '','show' => 0],
            3 => ['name' => '','show' => 0],    9  => ['name' => '','show' => 0],
            4 => ['name' => '','show' => 0],    10 => ['name' => '','show' => 0],
            5 => ['name' => '','show' => 0],    11 => ['name' => '','show' => 0],
            6 => ['name' => '','show' => 0],    12 => ['name' => '','show' => 0],
    ]])."' WHERE code = 'addon1'");
    die(redirect(0,visited()));
}
$DataAddon3 = json_decode(conf('addon1',3), true);

if(isset($_POST['transaction_config'])) {
    $post_1  = filter($_POST['1']);
    $post_2  = filter($_POST['2_1']);
    $post_3  = filter($_POST['3_1']);
    $post_4  = filter($_POST['4_1']);
    $post_5  = filter($_POST['5_1']);
    $post_6  = filter($_POST['6_1']);
    $post_7  = filter($_POST['7_1']);
    $post_8  = filter($_POST['8_1']);
    $post_9  = filter($_POST['9_1']);
    $post_10 = filter($_POST['10_1']);
    $post_11 = filter($_POST['11_1']);
    $post_12 = filter($_POST['12_1']);
    $post_13 = filter($_POST['13_1']);
    $post_14 = filter($_POST['14_1']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$post_1 || !$post_2 || !$post_3 || !$post_4 || !$post_5 || !$post_6 || !$post_7 || !$post_8 || !$post_9 || !$post_10 || !$post_11 || !$post_12 || !$post_13 || !$post_14) {
        ShennXit(['type' => false,'message' => 'Transaction configuration data not detected.']);
    } else {
        $DataAddon3['transaction'] = [
            1 => ['name' => $post_1],                                           8  => ['name' => $post_8,'show' => ($_POST['8_2'] == '1') ? 1 : 0],
            2 => ['name' => $post_2,'show' => ($_POST['2_2'] == '1') ? 1 : 0],  9  => ['name' => $post_9,'show' => ($_POST['9_2'] == '1') ? 1 : 0],
            3 => ['name' => $post_3,'show' => ($_POST['3_2'] == '1') ? 1 : 0],  10 => ['name' => $post_10,'show' => ($_POST['10_2'] == '1') ? 1 : 0],
            4 => ['name' => $post_4,'show' => ($_POST['4_2'] == '1') ? 1 : 0],  11 => ['name' => $post_11,'show' => ($_POST['11_2'] == '1') ? 1 : 0],
            5 => ['name' => $post_5,'show' => ($_POST['5_2'] == '1') ? 1 : 0],  12 => ['name' => $post_12,'show' => ($_POST['12_2'] == '1') ? 1 : 0],
            6 => ['name' => $post_6,'show' => ($_POST['6_2'] == '1') ? 1 : 0],  13 => ['name' => $post_13,'show' => ($_POST['13_2'] == '1') ? 1 : 0],
            7 => ['name' => $post_7,'show' => ($_POST['7_2'] == '1') ? 1 : 0],  14 => ['name' => $post_14,'show' => ($_POST['14_2'] == '1') ? 1 : 0]
        ];
        
        if($call->query("UPDATE conf SET c3 = '".json_encode($DataAddon3)."' WHERE code = 'addon1'") == true) {
            ShennXit(['type' => true,'message' => 'Transaction configuration updated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}


if(isset($_POST['deposit_config'])) {
    $post_1  = filter($_POST['1']);
    $post_2  = filter($_POST['2_1']);
    $post_3  = filter($_POST['3_1']);
    $post_4  = filter($_POST['4_1']);
    $post_5  = filter($_POST['5_1']);
    $post_6  = filter($_POST['6_1']);
    $post_7  = filter($_POST['7_1']);
    $post_8  = filter($_POST['8_1']);
    $post_9  = filter($_POST['9_1']);
    $post_10 = filter($_POST['10_1']);
    $post_11 = filter($_POST['11_1']);
    $post_12 = filter($_POST['12_1']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$post_1 || !$post_2 || !$post_3 || !$post_4 || !$post_5 || !$post_6 || !$post_7 || !$post_8 || !$post_9 || !$post_10 || !$post_11 || !$post_12) {
        ShennXit(['type' => false,'message' => 'Deposit configuration data not detected.']);
    } else {
        $DataAddon3['deposit'] = [
            1 => ['name' => $post_1],                                           7  => ['name' => $post_7,'show' => ($_POST['7_2'] == '1') ? 1 : 0],
            2 => ['name' => $post_2,'show' => ($_POST['2_2'] == '1') ? 1 : 0],  8  => ['name' => $post_8,'show' => ($_POST['8_2'] == '1') ? 1 : 0],
            3 => ['name' => $post_3,'show' => ($_POST['3_2'] == '1') ? 1 : 0],  9  => ['name' => $post_9,'show' => ($_POST['9_2'] == '1') ? 1 : 0],
            4 => ['name' => $post_4,'show' => ($_POST['4_2'] == '1') ? 1 : 0],  10 => ['name' => $post_10,'show' => ($_POST['10_2'] == '1') ? 1 : 0],
            5 => ['name' => $post_5,'show' => ($_POST['5_2'] == '1') ? 1 : 0],  11 => ['name' => $post_11,'show' => ($_POST['11_2'] == '1') ? 1 : 0],
            6 => ['name' => $post_6,'show' => ($_POST['6_2'] == '1') ? 1 : 0],  12 => ['name' => $post_11,'show' => ($_POST['12_2'] == '1') ? 1 : 0],
        ];
        
        if($call->query("UPDATE conf SET c3 = '".json_encode($DataAddon3)."' WHERE code = 'addon1'") == true) {
            ShennXit(['type' => true,'message' => 'Deposit configuration updated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}

if(isset($_POST['printOutTransaction'])) {
    require _DIR_('library/function/XLSXWriter');
    $filename = explode('.',filter($_POST['nfile']))[0];
    $date_start = filter($_POST['start']);
    $date_end = filter($_POST['end']);
    $status = in_array($_POST['status'],['error','partial','pending','processing','success']) ? $_POST['status'] : 'all';
    $provider = ($call->query("SELECT code FROM provider WHERE code = '".filter($_POST['provider'])."'")->num_rows == 1) ? filter($_POST['provider']) : 'all';
    $filter = ($date_start == $date_end) ? "date_cr LIKE '$date_end%'" : ((strtotime($date_end) < strtotime($date_start)) ? "date_cr LIKE '$date%'" : "DATE(date_cr) BETWEEN '$date_start' AND '$date_end'");
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!in_array($_POST['type'],['trx_game','trx_ppob','trx_socmed'])) {
        ShennXit(['type' => false,'message' => 'Type not valid.']);
    } else if(!$filename) {
        ShennXit(['type' => false,'message' => 'File name not valid.']);
    } else {
        $statusd = ($status == 'all') ? '' : "AND status = '$status'";
        $providerd = ($provider == 'all') ? '' : "AND provider = '$provider'";
        $search = $call->query("SELECT * FROM ".$_POST['type']." WHERE $filter $statusd $providerd");
        if($search->num_rows > 0) {
            $filename = $filename.'.xlsx';
            for ($i = 2; $i < 15; $i++) {
                if($DataAddon3['transaction'][$i]['name'] != '' && $DataAddon3['transaction'][$i]['show'] == 1) {
                    $out_thead[] = $DataAddon3['transaction'][$i]['name'];
                    $out_twidth[] = strtr($i,[2=>10,3=>20,4=>20,5=>20,6=>50,7=>40,8=>60,9=>20,10=>20,11=>10,12=>20,13=>20,14=>20]);
                    $out_thead1[$DataAddon3['transaction'][$i]['name']] = strtr($i,[2=>'0',3=>'0',4=>'@',5=>'@',6=>'@',7=>'@',8=>'@',9=>'Rp #,##0',10=>'Rp #,##0',11=>'@',12=>'@',13=>'@',14=>'@']);
                }
            }

            if(count($out_thead) == 0) {
                ShennXit(['type' => false,'message' => 'All data is hidden.']);
            } else {
                $ShennX = 1;
                while($row = $search->fetch_assoc()) {
                    $srcProv = $call->query("SELECT name FROM provider WHERE code = '".$row['provider']."'");
                    if($DataAddon3['transaction']['2']['show'] == 1) $dfx[$ShennX][] = $row['id'];
                    if($DataAddon3['transaction']['3']['show'] == 1) $dfx[$ShennX][] = $row['wid'];
                    if($DataAddon3['transaction']['4']['show'] == 1) $dfx[$ShennX][] = $row['tid'];
                    if($DataAddon3['transaction']['5']['show'] == 1) $dfx[$ShennX][] = $row['user'];
                    if($DataAddon3['transaction']['6']['show'] == 1) $dfx[$ShennX][] = $row['name'];
                    if($DataAddon3['transaction']['7']['show'] == 1) $dfx[$ShennX][] = $row['data'];
                    if($DataAddon3['transaction']['8']['show'] == 1) $dfx[$ShennX][] = $row['note'];
                    if($DataAddon3['transaction']['9']['show'] == 1) $dfx[$ShennX][] = $row['price'];
                    if($DataAddon3['transaction']['10']['show'] == 1) $dfx[$ShennX][] = $row['profit'];
                    if($DataAddon3['transaction']['11']['show'] == 1) $dfx[$ShennX][] = ucfirst($row['status']);
                    if($DataAddon3['transaction']['12']['show'] == 1) $dfx[$ShennX][] = $row['date_cr'];
                    if($DataAddon3['transaction']['13']['show'] == 1) $dfx[$ShennX][] = $row['date_up'];
                    if($DataAddon3['transaction']['14']['show'] == 1) $dfx[$ShennX][] = ($srcProv->num_rows == 1) ? $srcProv->fetch_assoc()['name'] : $row['provider'];
                    $datafield[] = $dfx[$ShennX];
                    $ShennX++;
                }
                
                $writer = new XLSXWriter();
                $writer->setTitle(str_replace('.xlsx','',XLSXWriter::sanitize_filename($filename)));
                $writer->setSubject('Transaction Data');
                $writer->setAuthor($DataAddon3['transaction']['1']['name']);
                $writer->setCompany('@ShennBoku');
                $writer->setDescription('Created automatically by the ShennX system programmed by ShennBoku.');
                $writer->writeSheetHeader('ShennX1', $out_thead1, $col_options = ['widths'=>$out_twidth, 'suppress_row' => 1]);
                $writer->writeSheetRow('ShennX1', $out_thead, ['font-style' => 'bold','halign' => 'center','fill' => '#eee']);
                foreach($datafield as $row) $writer->writeSheetRow('ShennX1', $row);
                header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
                header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                header('Content-Transfer-Encoding: binary');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                $writer->writeToStdOut();
                ShennXit();
            }
        } else {
            ShennXit(['type' => false,'message' => 'Transaction data is not available.']);
        }
    }
}

if(isset($_POST['printOutDeposit'])) {
    require _DIR_('library/function/XLSXWriter');
    $filename = explode('.',filter($_POST['nfile']))[0];
    $date_start = filter($_POST['start']);
    $date_end = filter($_POST['end']);
    $status = in_array($_POST['status'],['cancelled','unpaid','paid']) ? $_POST['status'] : 'all';
    $provider = ($call->query("SELECT code FROM deposit_payment WHERE code = '".filter($_POST['payment'])."'")->num_rows == 1) ? filter($_POST['payment']) : 'all';
    $filter = ($date_start == $date_end) ? "date LIKE '$date_end%'" : ((strtotime($date_end) < strtotime($date_start)) ? "date LIKE '$date%'" : "DATE(date) BETWEEN '$date_start' AND '$date_end'");
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$filename) {
        ShennXit(['type' => false,'message' => 'File name not valid.']);
    } else {
        $statusd = ($status == 'all') ? '' : "AND status = '$status'";
        $providerd = ($provider == 'all') ? '' : "AND payment = '$provider'";
        $search = $call->query("SELECT * FROM deposit WHERE $filter $statusd $providerd");
        if($search->num_rows > 0) {
            $filename = $filename.'.xlsx';
            for ($i = 2; $i < 13; $i++) {
                if($DataAddon3['deposit'][$i]['name'] != '' && $DataAddon3['deposit'][$i]['show'] == 1) {
                    $out_thead[] = $DataAddon3['deposit'][$i]['name'];
                    $out_twidth[] = strtr($i,[2=>10,3=>20,4=>20,5=>30,6=>40,7=>60,8=>20,9=>20,10=>20,11=>10,12=>20]);
                    $out_thead1[$DataAddon3['deposit'][$i]['name']] = strtr($i,[2=>'0',3=>'0',4=>'@',5=>'@',6=>'@',7=>'@',8=>'@',9=>'Rp #,##0',10=>'Rp #,##0',11=>'@',12=>'@']);
                }
            }

            if(count($out_thead) == 0) {
                ShennXit(['type' => false,'message' => 'All data is hidden.']);
            } else {
                $ShennX = 1;
                while($row = $search->fetch_assoc()) {
                    $srcProv = $call->query("SELECT name FROM deposit_payment WHERE code = '".$row['payment']."'");
                    if($DataAddon3['deposit']['2']['show'] == 1) $dfx[$ShennX][] = $row['id'];
                    if($DataAddon3['deposit']['3']['show'] == 1) $dfx[$ShennX][] = $row['wid'];
                    if($DataAddon3['deposit']['4']['show'] == 1) $dfx[$ShennX][] = $row['user'];
                    if($DataAddon3['deposit']['5']['show'] == 1) $dfx[$ShennX][] = ($srcProv->num_rows == 1) ? $srcProv->fetch_assoc()['name'] : ucfirst($row['payment']);
                    if($DataAddon3['deposit']['6']['show'] == 1) $dfx[$ShennX][] = $row['method'];
                    if($DataAddon3['deposit']['7']['show'] == 1) $dfx[$ShennX][] = $row['note'];
                    if($DataAddon3['deposit']['8']['show'] == 1) $dfx[$ShennX][] = $row['sender'];
                    if($DataAddon3['deposit']['9']['show'] == 1) $dfx[$ShennX][] = $row['amount']+$row['uniq'];
                    if($DataAddon3['deposit']['10']['show'] == 1) $dfx[$ShennX][] = $row['fee'];
                    if($DataAddon3['deposit']['11']['show'] == 1) $dfx[$ShennX][] = ucfirst($row['status']);
                    if($DataAddon3['deposit']['12']['show'] == 1) $dfx[$ShennX][] = $row['date'];
                    $datafield[] = $dfx[$ShennX];
                    $ShennX++;
                }
                
                $writer = new XLSXWriter();
                $writer->setTitle(str_replace('.xlsx','',XLSXWriter::sanitize_filename($filename)));
                $writer->setSubject('Deposit Data');
                $writer->setAuthor($DataAddon3['deposit']['1']['name']);
                $writer->setCompany('@ShennBoku');
                $writer->setDescription('Created automatically by the ShennX system programmed by ShennBoku.');
                $writer->writeSheetHeader('ShennX1', $out_thead1, $col_options = ['widths'=>$out_twidth, 'suppress_row' => 1]);
                $writer->writeSheetRow('ShennX1', $out_thead, ['font-style' => 'bold','halign' => 'center','fill' => '#eee']);
                foreach($datafield as $row) $writer->writeSheetRow('ShennX1', $row);
                header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
                header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                header('Content-Transfer-Encoding: binary');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                $writer->writeToStdOut();
                ShennXit();
            }
        } else {
            ShennXit(['type' => false,'message' => 'Transaction data is not available.']);
        }
    }
}