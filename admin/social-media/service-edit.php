<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_id = (isset($_GET['id'])) ? $_GET['id'] : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    $search = $call->query("SELECT * FROM srv_socmed WHERE id = '$get_id'");
    if($search->num_rows == 0) exit("No data found from the Code!");
    $row = $search->fetch_assoc();
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_id) ?>">
    <div class="row">
        <div class="form-group col-7">
            <label>Provider</label>
            <select class="form-control" name="provider_name">
                <?php
                $s = $call->query("SELECT code, name FROM provider ORDER BY name ASC");
                while($r = $s->fetch_assoc()) {
                    print select_opt($row['provider'], $r['code'], $r['name']);
                }
                ?>
            </select>
        </div>
        <div class="form-group col-5">
            <label>P. ID</label>
            <input type="text" class="form-control" name="provider_id" value="<?= $row['pid'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label>Category</label>
        <select class="form-control" name="category">
            <?php
            $s = $call->query("SELECT code, name FROM category WHERE `order` = 'social' ORDER BY name ASC");
            while($r = $s->fetch_assoc()) {
                print select_opt($row['cid'], $r['code'], $r['name']);
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="service" value="<?= $row['name'] ?>">
    </div>
    <div class="form-group">
        <label>Note</label>
        <textarea class="form-control" rows="<?= count(explode("\n", $row['note'])) ?>" name="description"><?= $row['note'] ?></textarea>
    </div>
    <div class="form-group">
        <label>Price</label>
        <input type="number" class="form-control" name="price" value="<?= $row['price'] ?>">
    </div>
    <div class="row">
        <div class="form-group col-6">
            <label>Profit Basic</label>
            <input type="number" class="form-control" name="pbasic" value="<?= $row['basic'] ?>">
        </div>
        <div class="form-group col-6">
            <label>Profit Premium</label>
            <input type="number" class="form-control" name="ppremi" value="<?= $row['premium'] ?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-6">
            <label>Minimal</label>
            <input type="number" class="form-control" name="ordmin" value="<?= $row['min'] ?>">
        </div>
        <div class="form-group col-6">
            <label>Maximal</label>
            <input type="number" class="form-control" name="ordmax" value="<?= $row['max'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
            <?= select_opt($row['status'], 'empty', ' Empty '); ?>
            <?= select_opt($row['status'], 'available', ' Available '); ?>
        </select>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="services_edit" class="btn btn-primary btn-block"> EDIT </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>