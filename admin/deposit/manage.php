<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/layout/header.admin');
?>
<section id="basic-datatable">
    <style type="text/css">input[type='text']{font-size:12px}table.datatable td{font-size: 12px;vertical-align:middle}</style>
    <div class="row">
        <div class="col-12" id="sess-result"></div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Deposit Request</h4>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration datatable" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
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
<?= datatable(['url' => ajaxlib('table/deposit?__s=2'),'sort' => 4,'type' => 'desc']) ?>
<script type="text/javascript">
    function ShennStDeposit(link) {
        $.ajax({
            url: link,
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                $('#sess-result').html(data);
                $('#datatable').DataTable().ajax.reload();
            }, error: function() {
                $('#sess-result').html(error_result);
            }, beforeSend: function() {
                $('#sess-result').html();
            }
    	});
    }
</script>