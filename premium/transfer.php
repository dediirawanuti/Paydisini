<?php 
require '../connect.php';
require _DIR_('library/session/premium');
require _DIR_('library/shennboku.app/premium-transfer');
require _DIR_('library/layout/header.user');
?>
<section id="basic-tabs-components">
    <div class="row">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">Transfer</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Username</label>
                                    <input type="text" name="user" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <button type="submit" name="submit" class="btn btn-block bg-gradient-primary">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="debit-tab" data-toggle="tab" href="#debit" aria-controls="debit" role="tab" aria-selected="false">Debit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="credit-tab" data-toggle="tab" href="#credit" aria-controls="credit" role="tab" aria-selected="true">Credit</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="debit" aria-labelledby="debit-tab" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable" id="MyDebit" width="100%">
                                    <thead>
                                        <tr>
                                            <th>RID</th>
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
                        <div class="tab-pane active" id="credit" aria-labelledby="credit-tab" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable" id="MyCredit" width="100%">
                                    <thead>
                                        <tr>
                                            <th>RID</th>
                                            <th>Amount</th>
                                            <th>Sender</th>
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
        </div>
    </div>
</section>
<? require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['id' => 'MyDebit','url' => ajaxlib('table/transfer?__s=2'),'sort' => 3,'type' => 'desc']) ?>
<?= datatable(['id' => 'MyCredit','url' => ajaxlib('table/transfer?__s=3'),'sort' => 3,'type' => 'desc']) ?>