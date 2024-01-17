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
    <div class="form-group">
        <label>Code</label>
        <input type="text" class="form-control" name="category_code" value="<?= $data['code'] ?>" disabled>
    </div>
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="category_name" value="<?= $data['name'] ?>">
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="category_edit" class="btn btn-primary btn-block"> EDIT </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>