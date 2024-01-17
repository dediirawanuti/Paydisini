<?php 
require '../connect.php';
require _DIR_('library/session/user');
require _DIR_('library/layout/header.user');
?>
<section id="basic-datatable">
    <style type="text/css">input[type='text']{font-size:12px}table.datatable td{font-size: 12px;vertical-align:middle}</style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Deposit History</h4>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped zero-configuration datatable" id="datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">RID</th>
                                    <th class="text-center">Payment</th>
                                    <th class="text-center">Note</th>
                                    <th class="text-center">Sender</th>
                                    <th class="text-center">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="5" class="text-center">Loading data from server...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['url' => ajaxlib('table/deposit?__s=1'),'sort' => 0,'type' => 'desc']) ?>