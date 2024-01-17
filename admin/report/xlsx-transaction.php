<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user) && isset($_GET['d'])) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    if(!in_array($_GET['d'],['trx_game','trx_ppob','trx_socmed'])) exit("No direct script access allowed!");
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="type" name="type" value="<?= $_GET['d'] ?>">
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
            <option value="error">Error</option>
            <? if($_GET['d'] == 'trx_socmed') { ?>
            <option value="partial">Partial</option>
            <? } ?>
            <option value="waiting">Waiting</option>
            <? if($_GET['d'] == 'trx_socmed') { ?>
            <option value="processing">Processing</option>
            <? } ?>
            <option value="success">Success</option>
            <option value="all">All Status</option>
        </select>
    </div>
    <div class="form-group">
        <label>Provider</label>
        <select class="form-control" name="provider" id="provider">
            <option value="0" selected disable> - Select One - </option>
            <?php
            $search = $call->query("SELECT code, name FROM provider ORDER BY name ASC");
            while($row = $search->fetch_assoc()) {
                print '<option value="'.$row['code'].'">'.$row['name'].'</option>';
            }
            ?>
            <option value="all">All Provider</option>
        </select>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="printOutTransaction" class="btn btn-primary btn-block"> DOWNLOAD </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>