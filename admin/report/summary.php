<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-report-summary');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12">
        <form method="GET">
            <div class="row">
                <div class="form-group col-6 col-md-5">
                    <input type="date" class="form-control" name="start" value="<?= $date_start ?>">
                </div>
                <div class="form-group col-6 col-md-5">
                    <input type="date" class="form-control" name="end" value="<?= $date_end ?>">
                </div>
                <div class="form-group col-12 col-md-2">
                    <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">Check</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12 col-md-6">
        <div class="card m-b-30">
            <div class="card-header">
                <h4 class="card-title">by Status</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#sumStatus1" role="tab" aria-controls="sumStatus1" aria-selected="false">Pulsa & PPOB</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#sumStatus2" role="tab" aria-controls="sumStatus2" aria-selected="false">Social Media</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#sumStatus3" role="tab" aria-controls="sumStatus3" aria-selected="false">Game Feature</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="sumStatus1">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead><tr><th>Status</th><th>Total</th><th>Amount</th></tr></thead>
                                <tbody>
                                    <? if(isset($out_status1_amount)) { arsort($out_status1_amount); foreach ($out_status1_amount as $key => $value) { ?>
                                    <tr>
                                        <td><?= ucwords($key) ?></td>
                                        <td><?= currency($out_status1_total[$key]).' Trx' ?></td>
                                        <td><?= 'Rp '.currency($value) ?></td>
                                    </tr>
                                    <? } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="sumStatus2">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead><tr><th>Status</th><th>Total</th><th>Amount</th></tr></thead>
                                <tbody>
                                    <? if(isset($out_status2_amount)) { arsort($out_status2_amount); foreach ($out_status2_amount as $key => $value) { ?>
                                    <tr>
                                        <td><?= ucwords($key) ?></td>
                                        <td><?= currency($out_status2_total[$key]).' Trx' ?></td>
                                        <td><?= 'Rp '.currency($value) ?></td>
                                    </tr>
                                    <? } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="sumStatus3">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead><tr><th>Status</th><th>Total</th><th>Amount</th></tr></thead>
                                <tbody>
                                    <? if(isset($out_status3_amount)) { arsort($out_status3_amount); foreach ($out_status3_amount as $key => $value) { ?>
                                    <tr>
                                        <td><?= ucwords($key) ?></td>
                                        <td><?= currency($out_status3_total[$key]).' Trx' ?></td>
                                        <td><?= 'Rp '.currency($value) ?></td>
                                    </tr>
                                    <? } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card m-b-30">
            <div class="card-header">
                <h4 class="card-title">by Payment</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? if(isset($out_depo_amount)) { arsort($out_depo_amount); foreach ($out_depo_amount as $key => $value) { $cari = $call->query("SELECT name FROM deposit_method WHERE code = '$key'"); ?>
                        <tr>
                            <td><?= ($cari->num_rows == 1) ? $cari->fetch_assoc()['name'] : ucfirst($key) ?></td>
                            <td><?= currency($out_depo_total[$key]).' Trx' ?></td>
                            <td><?= 'Rp '.currency($value) ?></td>
                        </tr>
                        <? } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-header">
                <h4 class="card-title">by Users</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#sumUser1" role="tab" aria-controls="sumUser1" aria-selected="false">Pulsa & PPOB</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#sumUser2" role="tab" aria-controls="sumUser2" aria-selected="false">Social Media</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#sumUser3" role="tab" aria-controls="sumUser3" aria-selected="false">Game Feature</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#sumUser4" role="tab" aria-controls="sumUser4" aria-selected="false">Deposit</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="sumUser1">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataUser1">
                                <thead><tr><th>No</th><th>User</th><th>Price</th></tr></thead>
                                <tbody>
                                    <? if(isset($out_users1_amount)) { arsort($out_users1_amount); $i = 1; foreach ($out_users1_amount as $key => $value) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= ucwords($key) ?></td>
                                        <td><?= 'Rp '.currency($value) ?></td>
                                    </tr>
                                    <? $i++; } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="sumUser2">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataUser2">
                                <thead><tr><th>No</th><th>User</th><th>Price</th></tr></thead>
                                <tbody>
                                    <? if(isset($out_users2_amount)) { arsort($out_users2_amount); $i = 1; foreach ($out_users2_amount as $key => $value) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= ucwords($key) ?></td>
                                        <td><?= 'Rp '.currency($value) ?></td>
                                    </tr>
                                    <? $i++; } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="sumUser3">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataUser3">
                                <thead><tr><th>No</th><th>User</th><th>Price</th></tr></thead>
                                <tbody>
                                    <? if(isset($out_users3_amount)) { arsort($out_users3_amount); $i = 1; foreach ($out_users3_amount as $key => $value) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= ucwords($key) ?></td>
                                        <td><?= 'Rp '.currency($value) ?></td>
                                    </tr>
                                    <? $i++; } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="sumUser4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataUser4">
                                <thead><tr><th>No</th><th>User</th><th>Amount</th></tr></thead>
                                <tbody>
                                    <? if(isset($out_depos_amount)) { arsort($out_depos_amount); $i = 1; foreach ($out_depos_amount as $key => $value) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= ucwords($key) ?></td>
                                        <td><?= 'Rp '.currency($value) ?></td>
                                    </tr>
                                    <? $i++; } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= datatables(['id' => 'dataUser1','sort' => 0,'type' => 'asc']) ?>
<?= datatables(['id' => 'dataUser2','sort' => 0,'type' => 'asc']) ?>
<?= datatables(['id' => 'dataUser3','sort' => 0,'type' => 'asc']) ?>
<?= datatables(['id' => 'dataUser4','sort' => 0,'type' => 'asc']) ?>
<? require _DIR_('library/layout/footer.user'); ?>