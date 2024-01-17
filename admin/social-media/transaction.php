<?php 
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/layout/header.admin');
?>
<section id="basic-datatable">
    <style type="text/css">input[type='text']{font-size:12px}table.datatable td{font-size: 12px;vertical-align:middle}</style>
    <div class="row">
        <div class="col-12" id="sess-result"></div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card m-b-30">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?= currency($call->query("SELECT id FROM trx_socmed WHERE status IN ('error','partial')")->num_rows) ?></h2>
                        <p>Error & Partial</p>
                    </div>
                    <div class="avatar bg-rgba-danger p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-flag text-danger font-medium-5"></i>
                        </div>
                    </div>
                </div>
                </br>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card m-b-30">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?= currency($call->query("SELECT id FROM trx_socmed WHERE status = 'waiting'")->num_rows) ?></h2>
                        <p>Waiting</p>
                    </div>
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-loader text-warning font-medium-5"></i>
                        </div>
                    </div>
                </div>
                </br>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card m-b-30">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?= currency($call->query("SELECT id FROM trx_socmed WHERE status = 'processing'")->num_rows) ?></h2>
                        <p>Processing</p>
                    </div>
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-layers text-primary font-medium-5"></i>
                        </div>
                    </div>
                </div>
                </br>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card m-b-30">
                <div class="card-header d-flex align-items-start pb-0">
                  <div>
                      <h2 class="text-bold-700 mb-0"><?= currency($call->query("SELECT id FROM trx_socmed WHERE status = 'success'")->num_rows) ?></h2>
                      <p>Success</p>
                  </div>
                  <div class="avatar bg-rgba-success p-50 m-0">
                      <div class="avatar-content">
                            <i class="feather icon-package text-success font-medium-5"></i>
                      </div>
                  </div>
                </div>
                </br>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Social Media</h4>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration datatable" id="datatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Service</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['url' => ajaxlib('table/transaction-admin?__s=2'),'sort' => 0,'type' => 'desc']) ?>
<script type="text/javascript">
function ShennStOrder(wid,status) {
	$.ajax({
	    type: 'POST',
	    data: 'id=' + wid + '&data=' + status + '&csrf_token=' + csrf_key,
	    url: base_url + 'admin/social-media/transaction-status',
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
} function ShennAct(form, link) {
	$.ajax({
	    url: link,
		type: 'POST',
		dataType: 'html',
		data: $(form).serialize(),
		success: function(data) {
		    $('#sess-result-modal').html(data);
			$('#sess-result').html(data);
			$('#datatable').DataTable().ajax.reload();
		}, error: function() {
		    $('#sess-result').html(error_result);
		}, beforeSend: function() {
		    $('#sess-result-modal').html();
		}
	});
}
</script>