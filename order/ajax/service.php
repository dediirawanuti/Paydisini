<?php 
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_POST['category']) && !isset($_POST['server'])) exit("No direct script access allowed!");
   
    $search = $call->query("SELECT * FROM srv_game WHERE game = '".filter($_POST['category'])."' AND server = '".filter($_POST['server'])."' AND status = 'available' ORDER BY price ASC");
    while($row = $search->fetch_assoc()) {
    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                            <label class="btn btn-outline-dark col-md-auto w-100 mb-1 rounded waves-effect waves-light text-white" style="white-space:normal !important;text-align:center !important;background-color:#007BFF;">
                                <input class="checked" type="radio" name="layanan" id="layanan" value="<?= $row['code'] ?>">
                                <?= $row['name'] ?>
                            </label>
                        </div>
    <? } ?>
<script>
    $('input[name="layanan"]').change(function() {
    	       
    var server = $('input[name=server]:checked', '#myForm').val()
    var layanan = $('input[name=layanan]:checked', '#myForm').val()
    $.ajax({
        url: '<?=base_url('order/ajax/price')?>',
        data: 'server='+server+'&jumlah=1&layanan='+layanan+'&category=<?=filter($_POST['category'])?>',
        type: 'POST',
        dataType: 'html',
        beforeSend: function(msg) {
            $("#jumlah").val("1");
            $("#harga").val("Please wait..");
        },
        success: function(msg) {
            $("#jumlah").val("1");
            $("#harga").val(msg);
        }
    });
});
</script>
    <?
} else {
	exit("No direct script access allowed!");
}