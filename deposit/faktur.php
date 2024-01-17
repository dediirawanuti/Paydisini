<?php
require '../connect.php';
require _DIR_('library/session/user');
require _DIR_('library/shennboku.app/deposit-invoice');
require _DIR_('library/layout/header.user');
?>
<style>
.page-pretitle{letter-spacing:.08em;text-transform:uppercase;color:#95aac9}.page-title{font-size:23px;font-weight:600;color:#444;line-height:30px;margin-bottom:20px}.main-panel .page-divider{height:0;margin:.3rem 0 1rem;overflow:hidden;border-top:1px solid #ebecec}.card .card-header:first-child,.card-light .card-header:first-child{border-radius:0}.card-invoice .card-header{padding:50px 0 20px;border:0px!important;width:75%;margin:auto}.card-invoice .invoice-header{display:block;flex-direction:row;justify-content:space-between;align-items:center;margin-bottom:15px}.card-invoice .invoice-header .invoice-title{font-size:27px;font-weight:400}.card-invoice .invoice-header .invoice-logo{width:150px;display:flex;align-items:center}.card-invoice .invoice-header .invoice-logo img{width:100%}.card-invoice .invoice-desc{text-align:right;font-size:13px}.card-invoice .card-body{padding:0;border:0px!important;width:75%;margin:auto}.card .separator-solid,.card-light .separator-solid{border-top:1px solid #ebecec;margin:15px 0}.card-invoice .info-invoice{padding-top:15px;padding-bottom:15px}.card-invoice .sub{font-size:14px;margin-bottom:8px;font-weight:600}.card-invoice .info-invoice p{font-size:13px}.card-invoice .invoice-detail{width:100%;display:block}.card-invoice .invoice-detail .invoice-top .title{font-size:20px}.card-invoice .card-footer{padding:5px 0 50px;border:0px!important;width:75%;margin:auto}.card .card-footer,.card-light .card-footer{background-color:transparent;line-height:30px;font-size:13px}.card-footer:last-child{border-radius:0 0 calc(.25rem - 1px) calc(.25rem - 1px)}.card-invoice .transfer-to .account-transfer>div span:first-child{font-weight:600;font-size:13px}.card-invoice .transfer-to .account-transfer>div span:last-child{font-size:13px;float:right}.card-invoice .transfer-total{text-align:right;display:flex;flex-direction:column;justify-content:center}.card-invoice .transfer-total .sub{font-size:14px;margin-bottom:8px;font-weight:600}.card-invoice .transfer-total .price{font-size:28px;color:#1572E8;padding:7px 0;font-weight:600}.card-invoice .transfer-total span{font-weight:600;font-size:13px}.card .separator-solid,.card-light .separator-solid{border-top:1px solid #ebecec;margin:15px 0}
</style>
<div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-9">
        <div class="row" id="printInvoice">
            <div class="col-md-12">
                <div class="card card-invoice">
                    <div class="card-header">
                        <div class="invoice-header">
                            <h3 class="invoice-title">Invoice</h3>
                            <div class="invoice-logo">
                                <img src="" style="width: 50% !important;" alt="">
                            </div>
                        </div>
                        <div class="invoice-desc">
                            Jakarta Pusat, DKI Jakarta<br />
                            Indonesia
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="separator-solid"></div>
                        <div class="row">
                            <div class="col-md-4 info-invoice">
                                <h5 class="sub">Date</h5>
                                <p><?= format_date('en',explode(' ',$rowvoice['date'])[0]) ?><br><?= substr(explode(' ',$rowvoice['date'])[1],0,5).' WIB' ?></p>
                            </div>
                            <div class="col-md-4 info-invoice">
                                <h5 class="sub">Invoice ID</h5>
                                <p>#<?= $InvoiceCode ?></p>
                            </div>
                            <div class="col-md-4 info-invoice">
                                <h5 class="sub">Billed To</h5>
                                <p><?= $data_user['name'] ?><br>+<?= $data_user['phone'] ?></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="invoice-detail">
                                    <div class="invoice-top">
                                        <h3 class="title"><strong>Deposit Summary</strong></h3>
                                    </div>
                                    <div class="invoice-item">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <td><strong>Method</strong></td>
                                                        <td class="text-center"><strong>Payment</strong></td>
                                                        <td class="text-right"><strong>Total</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?= $rowvoice['method'] ?></td>
                                                        <td class="text-center">~</td>
                                                        <td class="text-right">Rp <?= currency($rowvoice['amount']) ?></td>
                                                    </tr>
                                                    <tr><td></td><td></td><td></td></tr>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center"><strong>Tax</strong></td>
                                                        <td class="text-right"><?= currency($rowvoice['fee']) ?></td>
                                                    </tr>
                                                    <? if($rowvoice['uniq'] > 0) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center"><strong>Uniq</strong></td>
                                                        <td class="text-right"><?= currency($rowvoice['uniq']) ?></td>
                                                    </tr>
                                                    <? } ?>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center"><strong>Total</strong></td>
                                                        <td class="text-right"><?= currency($paytotal) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator-solid  mb-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-7 col-md-5 mb-3 mb-md-0 transfer-to">
                                <h5 class="sub">Detail Transfer</h5>
                                <div class="account-transfer">
                                    <div>
                                        <span>Payment:</span>
                                        <span><?= $payname ?></span>
                                    </div>
                                    <div>
                                        <span>Nama:</span>
                                        <span><?= explode(' A/n ',$rowvoice['note'])[1] ?></span>
                                    </div>
                                    <div>
                                        <span>Tujuan:</span>
                                        <span><font color="red"><?= explode(' A/n ',$rowvoice['note'])[0] ?></font></span>
                                    </div>
                                    <div>
                                        <span>Catatan:</span>
                                        <span>-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 col-md-7 transfer-total">
                                <h5 class="sub">Jumlah Total</h5>
                                <div class="price"><?= currency($paytotal) ?></div>
                                <span>Termasuk Pajak</span>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <h6 class="text-uppercase mt-3 fw-bold">
                            Catatan
                        </h6>
                        <p class="text-muted mb-0">
                            Permintaan deposit harus dibayar pada hari yang sama dengan penerimaan faktur.
                            Dibayar dengan bank, emoney, atau pulsa. Jika setoran tidak dibayarkan pada hari yang sama, permintaan akan dibatalkan secara otomatis oleh sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <? if($rowvoice['method'] == 'BCA' && $rowvoice['status'] == 'unpaid') { ?>
        <div class="page-divider"></div>
        <form method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
        <div class="row">
        <div class="col-12 mb-2">
        <button type="submit" id="actionbutton" name="confirm-bca" class="btn btn-block text-white bg-gradient-success fw-bold">
        Confirm </button>
        <div id="timerdiv" style="display:none;"></div>
        </div>
        </div>
        </form>
        <? } ?>
        
        <? if($rowvoice['status'] == 'unpaid') { ?>
        <div class="page-divider"></div>
        <form method="POST">
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <div class="row">
                <?php
                $onClickCancel = ' ';
                if($rowvoice['status'] == 'unpaid') $onClickCancel .= ' '.onclick_modal("Cancel #$InvoiceCode",base_url('deposit/cancel/'.$InvoiceCode),'lg').' ';
			    ?>
                <div class="col-12 mb-2">
                    <a href="javascript:;"<?= $onClickCancel ?>class="btn btn-block text-white bg-gradient-danger fw-bold">
                        Cancel
                    </a>
                </div>
                </div>
        </form>
        <? } ?>
    </div>
</div>
</div>
<script type="text/javascript">
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
     	var originalContents = document.body.innerHTML;
     	document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#actionbutton").click(function() {
            $("#actionbutton").hide();
            $("#timerdiv").show(); 
            var timer = 10;     
            function counting(){
                var rto = setTimeout(counting,1000);
                $('#timerdiv').html( '<button type="button" class="btn btn-block text-white bg-gradient-success fw-bold btn-disabled">Checking...</button>' );
                timer--;
                if(timer < 0) {
                    clearTimeout(rto);
                    timer = 10;
                    $("#timerdiv").hide();             
                    $("#actionbutton").show();
                }
            }
            counting();
         });
    });
</script>
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>