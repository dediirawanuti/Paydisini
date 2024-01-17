<?php
require '../../connect.php';
require _DIR_('library/session/session');

$code = isset($_GET['s']) ? filter($_GET['s']) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!isset($code) || !$code) exit('No direct script access allowed!');
    $search = $call->query("SELECT * FROM trx_socmed WHERE wid = '$code'");
    if($search->num_rows == 0) exit('No transaction found from the Code!');
    $data = $search->fetch_assoc();
    
    $ShennConfirm = 'Social Media';
    require _DIR_('library/shennboku.app/admin-transaction');
?>
<div id="sess-result-modal"></div>
<form method="POST" id="form-edit">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($code) ?>">
    <div class="form-group">
        <label>Start Count</label>
        <input type="number" class="form-control" name="trx_count" value="<?= $data['count'] ?>">
    </div>
    <div class="form-group">
        <label>Remains</label>
        <input type="number" class="form-control" name="trx_remain" value="<?= $data['remain'] ?>">
    </div>
    <div class="form-group">
        <label>Note</label>
        <textarea class="form-control" name="trx_note"><?= $data['note'] ?></textarea>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="button" onclick="ShennAct('#form-edit','<?= base_url('admin/social-media/transaction-edit?s='.$code) ?>');" class="btn btn-primary btn-block"> EDIT </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>