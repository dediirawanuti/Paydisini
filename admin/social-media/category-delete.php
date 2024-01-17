<?php
require '../../connect.php';
require _DIR_('library/session/session');

$code = isset($_GET['s']) ? filter(base64_decode($_GET['s'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    if(!isset($code) || !$code) exit("No direct script access allowed!");
    $search = $call->query("SELECT * FROM category WHERE id = '$code' AND `order` = 'social'");
    if($search->num_rows == 0) exit("No data found from the Code!");
    $data = $search->fetch_assoc();
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($code) ?>">
    <h4>Information</h4>
    <div style="font-size:0.8rem;display:inline;">Code<span class="justify-content-end" style="float:right;font-size:0.8rem;"><?= $data['code'] ?></span></div><br>
    <div style="font-size:0.8rem;display:inline;">Name<span class="justify-content-end" style="float:right;font-size:0.8rem;"><?= $data['name'] ?></span></div>
    <hr>
    <? if($call->query("SELECT id FROM srv_socmed WHERE cid = '".$data['code']."'")->num_rows > 0) { ?>
    <h4>Detail</h4>
    <div style="font-size:0.8rem;display:inline;">
        Kategori ini mempunyai <?= currency($call->query("SELECT id FROM srv_socmed WHERE cid = '".$data['code']."'")->num_rows) ?> layanan, apakah anda ingin menghapusnya juga?
        Jika iya, silahkan centang check box dibawah ini.
    </div>
    <br>
    <div class="form-label-group">
        <div class="vs-checkbox-con vs-checkbox-primary">
            <input type="checkbox" name="category_delete_service" value="true">
            <span class="vs-checkbox vs-checkbox-sm">
                <span class="vs-checkbox--check">
                    <i class="vs-icon feather icon-check"></i>
                </span>
            </span>
            <span>Delete Service</span>
        </div>
    </div>
    <hr>
    <? } ?>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="category_delete" class="btn btn-primary btn-block"> DELETE </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>