<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-report-profit');
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
                        <?= select_opt($status, 'error', 'Error'); ?>
                        <?= select_opt($status, 'partial', 'Partial'); ?>
                        <?= select_opt($status, 'waiting', 'Waiting'); ?>
                        <?= select_opt($status, 'processing', 'Processing'); ?>
                        <?= select_opt($status, 'success', 'Success'); ?>
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
                            <th>Type</th>
                            <th>Server</th>
                            <th>Total</th>
                            <th>Amount</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- ###################################################################### -->
                        <tr>
                            <td rowspan="<?= count($out_pulsa)+1 ?>"><b>Pulsa & PPOB</b></td>
                            <? if($out_pulsa == 0) clearing($out_pulsa['All-Data']); ?>
                        </tr>
                        <? foreach ($out_pulsa as $key => $value) { if($key != 'All-Data') { ?>
						<tr>
						    <td><?= $key ?></td>
                            <td>Rp <?= currency($value['modal']) ?></td>
                            <td><?= currency($value['total']) ?> Trx</td>
                            <td>Rp <?= currency($value['margin']) ?></td>
                        </tr>
                        <? } } if($out_pulsa != 0) clearing($out_pulsa['All-Data'], true); ?>
                        <tr><td colspan="5" rowspan="1"><br></td></tr>
                        <!-- ###################################################################### -->
                        <tr>
                            <td rowspan="<?= count($out_sosmed)+1 ?>"><b>Social Media</b></td>
                            <? if($out_sosmed == 0) clearing($out_sosmed['All-Data']); ?>
                        </tr>
                        <?php foreach ($out_sosmed as $key => $value) { if($key != 'All-Data') { ?>
						<tr>
						    <td><?= $key ?></td>
                            <td>Rp <?= currency($value['modal']) ?></td>
                            <td><?= currency($value['total']) ?> Trx</td>
                            <td>Rp <?= currency($value['margin']) ?></td>
                        </tr>
                        <?php } } if($out_sosmed != 0) clearing($out_sosmed['All-Data'], true); ?>
                        <tr><td colspan="5" rowspan="1"><br></td></tr>
                        <!-- ###################################################################### -->
                        <tr>
                            <td rowspan="<?= count($out_game)+1 ?>"><b>Game Feature</b></td>
                            <? if($out_game == 0) clearing($out_game['All-Data']); ?>
                        </tr>
                        <?php foreach ($out_game as $key => $value) { if($key != 'All-Data') { ?>
						<tr>
						    <td><?= $key ?></td>
                            <td>Rp <?= currency($value['modal']) ?></td>
                            <td><?= currency($value['total']) ?> Order</td>
                            <td>Rp <?= currency($value['margin']) ?></td>
                        </tr>
                        <?php } } if($out_game != 0) clearing($out_game['All-Data'], true); ?>
                        <tr><td colspan="5" rowspan="1"><br></td></tr>
                        <!-- ###################################################################### -->
                        <tr>
                            <td colspan="2"><b>Total All</b></td>
                            <td>Rp <?= currency($out_pulsa['All-Data']['modal']+$out_sosmed['All-Data']['modal']+$out_game['All-Data']['modal']) ?></td>
                            <td><?= currency($out_pulsa['All-Data']['total']+$out_sosmed['All-Data']['total']+$out_game['All-Data']['total']) ?> Trx</td>
                            <td>Rp <?= currency($out_pulsa['All-Data']['margin']+$out_sosmed['All-Data']['margin']+$out_game['All-Data']['margin']) ?></td>
                        </tr>
                        <!-- ###################################################################### -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>