<?php 
require '../connect.php';
require _DIR_('library/session/user');
if(conf('xtra-fitur',1) <> 'true') exit(redirect(0,base_url()));
require _DIR_('library/shennboku.app/order-postpaid');
require _DIR_('library/layout/header.user');
?>
<div class="row">
    <div class="col-12 col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-end">
                <h4 class="mb-0">Pascabayar</h4>
                <a href="<?= base_url('page/product')?>"><p class="font-medium-5 mb-0"><i class="feather icon-help-circle text-muted cursor-pointer"></i></p></a>
            </div>
            <hr>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="category" id="category">
                            <option value="0" selected disabled>- Select One -</option>
                            <?php
                            $search = $call->query("SELECT code, name FROM category WHERE `order` = 'postpaid' ORDER BY name ASC");
                            if($search->num_rows > 0) {
                                while($row = $search->fetch_assoc()) {
                                    if($call->query("SELECT id FROM srv_ppob WHERE brand = '".$row['code']."' AND status = 'available'")->num_rows > 0)
                                        print '<option value="'.base64_encode($row['code']).'">'.$row['name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group d-none" id="srvForm">
                        <label>Service</label>
                        <select class="form-control" name="service" id="service">
                            <option value="0" selected disabled>- Select One -</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>No. Pelanggan</label>
                        <input type="text" class="form-control" id="data" name="data">
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <button type="button" class="btn btn-danger btn-block"> RESET </button>
                        </div>
                        <div class="form-group col-6">
                            <button type="button" onclick="postpaid()" id="check" class="btn btn-primary btn-block" disabled> SUBMIT </button>
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
    $("#category").change(function() {
        var category = $("#category").val();
        $.ajax({
            type: 'POST',
            data: 'category=' + category + '&csrf_token=<?= $csrf_string ?>',
            url: '<?= ajaxlib('service-postpaid') ?>',
            dataType: 'json',
            success: function(out) {
                if(out.n > 1) {
                    $('#srvForm').removeClass('d-none');
                    $("#check").attr("disabled", false);
                } else if(out.n == 1) {
                    $('#srvForm').addClass('d-none');
                    $("#check").attr("disabled", false);
                } else {
                    $('#srvForm').addClass('d-none');
                    $("#check").attr("disabled", true);
                }
                $("#service").html(out.d);
            }
        });
    });
});
function postpaid() {
    var createURl = '<?= base_url('confirm-postpaid') ?>' + '/' + $("#service").val() + '/' + $("#data").val();
    modal('Order Confirmation',createURl,'lg');
}
</script>