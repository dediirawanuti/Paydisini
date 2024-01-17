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
        <label>File Name</label>
        <input type="text" class="form-control" name="nfile" placeholder="Report 1">
    </div>
    <div class="form-group">
        <label>Start Date</label>
        <input type="date" class="form-control" name="start" value="<?= $date ?>">
    </div>
    <div class="form-group">
        <label>End Date</label>
        <input type="date" class="form-control" name="end" value="<?= $date ?>">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status" id="status">
            <option value="0" selected disabled>- Select One -</option>
            <option value="cancelled">Cancelled</option>
            <option value="unpaid">Unpaid</option>
            <option value="paid">Paid</option>
            <option value="all">All Status</option>
        </select>
    </div>
    <div class="form-group">
        <label>Payment</label>
        <select class="form-control" name="payment" id="payment">
            <option value="0" selected disable> - Select One - </option>
            <?php
            $search = $call->query("SELECT code, name FROM deposit_payment ORDER BY name ASC");
            while($row = $search->fetch_assoc()) {
                print '<option value="'.$row['code'].'">'.$row['name'].'</option>';
            }
            ?>
            <option value="all">All Payment</option>
        </select>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="printOutDeposit" class="btn btn-primary btn-block"> DOWNLOAD </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>