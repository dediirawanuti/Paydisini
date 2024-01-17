<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-config-others');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12" id="sess-result"></div>
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <center>IP Static: <?= $_SERVER['SERVER_ADDR'] ?><br><?= base_url() ?></center>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="header-title">Extra Feature</h4>
                <hr>
                <form method="POST" id="ReloadThisFeatureShenn">
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="cfg_1" type="checkbox" name="xtra_fitur" value="trxgame" <?= (conf('xtra-fitur', 2) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="cfg_1">
                                Transaction - Games
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="cfg_2" type="checkbox" name="xtra_fitur" value="trxpostpaid" <?= (conf('xtra-fitur', 1) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="cfg_2">
                                Transaction - Postpaid
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="cfg_3" type="checkbox" name="xtra_fitur" value="trxsocmed" <?= (conf('xtra-fitur', 3) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="cfg_3">
                                Transaction - Social Media
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="cfg_4" type="checkbox" name="xtra_fitur" value="hofpage" <?= (conf('xtra-fitur', 4) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="cfg_4">
                                Hall of Fame Pages
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="cfg_5" type="checkbox" name="xtra_fitur" value="ssodevice" <?= (conf('xtra-fitur', 5) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="cfg_5">
                                Single Sign On Device
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="cfg_6" type="checkbox" name="xtra_fitur" value="reqlocfwa" <?= (conf('xtra-fitur', 6) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="cfg_6">
                                Require Location for Web Access
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="cfg_7" type="checkbox" name="xtra_fitur" value="devmode" <?= (conf('xtra-fitur', 7) == 'true') ? 'checked' : '' ?> disabled>
                            <label class="custom-control-label" for="cfg_7">
                                <del>Developer Mode</del>
                            </label>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="header-title">Maintenance</h4>
                <hr>
                <form method="POST" id="ReloadThisMaintenanceShenn">
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="mnt_1" type="checkbox" name="webmt" value="trx" <?= (conf('webmt', 5) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="mnt_1">
                                Transaction
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="mnt_2" type="checkbox" name="webmt" value="topup" <?= (conf('webmt', 6) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="mnt_2">
                                Deposit
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="mnt_3" type="checkbox" name="webmt" value="website" <?= (conf('webmt', 1) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="mnt_3">
                                Website
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="mnt_4" type="checkbox" name="webmt" value="restapi" <?= (conf('webmt', 2) == 'true') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="mnt_4">
                                Rest API
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="mnt_5" type="checkbox" name="webmt" value="telebot" <?= (conf('webmt', 4) == 'true') ? 'checked' : '' ?> disabled>
                            <label class="custom-control-label" for="mnt_5">
                                <del>Telegram BOT</del>
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" id="mnt_6" type="checkbox" name="webmt" value="wabot" <?= (conf('webmt', 3) == 'true') ? 'checked' : '' ?> disabled>
                            <label class="custom-control-label" for="mnt_6">
                                <del>WhatsApp BOT</del>
                            </label>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>
<script type="text/javascript">
$(function() {
    $(document).on('change', '[name="xtra_fitur"]' , function(){
        $.ajax({
            type: 'POST',
            data: 'value=' + $(this).attr("value") + '&csrf_token=<?= $csrf_string ?>',
            url: '<?= base_url('admin/config/others?feature=1') ?>',
            dataType: 'html',
            beforeSend: function() { $("#sess-result").html();$("#ReloadThisFeatureShenn").html('<center>Please wait...</center>'); },
            success: function(msg) { $("#sess-result").html(msg);$("#ReloadThisFeatureShenn").load(" #ReloadThisFeatureShenn > *"); },
            error: function() { $("#sess-result").html(error_result); }
        });
    });
    $(document).on('change', '[name="webmt"]' , function(){
        $.ajax({
            type: 'POST',
            data: 'value=' + $(this).attr("value") + '&csrf_token=<?= $csrf_string ?>',
            url: '<?= base_url('admin/config/others?maintenance=1') ?>',
            dataType: 'html',
            beforeSend: function() { $("#sess-result").html();$("#ReloadThisMaintenanceShenn").html('<center>Please wait...</center>'); },
            success: function(msg) { $("#sess-result").html(msg);$("#ReloadThisMaintenanceShenn").load(" #ReloadThisMaintenanceShenn > *"); },
            error: function() { $("#sess-result").html(error_result); }
        });
    });
});
</script>