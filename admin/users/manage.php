<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-users-add');
require _DIR_('library/shennboku.app/admin-users-edit');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12" id="sess-result"></div>
    <div class="col-lg-6 col-sm-6 col-12">
        <div class="card m-b-30 text-white bg-info text-center">
            <div class="card-content">
                <div class="card-body">
                    <h6 class="card-title text-white" style="font-size: 0.875rem;">Active Users</h6>
                    <p class="card-text"><?= currency(squery("SELECT id FROM users WHERE status = 'active'")->num_rows) ?> (From <?= currency(squery("SELECT id FROM users")->num_rows) ?>)</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6 col-12">
        <div class="card m-b-30 text-white bg-info text-center">
            <div class="card-content">
                <div class="card-body">
                    <h6 class="card-title text-white" style="font-size: 0.875rem;">Total Balance</h6>
                    <p class="card-text">Rp <?= currency(squery("SELECT SUM(balance) AS x FROM users WHERE status = 'active' AND level != 'Admin'")->fetch_assoc()['x']) ?> (From <?= currency(squery("SELECT id FROM users WHERE status = 'active'")->num_rows) ?>)</p>
                </div>
            </div>
        </div>
    </div>
</div>
<section id="basic-datatable">
    <style type="text/css">input[type='text']{font-size:12px}table.datatable td{font-size: 12px;vertical-align:middle}</style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end">
                    <h4 class="card-title mb-0">Manage Users</h4>
                    <a href="javascript:;" <?= onclick_modal('Add User', base_url('admin/users/add'), 'lg') ?>>
                        <p class="font-medium-5 mb-0">Tambah</p>
                    </a>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration datatable" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Balance</th>
                                    <th>Joined</th>
                                    <th>Act.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="7" class="text-center">Loading data from server...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['url' => ajaxlib('table/users?__s=2'),'sort' => 6,'type' => 'desc']) ?>