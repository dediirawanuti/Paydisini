<?php 
require '../../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-others-banner');
require _DIR_('library/layout/header.admin');
?>
<section id="basic-datatable">
    <style type="text/css">input[type='text']{font-size:12px}table.datatable td{font-size: 12px;vertical-align:middle}</style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end">
                    <h4 class="card-title mb-0">Index Banner</h4>
                    <a href="javascript:;" onclick="modal('Add Banner','<?= base_url('admin/others/banner/add') ?>','lg')">
                        <p class="font-medium-5 mb-0"><i class="feather icon-plus-circle text-primary cursor-pointer"></i></p>
                    </a>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration datatable" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Act.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="2" class="text-center">Loading data from server...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['url' => ajaxlib('table/news?__s=3'),'sort' => 1,'type' => 'desc']) ?>