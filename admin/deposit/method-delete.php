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
    <table style="font-size:0.8rem;border-collapse:separate;border-spacing:1px;">
        <tbody>
            <tr>
                <td>Method</td>
                <td>:</td>
                <td><?= squery("SELECT name FROM deposit_payment WHERE code = '".$data['method']."'")->fetch_assoc()['name'] ?></td>
            </tr>
            <tr>
                <td>Name</td>
                <td>:</td>
                <td><?= $data['name'] ?></td>
            </tr>
            <tr>
                <td>Data</td>
                <td>:</td>
                <td><?= $data['data'] ?></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="method_delete" class="btn btn-primary btn-block"> DELETE </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>