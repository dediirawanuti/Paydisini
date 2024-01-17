<?php
require '../../../connect.php';
require _DIR_('library/session/admin');

require _DIR_('library/shennboku.app/admin-others-news');
$code = isset($_GET['s']) ? filter(base64_decode($_GET['s'])) : '';
$search = $call->query("SELECT * FROM information WHERE id = '$code' AND type != 'banner'");
if($search->num_rows == 0) { $_SESSION['result'] = ['type' => false,'message' => 'News / Information not found.']; exit(redirect(0,base_url('admin/others/news/'))); }
$data = $search->fetch_assoc();

require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12">
        <div class="card overflow-hidden">
            <div class="card-header">
                <h4 class="card-title">Edit News & Information</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($code) ?>">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="editnews_type">
                            <?= select_opt($data['type'],'news','News') ?>
                            <?= select_opt($data['type'],'info','Info') ?>
                            <?= select_opt($data['type'],'update','Update') ?>
                            <?= select_opt($data['type'],'maintenance','Maintenance') ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="editnews_content"><?= base64_decode($data['content']) ?></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" <?= onclick_href(base_url('admin/others/news/')) ?> class="btn btn-warning waves-effect waves-light">Back</button>
                        <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                        <button type="submit" name="editnews" class="btn btn-primary waves-effect waves-light">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>
<?= ckeditor(['editnews_content']) ?>