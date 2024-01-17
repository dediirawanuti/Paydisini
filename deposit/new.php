<?php 
require '../connect.php';
require _DIR_('library/session/user');
require _DIR_('library/shennboku.app/deposit-new');
require _DIR_('library/layout/header.user');
?>
<section id="dashboard-analytics">
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card">
            <div class="card-body">
                <h4 class="header-title">TOP-UP</h4>
                <hr>
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="form-group">
                        <label class="form-label">Payment</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="payment" value="bank" class="selectgroup-input">
                                <span class="selectgroup-button selectgroup-button-icon">Bank</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="payment" value="emoney" class="selectgroup-input">
                                <span class="selectgroup-button selectgroup-button-icon">E-Money</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="payment" value="pulsa" class="selectgroup-input">
                                <span class="selectgroup-button selectgroup-button-icon">Pulsa</span>
                            </label>
                        </div>
                    </div>
					<div class="form-group">
						<label class="placeholder">Method</label>
						<select name="method" id="method" class="form-control" required>
						    <option selected disabled> - Select One -</option>
						</select>
					</div>
					<div class="form-group d-none" id="phone">
						<label class="placeholder">Phone Number</label>
						<input type="number" name="phone" class="form-control">
						<small class="text-danger">Harap masukan nomor telepon pengirim pulsa.</small>
					</div>
					<div class="form-group">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="placeholder">Amount</label>
                                <input type="number" name="quantity" id="quantity" onkeyup="get_total(this.value).value;" class="form-control" required>
                                <small id="note" class="text-danger"></small>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="placeholder">Fee</label>
                                <input type="text" id="total_fee" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="placeholder">Rate</label>
                                <input type="text" id="total_rate" class="form-control" disabled>
                            </div>
						</div>
					</div>
					<div class="form-group text-right">
                        <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                        <button type="submit" name="confirm" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
				</form>
			</div>
		</div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Information</h4>
                    <hr>
                    <b>Langkah-langkah deposit:</b>
                    <ul>
                        <li>Pilih jenis pembayaran yang Anda inginkan, tersedia 3 opsi: <b>Transfer Bank</b>, <b>E-Money</b> & <b>Transfer Pulsa</b>.</li>
                        <li>Pilih metode pembayaran yang Anda inginkan.</li>
                        <li>Masukkan jumlah deposit.</li>
                        <li>Jika Anda memilih jenis pembayaran <b>Transfer Pulsa</b>, Anda diharuskan menginput nomor HP yang digunakan untuk transfer pulsa.</li>
                        <li>Klik submit untuk permintaan deposit.</li>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/footer.user'); ?>
<script type="text/javascript">
$(document).ready(function() {
    $('input[type=radio][name=payment]').change(function() {
        var payment = this.value;
        if(payment == 'pulsa') $('#phone').removeClass('d-none');
        else $('#phone').addClass('d-none');
        $.ajax({
            url: '<?= ajaxlib('deposit-system') ?>',
            data: 'type=' + payment + '&csrf_token=<?= $csrf_string ?>',
            type: 'POST',
            dataType: 'html',
            success: function(msg) {
                $("#method").html(msg);
            },
        });
    });
});
function get_total(quantity) {
    var method = $("#method").val();
    $.ajax({
        url: '<?= ajaxlib('deposit-rate') ?>',
        data: 'quantity=' + quantity + '&method=' + method + '&csrf_token=<?= $csrf_string ?>',
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            $("#total").val(data.msg.get);
            $("#total_fee").val(data.msg.fee);
            $("#total_rate").val(data.msg.rate);
            $("#note").html(data.msg.note);
        }
    });
}
</script>