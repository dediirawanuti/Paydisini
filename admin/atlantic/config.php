<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-atlantic-config');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <!--<div class="col-12">-->
    <!--    <div class="card">-->
    <!--        <div class="card-body text-center">-->
    <!--            This site has collaborated with <a href="https://atlantic-group.co.id/" target="blank">PT. Atlantic Aksa Group</a> as a provider of mutation services, whatsapp gateways and various other 3rd parties.-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Atlantic Group Config</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="row">
                        <div class="form-group col-12 col-md-2">
                            <label>API ID</label>
                            <input type="text" class="form-control" name="apiid" value="<?= conf('atlantic-cfg', 1) ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>API Key</label>
                            <input type="text" class="form-control" name="apikey" value="<?= conf('atlantic-cfg', 2) ?>">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label>Signature</label>
                            <input type="text" class="form-control" value="<?= md5(conf('atlantic-cfg', 1).conf('atlantic-cfg', 2)) ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Mutation Subscription ID</label>
                            <input type="text" class="form-control" name="musid" value="<?= conf('atlantic-cfg', 3) ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Whatsapp Subscription ID</label>
                            <input type="text" class="form-control" name="wasid" value="<?= conf('atlantic-cfg', 4) ?>">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                        <button type="submit" name="save" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Detail</h4>
            </div>
            <div class="card-body">
                <p>
                    Validation
                    <span class="float-right text-<?= strtr($sky,['OK'=>'success','EXP'=>'warning','FAIL'=>'danger']) ?> font-weight-bold"><?= $sky ?></span>
                </p>
                <p>
                    Mutation API
                    <span class="float-right text-<?= strtr($smu,['OK'=>'success','EXP'=>'warning','FAIL'=>'danger']) ?> font-weight-bold"><?= $smu ?></span>
                </p>
                <p>
                    WhatsApp Manager
                    <span class="float-right text-<?= strtr($swa,['OK'=>'success','EXP'=>'warning','FAIL'=>'danger']) ?> font-weight-bold"><?= $swa ?></span>
                </p>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>