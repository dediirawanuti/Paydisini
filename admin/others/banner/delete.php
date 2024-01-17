<?php
require '../../../connect.php';
require _DIR_('library/session/session');

$code = isset($_GET['s']) ? filter(base64_decode($_GET['s'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    if(!isset($code) || !$code) exit("No direct script access allowed!");
    $search = $call->query("SELECT * FROM information WHERE id = '$code' AND type = 'banner'");
    if($search->num_rows == 0) exit("No data found from the Code!");
    $data = $search->fetch_assoc();
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($code) ?>">
    <h4>Information</h4>
    <div style="font-size:0.8rem;display:inline;">Type<span class="justify-content-end" style="float:right;font-size:0.8rem;"><?= ucfirst($data['type']) ?></span></div><br>
    <div style="font-size:0.8rem;display:inline;">Date<span class="justify-content-end" style="float:right;font-size:0.8rem;"><?= format_date('en',$data['date']) ?></span></div>
    <hr>
    <h4>Content</h4>
    <div style="font-size:0.8rem;display:inline;">
        <img class="d-block img-fluid" src="<?= $data['content'] ?>" width="100%">
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="deletebanner" class="btn btn-primary btn-block"> DELETE </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>