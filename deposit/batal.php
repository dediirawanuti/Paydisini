<?php
require '../connect.php';
require _DIR_('library/session/session');

$TrxID = key($_GET);
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!isset($TrxID) || !$TrxID) exit("No direct script access allowed!");
    $search = $call->query("SELECT * FROM deposit WHERE wid = '$TrxID' AND user = '$sess_username' AND payment NOT IN ('transfer','voucher')");
    if($search->num_rows == 0) exit("No data found from the Request ID!");
    $data_key = $search->fetch_assoc();
    
    $payname = $call->query("SELECT * FROM deposit_payment WHERE code = '".$data_key['payment']."' ORDER BY name ASC LIMIT 1");
    $payname = ($payname->num_rows == 1) ? $payname->fetch_assoc()['name'] : 'Unknown';
    $paytotal = $data_key['amount']+$data_key['fee']+$data_key['uniq'];
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($data_key['wid']) ?>">
    <h4>Deposit Information</h4>
    <div style="font-size:0.8rem;display:inline;">Method<span class="justify-content-end" style="float:right;font-size:0.8rem;"><?= $payname ?></span></div><br>
    <div style="font-size:0.8rem;display:inline;">Transfer<span class="justify-content-end" style="float:right;font-size:0.8rem;"><?= 'Rp '.currency($paytotal) ?></span></div>
    <hr>
    <h4>Confirm Password</h4>
    <span style="font-size:0.8rem;">Are you sure you want to cancel Invoice #<?= $data_key['wid'] ?>, if you are sure please enter your PIN or Password below.</span>
    <div class="form-label-group">
        <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" data-toggle="password">
            <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-eye"></i></span>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> Close </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="cancel" class="btn btn-primary btn-block"> Cancel </button>
        </div>
    </div>
</form>
<script src="<?= assets('js/show-password.min.js') ?>"></script>
<?php
} else {
    exit("No direct script access allowed!");
}
?>