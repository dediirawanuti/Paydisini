<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$InvoiceCode = isset($_GET['qq']) ? filter($_GET['qq']) : '';
$search = $call->query("SELECT * FROM deposit WHERE wid = '$InvoiceCode' AND user = '$sess_username' AND payment NOT IN ('transfer','voucher')");
if($search->num_rows == false) redirect(0,base_url('deposit/history'));
$rowvoice = $search->fetch_assoc();

$payname = $call->query("SELECT * FROM deposit_payment WHERE code = '".$rowvoice['payment']."' ORDER BY name ASC LIMIT 1");
$payname = ($payname->num_rows == 1) ? $payname->fetch_assoc()['name'] : 'Unknown';
$paytotal = $rowvoice['amount']+$rowvoice['fee']+$rowvoice['uniq'];

if(isset($_POST['cancel'])) {
    $web_token = filter(base64_decode($_POST['web_token']));
    $post_password = filter($_POST['password']);
    
    $check_pin = check_bcrypt($post_password,$data_user['secure']);
    $check_password = ($check_pin == false) ? check_bcrypt($post_password,$data_user['password']) : $check_pin;
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!$web_token || !$post_password) {
        ShennXit(['type' => false,'message' => 'There is still a blank form.']);
    } else if($call->query("SELECT wid FROM deposit WHERE wid = '$web_token' AND status = 'unpaid'")->num_rows == false) {
        ShennXit(['type' => false,'message' => 'Invoice not found.']);
    } else if($check_password == false) {
        ShennXit(['type' => false,'message' => 'Invalid Security PIN or Password.']);
    } else {
        if($call->query("UPDATE deposit SET status = 'cancelled' WHERE wid = '$web_token' AND status = 'unpaid'") == true) {
            ShennXit(['type' => true,'message' => 'Deposit request canceled successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}

if (isset($_POST['confirm-bca'])) {
          if($rowvoice['method'] == 'BCA') {
          require '../mutasi/bca-class.php';
                $cek = check_bca($paytotal);
                if ($cek == "sukses") {
                    $check = true;
                } else {
                    $check = false;
                }
        }
        if ($check == false) {
        ShennXit(['type' => false,'message' => 'Dana belum kami terima.']);
        } else {
        if($rowvoice['status'] == 'paid') {
        ShennXit(['type' => true,'message' => 'Berhasil melakukan deposit, dana sudah kami tambahkan.']);
        }
        $psd = $rowvoice['amount']+$rowvoice['uniq'];
        $up = $call->query("UPDATE deposit SET status = 'paid' WHERE id = '".$rowvoice['id']."'");
        $up = $call->query("UPDATE users SET balance = balance+$psd WHERE username = '".$rowvoice['user']."'");
        if($up == true) {         
        $call->query("INSERT INTO mutation VALUES (null,'".$rowvoice['user']."','+','$psd','Deposit :: ".$rowvoice['wid']."','$date $time')");   
			ShennXit(['type' => true,'message' => 'Berhasil melakukan deposit, dana sudah kami tambahkan.']);
			} else {
				ShennXit(['type' => false,'message' => 'system 404.']);
			       }
        }
}

        	    
            
        