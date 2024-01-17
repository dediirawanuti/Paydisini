<?php
require '../../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-others-faq');
require _DIR_('library/layout/header.admin');
?>
<section id="basic-tabs-components">
    <div class="row">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">General Question</h4>
                </div>
                <div class="card-body card-dashboard">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="ShennList-tab" data-toggle="tab" href="#ShennList" aria-controls="ShennList" role="tab" aria-selected="true">List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ShennAdd-tab" data-toggle="tab" href="#ShennAdd" aria-controls="ShennAdd" role="tab" aria-selected="false">New QnA</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="ShennList" aria-labelledby="ShennList-tab" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration datatable" id="datatable" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Quest</th>
                                            <th>Answer</th>
                                            <th>Act.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td colspan="3" class="text-center">Loading data from server...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="ShennAdd" aria-labelledby="ShennAdd-tab" role="tabpanel">
                            <form method="POST">
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group">
                                    <label>Question</label>
                                    <input type="text" class="form-control" name="addfaq_quest">
                                </div>
                                <div class="form-group">
                                    <label>Answer</label>
                                    <textarea name="addfaq_ans"></textarea>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                                    <button type="submit" name="addfaq" class="btn btn-primary waves-effect waves-light">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>
<?= datatable(['url' => ajaxlib('table/news?__s=4'),'sort' => 2,'type' => 'desc']) ?>
<?= ckeditor(['addfaq_ans']) ?>