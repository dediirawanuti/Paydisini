<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="row">
        <div class="form-group col-7">
            <label>Provider</label>
            <select class="form-control" name="provider_name">
                <option value=""> - Select One - </option>
                <?php
                $search = $call->query("SELECT code, name FROM provider ORDER BY name ASC");
                while($row = $search->fetch_assoc()) {
                    print '<option value="'.$row['code'].'">'.$row['name'].'</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group col-5">
            <label>P. ID</label>
            <input type="text" class="form-control" name="provider_id">
        </div>
    </div>
    <div class="form-group">
        <label>Category</label>
        <select class="form-control" name="category">
            <option value=""> - Select One - </option>
            <?php
            $search = $call->query("SELECT code, name FROM category WHERE `order` = 'social' ORDER BY name ASC");
            while($row = $search->fetch_assoc()) {
                print '<option value="'.$row['code'].'">'.$row['name'].'</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="service">
    </div>
    <div class="form-group">
        <label>Note</label>
        <textarea class="form-control" name="description"></textarea>
    </div>
    <div class="form-group">
        <label>Price</label>
        <input type="number" class="form-control" name="price">
    </div>
    <div class="row">
        <div class="form-group col-6">
            <label>Profit Basic</label>
            <input type="number" class="form-control" name="pbasic">
        </div>
        <div class="form-group col-6">
            <label>Profit Premium</label>
            <input type="number" class="form-control" name="ppremi">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-6">
            <label>Minimal</label>
            <input type="number" class="form-control" name="ordmin">
        </div>
        <div class="form-group col-6">
            <label>Maximal</label>
            <input type="number" class="form-control" name="ordmax">
        </div>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
            <option value=""> - Select One - </option>
            <option value="empty"> Empty </option>
            <option value="available"> Available </option>
        </select>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="services_add" class="btn btn-primary btn-block"> ADD </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>