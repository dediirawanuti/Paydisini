<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-config-smtp');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">SMTP Mailer</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="form-group">
                        <label>Host</label>
                        <input type="text" class="form-control" name="mailer_host" value="<?= conf('mailer',1) ?>" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="mailer_user" value="<?= conf('mailer',2) ?>" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" class="form-control" name="mailer_pass" value="<?= conf('mailer',3) ?>" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Set Mail From</label>
                        <input type="text" class="form-control" name="mailer_from" value="<?= conf('mailer',4) ?>" placeholder="">
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                        <button type="submit" name="save" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>