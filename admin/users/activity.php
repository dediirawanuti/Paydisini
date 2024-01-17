<?php 
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/layout/header.admin');
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Activity Log</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:18%">Date</th>
                                    <th>User</th>
                                    <th>Address</th>
                                    <th>Content</th>
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
<?= datatable(['url' => ajaxlib('table/activity?__s=2'),'sort' => 0,'type' => 'desc']) ?>