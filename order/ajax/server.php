<?php 
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_POST['category']) && !isset($_POST['name'])) exit("No direct script access allowed!");
   
    $search = $call->query("SELECT * FROM srv_game WHERE game = '".filter($_POST['category'])."' AND name = '".filter($_POST['name'])."' AND status = 'available' ORDER BY server ASC");
    $l=[];
    
    while($row = $search->fetch_assoc()) {
        if(!in_array($row['server'],$l)){
            $l[]=$row['server'];
            $prov = $call->query("SELECT * FROM provider WHERE code = '".$row['provider']."'")->fetch_assoc();
            
            if($row['provider'] == 'ATL') $try = $curl->connectPost($prov['link'].'/game',['key' => $prov['apikey'],'action' => 'server','server' => $row['server']]);
            $tambah = (isset($try['data']['status'])) ? ' ['.strtoupper($try['data']['status']).']' : ' '.json_encode($try);
        ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                            <label class="btn btn-outline-dark col-md-auto w-100 mb-1 rounded waves-effect waves-light text-white" style="white-space:normal !important;text-align:center !important;background-color:#007BFF;">
                                <input class="checked" type="radio" name="server" id="server" value="<?= $row['server'] ?>">
                                <?= $row['server'].$tambah ?>
                            </label>
                        </div>
    <?php } } ?>
<script>
    $('input[name="server"]').change(function() {
    	       
    var server = $('input[name=server]:checked', '#myForm').val()
    var layanan = $('input[name=layanan]:checked', '#myForm').val()
    $.ajax({
        url: '<?=base_url('order/ajax/price')?>',
        data: 'server='+server+'&jumlah=1&layanan='+layanan+'&category=<?=filter($_POST['category'])?>',
        type: 'POST',
        dataType: 'html',
        success: function(msg) {
            document.getElementById("jumlah").value = '1';
            document.getElementById("harga").value = msg;
        }
    });
});
</script>
    <?
} else {
	exit("No direct script access allowed!");
}