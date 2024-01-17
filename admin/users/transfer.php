<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/layout/header.admin.php');
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Transfer History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable" id="datatable">
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
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['url' => ajaxlib('table/transfer?__s=1'),'sort' => 3,'type' => 'desc']) ?>