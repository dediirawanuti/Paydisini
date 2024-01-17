<?php
require '../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    $equalMail = ($json_user['old_email'] == $json_user['new_email']) ? true : false;
    require _DIR_('library/shennboku.app/account-change-email');
?>
<div id="sess-result-modal"></div>
<form method="POST" id="form-ce">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Old Email</label>
        <input type="text" class="form-control" value="<?= $data_user['email'] ?>" disabled>
    </div>
    <div class="form-group">
        <label>New Email</label>
        <div class="input-group">
            <div class="input-group-append">
                <? if($equalMail == false) { ?>
                <button type="button" onclick="ShennForm('#form-ce','<?= base_url('account/change-email?cancel=1') ?>');" class="btn btn-danger waves-effect waves-light">
                    <i class="feather icon-x"></i>
                </button>
                <? } ?>
            </div>
            <input type="email" class="form-control" name="u_email" value="<?= ($equalMail == true) ? '' : $json_user['new_email'] ?>" <?= ($equalMail == true) ? 'required' : 'disabled' ?> data-validation-required-message="This mail field is required">
            <div class="input-group-append">
                <? if($equalMail == true) { ?>
                <button type="button" onclick="ShennForm('#form-ce','<?= base_url('account/change-email?send=1') ?>');" class="btn btn-primary waves-effect waves-light">
                    Send
                </button>
                <? } else { ?>
                <button type="button" onclick="ShennForm('#form-ce','<?= base_url('account/change-email?resend=1') ?>');" class="btn btn-primary waves-effect waves-light">
                    Resend
                </button>
                <? } ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Confirmation Code</label>
        <input type="text" class="form-control" name="c_email" required data-validation-required-message="This confirmation field is required" minlength="0" maxlength="12">
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="button" onclick="ShennForm('#form-ce','<?= base_url('account/change-email?confirm=1') ?>');" class="btn btn-primary btn-block"> CONFIRM </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>