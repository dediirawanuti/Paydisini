<?php 
require '../connect.php';
require _DIR_('library/session/user');

$get_s = isset($_GET['s']) ? strtolower(filter($_GET['s'])) : '';
if($get_s == 'pulsa-reguler') $title = 'Pulsa Reguler';
else if($get_s == 'pulsa-transfer') $title = 'Pulsa Transfer';
else if($get_s == 'paket-internet') $title = 'Paket Internet';
else if($get_s == 'paket-telepon') $title = 'Paket SMS & Telepon';
else exit(redirect(0,base_url()));

require _DIR_('library/shennboku.app/order-prepaid');
require _DIR_('library/layout/header.user');
?>
<div class="row">
    <div class="col-12 col-md-10 offset-md-1">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><?= $title ?></h4>
                <hr>
                <form method="POST">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="number" class="form-control" id="data" name="data">
                    </div>
                    <label>Select Service</label>
                    <div class="row" id="service">
                        <div class="col-12">
                            <div class="alert alert-danger bg-danger text-white border-0" role="alert">Enter your mobile number.</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var msgErr = '<div class="col-12"><div class="alert alert-danger bg-danger text-white border-0" role="alert">System Error!</div></div>';
    $("#data").keyup(function() {
        var target = $("#data").val();
        $("#data").removeClass('sc-telkomsel');
        $("#data").removeClass('sc-byu');
        $("#data").removeClass('sc-indosat');
        $("#data").removeClass('sc-axiata');
        $("#data").removeClass('sc-axis');
        $("#data").removeClass('sc-smartfren');
        $("#data").removeClass('sc-three');
        if(target.length >= 10) {
            $.ajax({
                type: 'POST',
                data: 'phone=' + target + '&type=<?= $get_s ?>&csrf_token=<?= $csrf_string ?>',
                url: '<?= ajaxlib('service-simcard') ?>',
                dataType: 'json',
                success: function(msg) {
                    $("#service").html(msg.service);
                    $("#data").addClass(msg.class);
                }
            });
        }
    });
});
function prepaid(endpoint) {
    var target = $("#data").val();
    modal('Order Confirmation', endpoint + target, 'lg');
}
</script>