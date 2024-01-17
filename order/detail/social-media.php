<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_tid = (isset($_GET['id'])) ? filter($_GET['id']) : '';
$get_req = (isset($_GET['req'])) ? $_GET['req'] : 'Member';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if(!$get_tid) exit('No direct script access allowed!');
    
    $search = $call->query("SELECT * FROM trx_socmed WHERE wid = '$get_tid'");
    if($search->num_rows == 1) {
        $row = $search->fetch_assoc();

        if($row['status'] == 'error') $get_ic = '<i class="far fa-times-circle text-danger mr-1"></i>';
        if($row['status'] == 'partial') $get_ic = '<i class="far fa-dot-circle text-danger mr-1"></i>';
        if($row['status'] == 'waiting') $get_ic = '<i class="fas fa-circle-notch fa-spin text-warning mr-1"></i>';
        if($row['status'] == 'processing') $get_ic = '<i class="fas fa-circle-notch fa-spin text-info mr-1"></i>';
        if($row['status'] == 'success') $get_ic = '<i class="far fa-check-circle text-success mr-1"></i>';
        $get_ic .= ucfirst($row['status']);
        if($row['refund'] == '1') $get_ic .= ' - Refunded!';
        
        $get_place = '<i class="fas fa-globe-asia mr-1" style="color:#0e90b8;background-color:#077e4e;border-radius:50%;"></i>Website';
        $get_placeIP = (isset(explode(',',$row['trxfrom'])[1])) ? explode(',',$row['trxfrom'])[1] : 'API';
        $get_placeWA = (isset(explode(',',$row['trxfrom'])[1])) ? explode(',',$row['trxfrom'])[1] : 'WhatsApp';
        if(preg_split("/\,/", $row['trxfrom'])[0] == 'API') $get_place = '<i class="fas fa-rss mr-1" style="color:#ee802f"></i>'.$get_placeIP;
        if(preg_split("/\,/", $row['trxfrom'])[0] == 'LINE') $get_place = '<i class="fab fa-line mr-1" style="color:#00b900"></i>LINE';
        if(preg_split("/\,/", $row['trxfrom'])[0] == 'WHATSAPP') $get_place = '<i class="fab fa-whatsapp mr-1" style="color:#25d366;"></i>'.$get_placeWA;
        if(preg_split("/\,/", $row['trxfrom'])[0] == 'TELEGRAM') $get_place = '<i class="fab fa-telegram-plane mr-1" style="color:#0088cc"></i>Telegram';
        ?>
        <div class="table-responsive">
            <table class="table table-bordered" style="border:1px solid #dee2e6;">
                <tbody>
                    <? if($data_user['level'] == 'Admin' && $get_req == 'Admin') { ?>
                    <tr><th>ID</th><td><?= $row['wid'] ?></td></tr>
                    <tr><th>User</th><td><?= $row['user'] ?></td></tr>
                    <tr><th>Service</th><td><?= $row['name'] ?></td></tr>
                    <tr><th>Data</th><td><?= $row['data'] ?></td></tr>
                    <tr><th>Note</th><td><?= nl2br($row['note']) ?></td></tr>
                    <tr><th>Order Amount</th><td><?= currency($row['amount']) ?></td></tr>
                    <tr><th>Price</th><td><?= 'Rp '.currency($row['price']) ?></td></tr>
                    <tr><th>Profit</th><td><?= 'Rp '.currency($row['profit']) ?></td></tr>
                    <tr><th>Start Count</th><td><?= currency($row['count']) ?></td></tr>
                    <tr><th>Remains</th><td><?= currency($row['remain']) ?></td></tr>
                    <tr><th>Status</th><td><?= $get_ic ?></tr>
                    <tr><th>Provider Name</th><td><?= $call->query("SELECT * FROM provider WHERE code = '".$row['provider']."'")->fetch_assoc()['name'] ?></td></tr>
                    <tr><th>Provider TrxID</th><td><?= $row['tid'] ?></td></tr>
                    <tr><th>Place From</th><td><?= $get_place ?></td></tr>
                    <tr><th>Order Date</th><td><?= format_date('en',$row['date_cr']) ?></td></tr>
                    <tr><th>Last Update</th><td><?= format_date('en',$row['date_up']) ?></td></tr>
                    <tr><th>Process</th><td><?= timeProcess($row['date_cr'],$row['date_up']) ?></td></tr>
                    <? ################################################################### ?>
                    <? } else { ?>
                    <? ################################################################### ?>
                    <tr><th>ID</th><td><?= $row['wid'] ?></td></tr>
                    <tr><th>Service</th><td><?= $row['name'] ?></td></tr>
                    <tr><th>Data</th><td><?= $row['data'] ?></td></tr>
                    <tr><th>Note</th><td><?= nl2br($row['note']) ?></td></tr>
                    <tr><th>Order Amount</th><td><?= currency($row['amount']) ?></td></tr>
                    <tr><th>Price</th><td><?= 'Rp '.currency($row['price']) ?></td></tr>
                    <tr><th>Start Count</th><td><?= currency($row['count']) ?></td></tr>
                    <tr><th>Remains</th><td><?= currency($row['remain']) ?></td></tr>
                    <tr><th>Status</th><td><?= $get_ic ?></tr>
                    <tr><th>Place From</th><td><?= $get_place ?></td></tr>
                    <tr><th>Order Date</th><td><?= format_date('en',$row['date_cr']) ?></td></tr>
                    <tr><th>Last Update</th><td><?= format_date('en',$row['date_up']) ?></td></tr>
                    <tr><th>Process</th><td><?= timeProcess($row['date_cr'],$row['date_up']) ?></td></tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
    <?php } else { exit('#'.$get_tid.' not found'); }
} else {
    exit('No direct script access allowed!');
}