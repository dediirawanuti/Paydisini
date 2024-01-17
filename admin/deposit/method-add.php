<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Payment</label>
        <select class="form-control" name="method_payment">
            <option selected disabled>Select...</option>
            <?php
            $search = $call->query("SELECT * FROM deposit_payment ORDER BY name ASC");
            while($row = $search->fetch_assoc()) {
                print '<option value="'.$row['code'].'">'.$row['name'].'</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="method_name">
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Account Name</label>
            <input type="text" class="form-control" name="method_accna" placeholder="-">
        </div>
        <div class="form-group col-md-6">
            <label>Account No.</label>
            <input type="number" class="form-control" name="method_accno">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-3">
            <label>Fee Type</label>
            <select class="form-control" name="method_xfee">
                <option value="-" selected>-</option>
                <option value="%">%</option>
            </select>
        </div>
        <div class="form-group col-5">
            <label>Fee Amount</label>
            <input type="number" step="any" class="form-control" name="method_fee" value="0">
        </div>
        <div class="form-group position-relative col-4">
            <label>Rate</label>
            <fieldset class="position-relative">
                <input type="number" class="form-control" name="method_rate" value="0">
            </fieldset>
        </div>
    </div>
    <div class="form-group">
        <label>Minimal</label>
        <fieldset class="position-relative has-icon-left">
            <input type="number" class="form-control" name="method_min" value="0">
        </fieldset>
    </div>
    <div class="form-group">
        <label>Deposit Type</label>
        <select class="form-control" name="method_auto">
            <option value="0" selected>Manual</option>
            <option value="1">Automatic</option>
        </select>
    </div>
    <div class="form-group">
        <label>Payment Gateway</label>
        <select class="form-control" name="paymentgateway">
            <option value="0" selected>Manual</option>
            <option value="Paydisini">Paydisini</option>
        </select>
    </div>
    <div class="form-group">
        <label>Kode Payment Gateway</label>
        <input type="number" class="form-control" name="kodepayment" value="0">
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="method_add" class="btn btn-primary btn-block"> ADD </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>