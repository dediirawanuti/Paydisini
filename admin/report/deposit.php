<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-report-deposit');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12">
        <form method="GET">
            <div class="row">
                <div class="form-group col-4 col-md-3">
                    <input type="date" class="form-control" name="start" value="<?= $date_start ?>">
                </div>
                <div class="form-group col-4 col-md-3">
                    <input type="date" class="form-control" name="end" value="<?= $date_end ?>">
                </div>
                <div class="form-group col-4 col-md-3">
                    <select class="form-control" name="status">
                        <?= select_opt($status, 'cancelled', 'Cancelled'); ?>
                        <?= select_opt($status, 'unpaid', 'Unpaid'); ?>
                        <?= select_opt($status, 'paid', 'Paid'); ?>
                        <?= select_opt($status, 'All', 'All Status'); ?>
                    </select>
                </div>
                <div class="form-group col-12 col-md-3">
                    <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">Check</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Payment</th>
                            <th>Account</th>
                            <th>Total</th>
                            <th>Amount</th>
                            <th>Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? if(count($out_deposit) > 0) { foreach($out_deposit as $key => $value) { if($key != 'All-Data') { ?>
                        <tr><td rowspan="<?= count($out_deposit[$key])-1 ?>"><b><?= $key ?></b></td></tr>
                        <? foreach($out_deposit[$key] as $keys => $values) { if(!in_array($keys,['total','amount','fee'])) { ?>
                        <tr>
                            <td><?= $keys ?></td>
                            <td><?= currency($values['total']).' Req' ?></td>
                            <td><?= 'Rp '.currency($values['amount']) ?></td>
                            <td><?= 'Rp '.currency($values['fee']) ?></td>
                        </tr>
                        <? } } ?>
                        <tr>
                            <td>Total</td>
                            <td><?= currency($out_deposit[$key]['total']).' Req' ?></td>
                            <td><?= 'Rp '.currency($out_deposit[$key]['amount']) ?></td>
                            <td><?= 'Rp '.currency($out_deposit[$key]['fee']) ?></td>
                        </tr>
                        <? print '<tr><td colspan="5" rowspan="1"><br></td></tr>'; } } print clearing($out_deposit['All-Data']); } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>