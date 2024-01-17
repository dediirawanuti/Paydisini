<?php 
require '../connect.php';
require _DIR_('library/session/user');
require _DIR_('library/layout/header.user');
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
            	<h4 class="header-title">Information Center</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered zero-configuration datatable" id="datatable" width="100%">
                        <thead>
                            <tr>
                                <th>Content</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="1" class="text-center">Loading data from server...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['url' => ajaxlib('table/news?__s=1'),'sort' => 0,'type' => 'desc']) ?>