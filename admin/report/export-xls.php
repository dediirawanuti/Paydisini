<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-report-export-xls');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel1" role="tab" aria-controls="panel1" aria-selected="false">Export</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel2" role="tab" aria-controls="panel2" aria-selected="false">Transaction Config</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel3" role="tab" aria-controls="panel3" aria-selected="false">Deposit Config</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="panel1">
                        <form method="POST">
                            <div class="row">
                                <div class="col-12 mb-1"><hr></div>
                                <div class="form-group col-12 col-md-6">
                                    <button type="button" <?= onclick_modal('Game Feature', base_url('admin/report/xlsx-transaction?d=trx_game'), 'lg') ?> class="btn btn-primary btn-block waves-effect waves-light">Game Feature</button>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <button type="button" <?= onclick_modal('Pulsa & PPOB', base_url('admin/report/xlsx-transaction?d=trx_ppob'), 'lg') ?> class="btn btn-primary btn-block waves-effect waves-light">Pulsa & PPOB</button>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <button type="button" <?= onclick_modal('Social Media', base_url('admin/report/xlsx-transaction?d=trx_socmed'), 'lg') ?> class="btn btn-primary btn-block waves-effect waves-light">Social Media</button>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <button type="button" <?= onclick_modal('Deposit', base_url('admin/report/xlsx-deposit'), 'lg') ?> class="btn btn-primary btn-block waves-effect waves-light">Deposit</button>
                                </div>
                                <div class="col-12"><hr></div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="panel2">
                        <form method="POST">
                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>File Author</label>
                                    <input type="text" class="form-control" name="1" value="<?= $DataAddon3['transaction']['1']['name'] ?>" placeholder="File Author">
                                </div>
                                <div class="form-group table-responsive col-12">
                                    <table class="table table-bordered" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>ID</td>
                                                <td><input type="text" class="form-control" name="2_1" value="<?= $DataAddon3['transaction']['2']['name'] ?>" placeholder="ID"></td>
                                                <td>
                                                    <select class="form-control" name="2_2">
                                                        <?= select_opt($DataAddon3['transaction']['2']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['2']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Website ID</td>
                                                <td><input type="text" class="form-control" name="3_1" value="<?= $DataAddon3['transaction']['3']['name'] ?>" placeholder="WID"></td>
                                                <td>
                                                    <select class="form-control" name="3_2">
                                                        <?= select_opt($DataAddon3['transaction']['3']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['3']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Provider ID</td>
                                                <td><input type="text" class="form-control" name="4_1" value="<?= $DataAddon3['transaction']['4']['name'] ?>" placeholder="TID"></td>
                                                <td>
                                                    <select class="form-control" name="4_2">
                                                        <?= select_opt($DataAddon3['transaction']['4']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['4']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Username</td>
                                                <td><input type="text" class="form-control" name="5_1" value="<?= $DataAddon3['transaction']['5']['name'] ?>" placeholder="User"></td>
                                                <td>
                                                    <select class="form-control" name="5_2">
                                                        <?= select_opt($DataAddon3['transaction']['5']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['5']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Service name</td>
                                                <td><input type="text" class="form-control" name="6_1" value="<?= $DataAddon3['transaction']['6']['name'] ?>" placeholder="Service"></td>
                                                <td>
                                                    <select class="form-control" name="6_2">
                                                        <?= select_opt($DataAddon3['transaction']['6']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['6']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Destination data</td>
                                                <td><input type="text" class="form-control" name="7_1" value="<?= $DataAddon3['transaction']['7']['name'] ?>" placeholder="Target"></td>
                                                <td>
                                                    <select class="form-control" name="7_2">
                                                        <?= select_opt($DataAddon3['transaction']['7']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['7']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td><input type="text" class="form-control" name="8_1" value="<?= $DataAddon3['transaction']['8']['name'] ?>" placeholder="Note"></td>
                                                <td>
                                                    <select class="form-control" name="8_2">
                                                        <?= select_opt($DataAddon3['transaction']['8']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['8']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Gross profit / Price</td>
                                                <td><input type="text" class="form-control" name="9_1" value="<?= $DataAddon3['transaction']['9']['name'] ?>" placeholder="Price"></td>
                                                <td>
                                                    <select class="form-control" name="9_2">
                                                        <?= select_opt($DataAddon3['transaction']['9']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['9']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Net profit / Profit</td>
                                                <td><input type="text" class="form-control" name="10_1" value="<?= $DataAddon3['transaction']['10']['name'] ?>" placeholder="Profit"></td>
                                                <td>
                                                    <select class="form-control" name="10_2">
                                                        <?= select_opt($DataAddon3['transaction']['10']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['10']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Transaction Status</td>
                                                <td><input type="text" class="form-control" name="11_1" value="<?= $DataAddon3['transaction']['11']['name'] ?>" placeholder="Status"></td>
                                                <td>
                                                    <select class="form-control" name="11_2">
                                                        <?= select_opt($DataAddon3['transaction']['11']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['11']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Created</td>
                                                <td><input type="text" class="form-control" name="12_1" value="<?= $DataAddon3['transaction']['12']['name'] ?>" placeholder="Created"></td>
                                                <td>
                                                    <select class="form-control" name="12_2">
                                                        <?= select_opt($DataAddon3['transaction']['12']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['12']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Updated</td>
                                                <td><input type="text" class="form-control" name="13_1" value="<?= $DataAddon3['transaction']['13']['name'] ?>" placeholder="Updated"></td>
                                                <td>
                                                    <select class="form-control" name="13_2">
                                                        <?= select_opt($DataAddon3['transaction']['13']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['13']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Provider</td>
                                                <td><input type="text" class="form-control" name="14_1" value="<?= $DataAddon3['transaction']['14']['name'] ?>" placeholder="Server"></td>
                                                <td>
                                                    <select class="form-control" name="14_2">
                                                        <?= select_opt($DataAddon3['transaction']['14']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['transaction']['14']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group text-right col-12">
                                    <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                                    <button type="submit" name="transaction_config" class="btn btn-primary waves-effect waves-light">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="panel3">
                        <form method="POST">
                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>File Author</label>
                                    <input type="text" class="form-control" name="1" value="<?= $DataAddon3['deposit']['1']['name'] ?>" placeholder="File Author">
                                </div>
                                <div class="form-group table-responsive col-12">
                                    <table class="table table-bordered" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>ID</td>
                                                <td><input type="text" class="form-control" name="2_1" value="<?= $DataAddon3['deposit']['2']['name'] ?>" placeholder="ID"></td>
                                                <td>
                                                    <select class="form-control" name="2_2">
                                                        <?= select_opt($DataAddon3['deposit']['2']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['2']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Website ID</td>
                                                <td><input type="text" class="form-control" name="3_1" value="<?= $DataAddon3['deposit']['3']['name'] ?>" placeholder="WID"></td>
                                                <td>
                                                    <select class="form-control" name="3_2">
                                                        <?= select_opt($DataAddon3['deposit']['3']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['3']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Username</td>
                                                <td><input type="text" class="form-control" name="4_1" value="<?= $DataAddon3['deposit']['4']['name'] ?>" placeholder="User"></td>
                                                <td>
                                                    <select class="form-control" name="4_2">
                                                        <?= select_opt($DataAddon3['deposit']['4']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['4']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Payment name</td>
                                                <td><input type="text" class="form-control" name="5_1" value="<?= $DataAddon3['deposit']['5']['name'] ?>" placeholder="Payment"></td>
                                                <td>
                                                    <select class="form-control" name="5_2">
                                                        <?= select_opt($DataAddon3['deposit']['5']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['5']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Method name</td>
                                                <td><input type="text" class="form-control" name="6_1" value="<?= $DataAddon3['deposit']['6']['name'] ?>" placeholder="Method"></td>
                                                <td>
                                                    <select class="form-control" name="6_2">
                                                        <?= select_opt($DataAddon3['deposit']['6']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['6']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td><input type="text" class="form-control" name="7_1" value="<?= $DataAddon3['deposit']['7']['name'] ?>" placeholder="Note"></td>
                                                <td>
                                                    <select class="form-control" name="7_2">
                                                        <?= select_opt($DataAddon3['deposit']['7']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['7']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sender Number</td>
                                                <td><input type="text" class="form-control" name="8_1" value="<?= $DataAddon3['deposit']['8']['name'] ?>" placeholder="Sender"></td>
                                                <td>
                                                    <select class="form-control" name="8_2">
                                                        <?= select_opt($DataAddon3['deposit']['8']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['8']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deposit Amount</td>
                                                <td><input type="text" class="form-control" name="9_1" value="<?= $DataAddon3['deposit']['9']['name'] ?>" placeholder="Amount"></td>
                                                <td>
                                                    <select class="form-control" name="9_2">
                                                        <?= select_opt($DataAddon3['deposit']['9']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['9']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deposit Fee</td>
                                                <td><input type="text" class="form-control" name="10_1" value="<?= $DataAddon3['deposit']['10']['name'] ?>" placeholder="Fee"></td>
                                                <td>
                                                    <select class="form-control" name="10_2">
                                                        <?= select_opt($DataAddon3['deposit']['10']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['10']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Transaction Status</td>
                                                <td><input type="text" class="form-control" name="11_1" value="<?= $DataAddon3['deposit']['11']['name'] ?>" placeholder="Status"></td>
                                                <td>
                                                    <select class="form-control" name="11_2">
                                                        <?= select_opt($DataAddon3['deposit']['11']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['11']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Created</td>
                                                <td><input type="text" class="form-control" name="12_1" value="<?= $DataAddon3['deposit']['12']['name'] ?>" placeholder="Created"></td>
                                                <td>
                                                    <select class="form-control" name="12_2">
                                                        <?= select_opt($DataAddon3['deposit']['12']['show'],0,'Hide') ?>
                                                        <?= select_opt($DataAddon3['deposit']['12']['show'],1,'Show') ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group text-right col-12">
                                    <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                                    <button type="submit" name="deposit_config" class="btn btn-primary waves-effect waves-light">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>