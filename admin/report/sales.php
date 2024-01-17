<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-report-sales');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12">
        <form method="GET">
            <div class="row">
                <div class="form-group col-6 col-md-4">
                    <input type="month" class="form-control" name="data" value="<?= $data ?>">
                </div>
                <div class="form-group col-6 col-md-4">
                    <select class="form-control" name="status">
                        <?= select_opt($status, 'error', 'Error'); ?>
                        <?= select_opt($status, 'partial', 'Partial'); ?>
                        <?= select_opt($status, 'waiting', 'Waiting'); ?>
                        <?= select_opt($status, 'processing', 'Processing'); ?>
                        <?= select_opt($status, 'success', 'Success'); ?>
                        <?= select_opt($status, 'All', 'All Status'); ?>
                    </select>
                </div>
                <div class="form-group col-12 col-md-4">
                    <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">Check</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pulsa PPOB</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Price</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($out_pulsa as $key => $value) { ?>
                        <tr>
                            <td><?= explode(',',format_date('en',$key))[0] ?></td>
                            <td><?= currency($value['total']).' Trx' ?></td>
                            <td><?= 'Rp '.currency($value['price']) ?></td>
                            <td><?= 'Rp '.currency($value['profit']) ?></td>
                        </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Social Media</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Price</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($out_sosmed as $key => $value) { ?>
                        <tr>
                            <td><?= explode(',',format_date('en',$key))[0] ?></td>
                            <td><?= currency($value['total']).' Trx' ?></td>
                            <td><?= 'Rp '.currency($value['price']) ?></td>
                            <td><?= 'Rp '.currency($value['profit']) ?></td>
                        </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Game Feature</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Price</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($out_game as $key => $value) { ?>
                        <tr>
                            <td><?= explode(',',format_date('en',$key))[0] ?></td>
                            <td><?= currency($value['total']).' Trx' ?></td>
                            <td><?= 'Rp '.currency($value['price']) ?></td>
                            <td><?= 'Rp '.currency($value['profit']) ?></td>
                        </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>