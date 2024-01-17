<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
?>
<form method="POST">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode('socmed') ?>">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Option</label>
        <select class="form-control" name="clear_option" id="clear_option">
            <option value="0" selected disabled>- Select One -</option>
            <optgroup label="Single Option">
                <option value="category">Category</option>
                <option value="provider">Provider</option>
            </optgroup>
            <optgroup label="Double">
                <option value="category-provider">Category & Provider</option>
            </optgroup>
        </select>
    </div>
    <div class="form-group d-none" id="selcategory">
        <label>Choose Category</label>
        <select class="form-control" name="clear_category">
            <option value="0" selected disabled>- Select Category -</option>
            <?php
            $s = $call->query("SELECT * FROM category WHERE `order` = 'social'");
            while($r = $s->fetch_assoc()) {
                print '<option value="'.$r['code'].'">['.currency(squery("SELECT id FROM srv_socmed WHERE cid = '".$r['code']."'")->num_rows).'] '.$r['name'].'</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group d-none" id="selprovider">
        <label>Choose Provider</label>
        <select class="form-control" name="clear_provider">
            <option value="0" selected disabled>- Select Provider -</option>
            <?php
            $s = $call->query("SELECT * FROM provider");
            while($r = $s->fetch_assoc()) {
                print '<option value="'.$r['code'].'">['.currency(squery("SELECT id FROM srv_socmed WHERE provider = '".$r['code']."'")->num_rows).'] '.$r['name'].'</option>';
            }
            ?>
        </select>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="service_clear" class="btn btn-primary btn-block"> CLEAR </button>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
    $("#clear_option").change(function() {
        var select = $("#clear_option").val();
        $('#selcategory').addClass('d-none');
        $('#selprovider').addClass('d-none');
        
        if(select == 'category' || select == 'category-provider') $('#selcategory').removeClass('d-none');
        if(select == 'provider' || select == 'type-provider' || select == 'category-provider') $('#selprovider').removeClass('d-none');
    });
});
</script>
<?php
} else {
    exit("No direct script access allowed!");
}
?>