<?php 
require '../connect.php';
require _DIR_('library/session/auth');
require _DIR_('library/shennboku.app/auth-forgot');
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
                                    <label>Email Address</label>
                                    <input class="form-control" type="text" name="email" value="<?= @$_SESSION['changepass'] ?>" placeholder="Email Address" <?= isset($_SESSION['changepass']) ? 'readonly' : '' ?>>
                                </div>
                            </div>
                            <div class="form-group row m-b-20">
                                <div class="col-12">
                                    <label>Kode OTP</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                                <? if(isset($_SESSION['changepass'])) { ?>
                                                <button type="submit" name="cancel" class="btn btn-danger waves-effect waves-light">
                                                    Cancel
                                                </button>
                                                <? } ?>
                                            </div>
                                    <input class="form-control" type="text" name="otp">
                                        <div class="input-group-append">
                                        <? if(isset($_SESSION['changepass'])) { ?>
                                        <button type="submit" name="resend" class="btn btn-primary waves-effect waves-light">
                                            Resend
                                        </button>
                                        <? } else { ?>
                                        <button type="submit" name="send" class="btn btn-primary waves-effect waves-light">
                                            Send
                                        </button>
                                        <? } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <? if(isset($_SESSION['changepass'])) { ?>
                            <div class="form-group m-b-20 row">
                                <div class="col-12">
                                    <label>New Password</label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                            </div>
                            <? } ?>
                            <? if(isset($_SESSION['changepass'])) { ?>
                            <div class="form-group row text-center m-t-10">
                                <div class="col-12">
                                    <button type="submit" name="confirm" class="btn btn-block btn-gradient waves-effect waves-light">Recover Password</button>
                                </div>
                            </div>
                            <? } ?>
                            <div class="form-group row text-center m-t-10">
                                <div class="col-12">
                                    <a href="<?= base_url('auth/login') ?>" class="btn btn-block btn-gradient waves-effect waves-light">Masuk</a>
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