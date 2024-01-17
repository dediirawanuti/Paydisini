<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-config-firebase');
require _DIR_('library/layout/header.admin');
$check = (conf('firebase',8) == 'false') ? 'false' : 'true';
?>
<div class="row">
    <? if($check == 'false') { ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <center class="mt-2 mb-2">
                    <img src="https://firebase.google.com/downloads/brand-guidelines/SVG/logo-standard.svg" width="60%" class="d-block mb-1">
                    <b>[ <a href="javascript:;" <?= onclick_href(base_url('admin/config/firebase?activate=1')) ?>>Click to Activate</a> ]</b>
                </center>
            </div>
        </div>
    </div>
    <? } else { ?>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-end">
                <h4 class="card-title mb-0">Firebase Config</h4>
                <a href="javascript:;" onclick="javascript:window.open('https://console.firebase.google.com/');">
                    <p class="font-medium-5 mb-0"><i class="feather icon-sliders text-primary cursor-pointer"></i></p>
                </a>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="form-group">
                        <label>API Key</label>
                        <input type="text" class="form-control" name="fcm_key" value="<?= conf('firebase',1) ?>" placeholder="AIza....">
                    </div>
                    <div class="form-group">
                        <label>Project ID</label>
                        <input type="text" class="form-control" name="fcm_project" value="<?= conf('firebase',2) ?>" placeholder="....">
                    </div>
                    <div class="form-group">
                        <label>Server Key</label>
                        <input type="text" class="form-control" name="fcm_msgid" value="<?= conf('firebase',3) ?>" placeholder="....">
                    </div>
                    <div class="form-group">
                        <label>Sender ID</label>
                        <input type="text" onkeyup="this.value=this.value.replace(/[^\d]+/g,'')" class="form-control" name="fcm_sendid" value="<?= conf('firebase',4) ?>" placeholder="....">
                    </div>
                    <div class="form-group">
                        <label>App ID</label>
                        <input type="text" class="form-control" name="fcm_appid" value="<?= conf('firebase',5) ?>" placeholder="....">
                    </div>
                    <div class="form-group">
                        <label>Measurement ID</label>
                        <input type="text" class="form-control" name="fcm_measurement" value="<?= conf('firebase',6) ?>" placeholder="....">
                    </div>
                    <div class="form-group">
                        <label>Firebase JS SDK Version</label>
                        <input type="text" onkeyup="this.value=this.value.replace(/[^\d\.]+/g,'')" class="form-control" name="fcm_version" value="<?= conf('firebase',7) ?>" placeholder="8.2.9">
                        <small class="text-danger">https://www.gstatic.com/firebasejs/<b class="text-primary">8.2.9</b>/firebase-app.js</small>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                        <button type="submit" name="disable" class="btn btn-warning waves-effect waves-light">Disable</button>
                        <button type="submit" name="save" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <? } ?>
</div>
<? require _DIR_('library/layout/footer.user'); ?>