<?php 
require '../../connect.php';
require _DIR_('library/session/user');
if(conf('xtra-fitur',2) <> 'true') exit(redirect(0,base_url('order/history/pulsa-ppob')));
require _DIR_('library/layout/header.user');
?>
<section id="basic-datatable">
    <style type="text/css">input[type='text']{font-size:12px}table.datatable td{font-size: 12px;vertical-align:middle}</style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Game Feature</h4>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration datatable" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Service</th>
                                    <th>Target</th>
                                    <th>Price</th>
                                    <th>Detail</th>
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
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['url' => ajaxlib('table/transaction?__s=3'),'sort' => 0,'type' => 'desc']) ?>