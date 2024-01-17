<?php
require '../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['code']) ? filter($_GET['code']) : '';
$get_data = isset($_GET['data']) ? filter($_GET['data']) : '';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!$get_code || !$get_data) exit('No direct script access allowed!');
    if($call->query("SELECT * FROM srv_ppob WHERE code = '$get_code' AND status = 'available'")->num_rows == false) exit('Service not found.');
    $row = $call->query("SELECT * FROM srv_ppob WHERE code = '$get_code' AND status = 'available'")->fetch_assoc();
    $ShennTRX = date('YmdHis').random_number(2);
    $web_token = $row['code'];
    $tgt_token = str_replace('SHENN','',$get_data);
    $provider = $row['provider'];
    $priceDB = (in_array($data_user['level'],['Premium','Admin'])) ? $row['price'] + $row['premium'] : $row['price'] + $row['basic'];
    
    $out_res = false;
    $out_msg = 'Connection not Found';
    require _DIR_('library/shennboku.app/order-postpaid-invcurl');

    //$try = ['result' => true,'data' => ['price' => 1,'customer_name' => 'ALVIN YOURDAN','customer_no' => '0000166387601']];
    if($out_res == true) {
        $bills = $out_bills; // Tagihan Customer
        $price = $bills + $priceDB; // Tagihan + Biaya + Pajak / Total yang harus dibayar customer
        $cname = $out_name; // Nama Customer
        $cnomr = $out_no; // Nomer Customer / Pelanggan
        $note = ($data_user['balance'] < $price) ?
            '<small class="text-danger">Saldo Anda tidak cukup untuk melakukan pembelian ini, sisa saldo Anda adalah Rp '.currency($data_user['balance']).'</small>' :
                '<small class="text-success">Sisa saldo Anda Rp '.currency($data_user['balance']).'</small>';
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
    <input type="hidden" id="tgt_token" name="tgt_token" value="<?= base64_encode($tgt_token) ?>">
    <input type="hidden" id="json_token" name="json_token" value="<?= base64_encode(json_encode([$bills,$cname,$cnomr])) ?>">
    
    <h5>Reciver Detail</h5>
    <div class="row">
        <div class="form-group col-md-6 col-12">
            <label>No.</label>
            <div class="form-control" style="height:auto !important;font-size:0.8rem;"><?= $tgt_token ?></div>
        </div>
        <div class="form-group col-md-6 col-12">
            <label>Name</label>
            <div class="form-control" style="height:auto !important;font-size:0.8rem;"><?= $cname ?></div>
        </div>
    </div>
    
    <hr>
    <h5>Purchase Detail</h5>
    <div class="row">
        <div class="form-group col-md-6 col-12">
            <label>Name</label>
            <div class="form-control" style="height:auto !important;font-size:0.8rem;"><?= $row['name'] ?></div>
        </div>
        <div class="form-group col-md-6 col-12">
            <label>Bills</label>
            <div class="form-control" style="height:auto !important;font-size:0.8rem;"><?= 'Rp '.currency($bills) ?></div>
        </div>
    </div>
    
    <hr>
    <h5>Payment Detail</h5>
    <div class="row">
        <div class="form-group col-md-6 col-12">
            <label>Total</label>
            <div class="form-control" style="height:auto !important;font-size:0.8rem;"><?= 'Rp '.currency($price) ?></div>
        </div>
        <div class="form-group col-md-6 col-12">
            <label><?= $_CONFIG['navbar']; ?> Cash</label>
            <div class="form-control" style="height:auto !important;font-size:0.8rem;"><?= $note ?></div>
        </div>
    </div>
    
    <? if($data_user['balance'] >= $price) { ?>
    <div class="form-label-group">
        <div class="input-group">
            <input type="password" inputmode="numeric" class="form-control" id="password" name="pin" data-toggle="password" maxlength="6" minlength="6" placeholder="Two-Factor Authorization (PIN/2FA)">
            <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-eye"></i></span>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" id="actionbutton" name="order" class="btn btn-primary btn-block"> SUBMIT </button>
            <div id="timerdiv" style="display:none;"></div>
        </div>
    </div>
    <? } else { ?>
    <hr>
    <div class="row">
        <div class="form-group col-12">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
    </div>
    <? } ?>
</form>
<script src="<?= assets('js/show-password.min.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#actionbutton").click(function() {
            $("#actionbutton").hide();
            $("#timerdiv").show(); 
            var timer = 10;     
            function counting(){
                var rto = setTimeout(counting,1000);
                $('#timerdiv').html( '<button type="button" class="btn btn-primary btn-block btn-disabled"> Processing </button>' );
                timer--;
                if(timer < 0) {
                    clearTimeout(rto);
                    timer = 10;
                    $("#timerdiv").hide();             
                    $("#actionbutton").show();
                }
            }
            counting();
         });
    });
</script>
<?php
    } else {
        exit($out_msg);
    }
} else {
    exit("No direct script access allowed!");
}
?>