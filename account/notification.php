<?php 
require '../connect.php';
require _DIR_('library/session/user');
require _DIR_('library/shennboku.app/account-notification');
require _DIR_('library/layout/header.user');
?>
<style>.section-label{font-size:.85rem;color:#B9B9C3;text-transform:uppercase;letter-spacing:.6px}.custom-switch{padding-left:0;line-height:1.7rem}.custom-switch .custom-control-label{padding-left:3.5rem;line-height:1.7rem}.custom-control-label{position:relative;margin-bottom:0;vertical-align:top}label{color:#5E5873;font-size:.857rem}label,output{display:inline-block}.custom-switch .custom-control-label::before{border:none;background-color:#E2E2E2;height:1.7rem;box-shadow:none!important;-webkit-transition:opacity .25s ease,background-color .1s ease;transition:opacity .25s ease,background-color .1s ease;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;top:0;left:0}.custom-switch .custom-control-input:checked~.custom-control-label::before{box-shadow:none}.custom-switch .custom-control-label:after{position:absolute;top:4px;left:4px;box-shadow:-1px 2px 3px 0 rgb(34 41 47 / 20%);background-color:#FFF;-webkit-transition:all .15s ease-out;transition:all .15s ease-out;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.custom-switch .custom-control-input:checked~.custom-control-label::after{-webkit-transform:translateX(1.4rem);-ms-transform:translateX(1.4rem);transform:translateX(1.4rem)}</style>
<div class="row">
    <div class="col-12 d-none" id="sess-result"></div>
    <div class="col-12 col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Browser Notification</h4>
            </div>
            <div class="card-body">
                <form method="POST" id="ReloadNotifBrowserShenn">
                    <div class="row">
                        <h6 class="section-label mx-1 mb-2">Account</h6>
                        <div class="col-12 mb-2">
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" id="account-login" type="checkbox" name="browser" value="account-login" <?= (getUserNotif($sess_username, 'browser', 'account-login') == true) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="account-login">Notify me when someone logs in in a new place.</label>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" id="change-pin" type="checkbox" name="browser" value="change-pin" <?= (getUserNotif($sess_username, 'browser', 'change-pin') == true) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="change-pin">Notify me if someone changes my account pin.</label>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" id="change-password" type="checkbox" name="browser" value="change-password" <?= (getUserNotif($sess_username, 'browser', 'change-password') == true) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="change-password">Notify me if someone changes my account password.</label>
                            </div>
                        </div>
                        <h6 class="section-label mx-1 mt-2">Transaction & Deposit</h6>
                        <div class="col-12 mt-1 mb-2">
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" id="trx-pulsa" type="checkbox" name="browser" value="trx-pulsa" <?= (getUserNotif($sess_username, 'browser', 'trx-pulsa') == true) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="trx-pulsa">Notify me if the PPOB Credit transaction status changes.</label>
                            </div>
                        </div>
                        <? if(conf('xtra-fitur',3) == 'true') { ?>
                        <div class="col-12 mb-2">
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" id="trx-socmed" type="checkbox" name="browser" value="trx-socmed" <?= (getUserNotif($sess_username, 'browser', 'trx-socmed') == true) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="trx-socmed">Notify me if the social media transaction status changes.</label>
                            </div>
                        </div>
                        <? } if(conf('xtra-fitur',2) == 'true') { ?>
                        <div class="col-12 mb-2">
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" id="trx-game" type="checkbox" name="browser" value="trx-game" <?= (getUserNotif($sess_username, 'browser', 'trx-game') == true) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="trx-game">Notify me if the transaction status of Game Features changes.</label>
                            </div>
                        </div>
                        <? } ?>
                        <div class="col-12 mb-75">
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" id="deposit" type="checkbox" name="browser" value="deposit" <?= (getUserNotif($sess_username, 'browser', 'deposit') == true) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="deposit">Notify me if the status of the deposit request changes.</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>
<script type="text/javascript">
$(function() {
    $(document).on('change', '[name="browser"]' , function(){
        $.ajax({
            type: 'POST',
            data: 'app=browser&type=' + $(this).attr("value") + '&csrf_token=<?= $csrf_string ?>',
            url: '<?= base_url('account/notification?shennboku=1') ?>',
            dataType: 'html',
            beforeSend: function() { $("#sess-result").html();$("#ReloadNotifBrowserShenn").html('<center>Please wait, making changes.</center>'); },
            success: function(msg) { $("#sess-result").html(msg);$("#ReloadNotifBrowserShenn").load(" #ReloadNotifBrowserShenn > *"); },
            error: function() { $("#sess-result").html(error_result); }
        });
    });
});
</script>