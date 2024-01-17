<?php
require '../../connect.php';
require _DIR_('library/session/session');

$code = isset($_GET['s']) ? filter(base64_decode($_GET['s'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    if(!isset($code) || !$code) exit("No direct script access allowed!");
    $search = $call->query("SELECT * FROM deposit_method WHERE id = '$code'");
    if($search->num_rows == 0) exit("No data found from the Code!");
    $data = $search->fetch_assoc();
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($code) ?>">
    <div class="form-group">
        <label>Payment</label>
        <select class="form-control" name="method_payment">
            <?php
            $search1 = $call->query("SELECT * FROM deposit_payment ORDER BY name ASC");
            while($row1 = $search1->fetch_assoc()) {
                print select_opt($data['method'],$row1['code'],$row1['name']);
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="method_name" value="<?= $data['name'] ?>">
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Account Name</label>
            <input type="text" class="form-control" name="method_accna" placeholder="-" value="<?= explode(' A/n ',$data['data'])[1] ?>">
        </div>
        <div class="form-group col-md-6">
            <label>Account No.</label>
            <input type="number" class="form-control" name="method_accno" value="<?= explode(' A/n ',$data['data'])[0] ?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-3">
            <label>Fee Type</label>
            <select class="form-control" name="method_xfee">
                <?= select_opt($data['xfee'],'-','-') ?>
                <?= select_opt($data['xfee'],'%','%') ?>
            </select>
        </div>
        <div class="form-group col-5">
            <label>Fee Amount</label>
            <input type="number" step="any" class="form-control" name="method_fee" value="<?= ($data['xfee'] == '-') ? $data['fee'] : $data['fee']*100 ?>">
        </div>
        <div class="form-group position-relative col-4">
            <label>Rate</label>
            <fieldset class="position-relative">
                <input type="number" step="any" class="form-control" name="method_rate" value="<?= $data['rate']*100 ?>">
            </fieldset>
        </div>
    </div>
    <div class="form-group">
        <label>Minimal</label>
        <fieldset class="position-relative has-icon-left">
            <input type="number" class="form-control" name="method_min" value="<?= $data['min'] ?>">
        </fieldset>
    </div>
    <div class="form-group">
        <label>Deposit Type</label>
        <select class="form-control" name="method_auto">
            <?= select_opt($data['auto'],'0','Manual') ?>
            <?= select_opt($data['auto'],'1','Automatic') ?>
        </select>
    </div>
     <div class="form-group">
        <label>Payment Gateway</label>
        <select class="form-control" name="paymentgateway">
            <option value="0" selected>Manual</option>
            <?= select_opt($data['payment_gateway'],'Paydisini','Paydisini') ?>
        </select>
    </div>
    <div class="form-group">
        <label>Kode Payment Gateway</label>
        <input type="number" class="form-control" name="kodepayment" value="<?= $data['kodepayment'] ?>">
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="method_edit" class="btn btn-primary btn-block"> EDIT </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>