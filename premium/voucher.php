<?php 
require '../connect.php';
require _DIR_('library/session/premium');
require _DIR_('library/shennboku.app/premium-voucher');
require _DIR_('library/layout/header.user');
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">Create Voucher</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control" required>
                                    <small class="text-danger">Vouchers that have been made cannot be claimed in your account.</small>
                                </div>
                                <div class="col-md-4">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <button type="submit" name="submit" class="btn btn-block bg-gradient-primary">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable" id="MyVoucher" width="100%">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Amount</th>
                                    <th>Note</th>
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
<?= datatable(['id' => 'MyVoucher','url' => ajaxlib('table/voucher?__s=2'),'sort' => 3,'type' => 'desc']) ?>