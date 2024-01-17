<?php
require '../../connect.php';
require _DIR_('library/session/admin');
//require _DIR_('library/shennboku.app/premium-voucher');
require _DIR_('library/layout/header.admin');
?>
<section id="basic-datatable">
    <style type="text/css">input[type='text']{font-size:12px}table.datatable td{font-size: 12px;vertical-align:middle}</style>
    <div class="row">
        <div class="col-12" id="sess-result"></div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Voucher Usage</h4>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration datatable" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Creator</th>
                                    <th>Code</th>
                                    <th>Amount</th>
                                    <th>Note</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="6" class="text-center">Loading data from server...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['url' => ajaxlib('table/voucher?__s=1'),'sort' => 0,'type' => 'desc']) ?>