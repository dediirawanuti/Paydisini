<?php
function mailer($config,$data) {
	include 'class.phpmailer.php';
    /* Formar $config = [
    	'host' => 'mail.shenn.id',
    	'user' => 'support@shenn.id',
    	'pass' => 'AndaKepoYaaa',
    	'from' => 'Shenn Support',
    ];
    */

    /* Formar $data = [
    	'dest' => 'business.afdhalul@gmail.com',
    	'name' => 'Afdhalul Ichsan Y',
    	'subject' => 'Shenn Register',
    	'message' => 'Terima kasih telah mendaftar',
    	'is_template' => 'no', // jika yes, base64_encode terlebih dahulu message nya
    ];
    */

    if(!$config['host'] || !$config['user'] || !$config['pass'] || !$config['from']) {
    	return false;
    } else if(!$data['dest'] || !$data['name'] || !$data['subject'] || !$data['message'] || !in_array($data['is_template'], ['yes','no'])) {
    	return false;
    } else {
    	$mail = new PHPMailer;
    	$mail->IsSMTP();
    	$mail->SMTPSecure = 'ssl';
    	$mail->Host = $config['host'];
    	$mail->SMTPDebug = 0;
    	$mail->Port = 465;
    	$mail->SMTPAuth = true;
    	$mail->Username = $config['user'];
    	$mail->Password = $config['pass'];
    	$mail->SetFrom($config['user'],$config['from']);
    	$mail->Subject = $data['subject'];
    	$mail->AddAddress($data['dest'],$data['name']);
    	if($data['is_template'] == 'yes') $mail->MsgHTML(base64_decode($data['message']));
    	else $mail->MsgHTML($data['message']);
    	return ($mail->Send()) ? true : false;
    }
}