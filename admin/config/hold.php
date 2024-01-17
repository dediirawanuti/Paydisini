<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-config-hold');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12 col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Hold Balance</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="form-group">
                        <label>Basic</label>
                        <input type="number" class="form-control" name="hold_basic" value="<?= conf('hold-balance',1) ?>">
                    </div>
                    <div class="form-group">
                        <label>Premium</label>
                        <input type="number" class="form-control" name="hold_premium" value="<?= conf('hold-balance',2) ?>">
                    </div>
                    <div class="form-group">
                        <label>Admin</label>
                        <input type="number" class="form-control" name="hold_admin" value="<?= conf('hold-balance',3) ?>">
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