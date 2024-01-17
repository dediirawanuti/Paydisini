<?php 
require '../connect.php';
require _DIR_('library/session/user');
require _DIR_('library/layout/header.user');
?>
<section class="invoice-print mb-1">
    <div class="row">

        <fieldset class="col-12 col-md-5 mb-1 mb-md-0">
            <h6 class="page-pretitle">Payments</h6>
            <h4 class="page-title">Invoice #D1BLYMJ4N</h4>
        </fieldset>
        <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
            <button class="btn btn-warning btn-print mb-1 mb-md-0"> <i class="feather icon-file-text"></i> Print</button>
            <!--<button class="btn btn-outline-primary  ml-0 ml-md-1"> <i class="feather icon-download"></i> Download</button>-->
        </div>
    </div>
</section>
<!-- invoice functionality end -->
<!-- invoice page -->
<section class="card invoice-page">
    <div id="invoice-template" class="card-body">
        <!-- Invoice Company Details -->
        <div id="invoice-company-details" class="row">
            <div class="col-sm-6 col-12 text-left pt-1">
                <div class="media pt-1">
                    <img src="<?= assets('images/logo/logo.png') ?>" alt="company logo" />
                </div>
            </div>
            <div class="col-sm-6 col-12 text-right">
                <h1>Invoice</h1>
                <div class="invoice-details mt-2">
                    <h6>INVOICE NO.</h6>
                    <p>001/2019</p>
                    <h6 class="mt-2">INVOICE DATE</h6>
                    <p>10 Dec 2018</p>
                </div>
            </div>
        </div>
        <!--/ Invoice Company Details -->

        <!-- Invoice Recipient Details -->
        <div id="invoice-customer-details" class="row pt-2">
            <div class="col-sm-6 col-12 text-left">
                <h5>Recipient</h5>
                <div class="recipient-info my-2">
                    <p>Shenn Kontoru</p>
                    <p>8577 West West Drive</p>
                    <p>Holbrook, NY</p>
                    <p>90001</p>
                </div>
                <div class="recipient-contact pb-2">
                    <p>
                        <i class="feather icon-mail"></i>
                        kontoru@mail.com
                    </p>
                    <p>
                        <i class="feather icon-phone"></i>
                        +91 988 888 8888
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-12 text-right">
                <h5>Shenn Technologies Pvt. Ltd.</h5>
                <div class="company-info my-2">
                    <p>9 N. Sherwood Court</p>
                    <p>Elyria, OH</p>
                    <p>94203</p>
                </div>
                <div class="company-contact">
                    <p>
                        <i class="feather icon-mail"></i>
                        hello@kontol.net
                    </p>
                    <p>
                        <i class="feather icon-phone"></i>
                        +91 999 999 9999
                    </p>
                </div>
            </div>
        </div>
        <!--/ Invoice Recipient Details -->

        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-1 invoice-items-table">
            <div class="row">
                <div class="table-responsive col-12">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th></th>
                                <th>TUJUAN</th>
                                <th>SALDO DIDAPAT</th>
                                <th>PAJAK</th>
                                <th>TOTAL TRANSFER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>BCA</td> <!-- Ganti img aja-->
                                <td>Shenn Dana</td>
                                <td>Rp 60.000</td>
                                <td>Rp 1.000</td>
                                <td>Rp 61.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="invoice-total-details" class="invoice-total-table">
            <div class="row">
                <div class="col-7 offset-5">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th>TAX</th>
                                    <td>Rp 1.000</td>
                                </tr>
                                <tr>
                                    <th>TOTAL TRANSFER</th>
                                    <td>Rp 61.000</td>
                                    <td>Termasuk Pajak</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Footer -->
        <div id="invoice-footer" class="text-left pt-3">
            <p class="title text-mute">Note:</p>
            <p>Kami sangat menghargai bisnis Anda dan jika ada hal lain yang dapat kami lakukan, beri tahu kami! Juga, jika Anda membutuhkan kami untuk menambahkan PPN atau apa pun ke pesanan ini, ini sangat mudah karena ini adalah templat, jadi tanyakan saja.</p>
        </div>
        <!--/ Invoice Footer -->

    </div>
    <!--<div class="page-divider"></div>-->
    
</section>
<div class="row justify-content-center">
    <form method="POST">
        <div class="row">
            <div class="col-6 mb-2">
                <a href="javascript:;" onclick="" class="btn mb-1 btn-danger text-white btn-lg btn-block waves-effect waves-light">Batalkan</a>
            </div>
            <div class="col-6">
                <button type="submit" name="confirm" class="btn mb-1 btn-primary btn-lg btn-block waves-effect waves-light">Konfirmasi</button>
            </div>
        </div>
    </form>
</div>
<!-- invoice page end -->
<? require _DIR_('library/layout/footer.user'); ?>