<?php
require '../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    $equalPhone = ($json_user['old_phone'] == $json_user['new_phone']) ? true : false;
    require _DIR_('library/shennboku.app/account-change-phone');
?>
<div id="sess-result-modal"></div>
<form method="POST" id="form-cp">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Old Number</label>
        <input type="text" class="form-control" value="<?= $data_user['phone'] ?>" disabled>
    </div>
    <div class="form-group">
        <label>New Number</label>
        <div class="input-group">
            <div class="input-group-append">
                <? if($equalPhone == false) { ?>
                <button type="button" onclick="ShennForm('#form-cp','<?= base_url('account/change-phone?cancel=1') ?>');" class="btn btn-danger waves-effect waves-light">
                    <i class="feather icon-x"></i>
                </button>
                <? } ?>
            </div>
            <input type="text" class="form-control" name="u_phone" value="<?= ($equalPhone == true) ? '' : $json_user['new_phone'] ?>" onkeyup="this.value=this.value.replace(/[^\d]+/g,'')" <?= ($equalPhone == true) ? 'required' : 'disabled' ?> data-validation-required-message="This phone field is required" minlength="12" maxlength="14">
            <div class="input-group-append">
                <? if($equalPhone == true) { ?>
                <button type="button" onclick="ShennForm('#form-cp','<?= base_url('account/change-phone?send=1') ?>');" class="btn btn-primary waves-effect waves-light">
                    Send
                </button>
                <? } else { ?>
                <button type="button" onclick="ShennForm('#form-cp','<?= base_url('account/change-phone?resend=1') ?>');" class="btn btn-primary waves-effect waves-light">
                    Resend
                </button>
                <? } ?>
            </div>
        </div>
        <small class="text-danger">*Only supports Indonesian numbers.</small>
    </div>
    <div class="form-group">
        <label>Confirmation Code</label>
        <input type="text" class="form-control" name="c_phone" onkeyup="this.value=this.value.replace(/[^\d]+/g,'')" required data-validation-required-message="This confirmation field is required" minlength="0" maxlength="6">
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="button" onclick="ShennForm('#form-cp','<?= base_url('account/change-phone?confirm=1') ?>');" class="btn btn-primary btn-block"> CONFIRM </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>