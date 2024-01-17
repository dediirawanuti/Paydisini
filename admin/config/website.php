<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-config-website');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Web Config</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="row">
                        <div class="form-group col-12 col-md-7">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" value="<?= $_CONFIG['title'] ?>">
                        </div>
                        <div class="form-group col-12 col-md-5">
                            <label>Nav Title</label>
                            <input type="text" class="form-control" name="navbar" value="<?= $_CONFIG['navbar'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" rows="5" name="description"><?= $_CONFIG['description'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Keyword</label>
                        <textarea class="form-control" rows="5" name="keyword"><?= $_CONFIG['keyword'] ?></textarea>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>reCAPTCHA Site</label>
                            <input type="text" class="form-control" name="recsite" value="<?= $_CONFIG['reCAPTCHA']['site'] ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>reCAPTCHA Secret</label>
                            <input type="text" class="form-control" name="recsecret" value="<?= $_CONFIG['reCAPTCHA']['secret'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Banner Image</label>
                        <input type="text" class="form-control" name="banner" value="<?= $_CONFIG['banner'] ?>">
                        <small class="text-danger">*For og:image and twitter:image in metadata</small>
                    </div>
                    <div class="form-group">
                        <label>Icon / Logo</label>
                        <input type="text" class="form-control" name="icon" value="<?= $_CONFIG['icon'] ?>">
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                        <button type="submit" name="save" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>