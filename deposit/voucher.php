<?php 
require '../connect.php';
require _DIR_('library/session/user');
require _DIR_('library/shennboku.app/deposit-voucher');
require _DIR_('library/layout/header.user');
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">Voucher</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Code</label>
                                    <input type="text" name="keycode" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <button type="submit" name="redeem" class="btn btn-block bg-gradient-primary">Redeem</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable" id="ClaimVoucher" width="100%">
                            <thead>
                                <tr>
                                    <th>RID</th>
                                    <th>Amount</th>
                                    <th>Code</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="4" class="text-center">Loading data from server...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['id' => 'ClaimVoucher','url' => ajaxlib('table/voucher?__s=3'),'sort' => 3,'type' => 'desc']) ?>