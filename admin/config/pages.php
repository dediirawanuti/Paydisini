<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-config-pages');
require _DIR_('library/layout/header.admin');
?>
<section id="basic-tabs-components">
    <div class="row">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">Pages</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="terms-tab" data-toggle="tab" href="#terms" aria-controls="terms" role="tab" aria-selected="true">ToS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" aria-controls="contact" role="tab" aria-selected="false">Contact</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="terms" aria-labelledby="terms-tab" role="tabpanel">
                            <form method="POST">
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group">
                                    <textarea name="content_terms"><?= base64_decode(conf('pages',1)) ?></textarea>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                                    <button type="submit" name="save_terms" class="btn btn-primary waves-effect waves-light">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="contact" aria-labelledby="contact-tab" role="tabpanel">
                            <form method="POST">
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group">
                                    <textarea name="content_contact"><?= base64_decode(conf('pages',2)) ?></textarea>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                                    <button type="submit" name="save_contact" class="btn btn-primary waves-effect waves-light">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/footer.user'); ?>
<?= ckeditor(['content_terms','content_contact']) ?>