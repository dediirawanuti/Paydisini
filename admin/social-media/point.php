<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-transaction-point');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12 col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Set Referral Point</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="ptype">
                            <?= select_opt(conf('trxpoint',5),'+','(+) Plus') ?>
                            <?= select_opt(conf('trxpoint',5),'%','(%) Percent') ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" step="any" class="form-control" name="pamnt" value="<?= (conf('trxpoint',5) == '+') ? conf('trxpoint',6) : (conf('trxpoint',6)*100) ?>">
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                        <button type="submit" name="save_socmed" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>