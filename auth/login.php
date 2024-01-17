<?php 
require '../connect.php';
require _DIR_('library/session/auth');
require _DIR_('library/shennboku.app/auth-login');
require _DIR_('library/layout/header.auth');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="wrapper-page">
            <div class="account-pages">
                <div class="account-box">
                    <div class="account-logo-box">
                        <h2 class="text-uppercase text-center">
                            <a href="<?php echo base_url(); ?>" style="color: #0BB1BF">
                                <span><i class="mdi mdi-cart"></i> <?= $_CONFIG['title']; ?></span>
                            </a>
                        </h2>
                    </div>
                    <div class="account-content">
                        <? require _DIR_('library/session/result'); ?>
                        <form class="form-horizontal" role="form" method="POST">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                            <div class="form-group m-b-20 row">
                                <div class="col-12">
                                    <label>Username/Email/Phone(62)</label>
                                    <input class="form-control" type="text" name="user">
                                </div>
                            </div>
                            <div class="form-group row m-b-20">
                                <div class="col-12">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="pass">
                                </div>
                            </div>
                            <div class="form-group row text-center m-t-10">
                                <div class="col-12">
                                    <button name="login" class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Masuk</button>
                                </div>
                            </div>
                        </form>
                        <div class="row m-t-50">
                            <div class="col-sm-12 text-center">
                                <p class="text-muted">Belum punya akun? <a href="<?= base_url('auth/register') ?>" class="text-dark m-l-5"><b>Daftar</b></a></p>
                                <p class="text-muted">Lupa Akun <a href="<?= base_url('auth/forgot') ?>" class="text-dark m-l-5"><b>Reset</b></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<? require _DIR_('library/layout/footer.auth'); ?>