<?php 
require '../connect.php';
require _DIR_('library/session/user');

$get_s = isset($_GET['s']) ? str_replace('-',' ',filter($_GET['s'])) : '';
$search_cat = $call->query("SELECT * FROM category WHERE name = '$get_s' AND `order` = 'game'");
if($search_cat->num_rows == 0) exit(redirect(0,base_url('order/game')));
$data_cat = $search_cat->fetch_assoc();
$operator = $data_cat['name'];

$list_userid = ['Free Fire','PB Zepetto','Call of Duty Mobile','UC PUBGM','Valorant','HAGO','Light of Thel','Dragon Raja','Lords Mobile','World of Dragon Nest'];

if(conf('xtra-fitur',2) <> 'true') exit(redirect(0,base_url()));
require _DIR_('library/shennboku.app/order-games');
require _DIR_('library/layout/header.user');
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/4.7.95/css/materialdesignicons.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<style>
input.checked[type="radio"]{
    visibility:hidden;
    margin-left:-5px;
    margin-right:2px;
}
    
input[type='radio']:checked:after {
    width: 15px;
    height: 15px;
    border-radius: 15px;
    top: -2px;
    left: -1px;
    position: relative;
    background-color: #b300ff;
    content: '';
    display: inline-block;
    visibility: hidden;
    border: 2px solid white;
    margin-left:-5px;
    margin-right:2px;
}
</style>
<form method="POST" id="myForm">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">
                        <i class="mdi mdi-numeric-1-circle-outline text-primary"></i>
                        <b>Masukan Data Tujuan</b>
                    </h4>
                    <div class="row">
                        <? if(in_array($operator, $list_userid)) { ?>
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" name="target" id="target" placeholder="Masukkan User ID" required>
                        </div>
                        <? } else if(substr($operator,0,13) == 'Mobile Legend') { ?>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" name="target" id="target" placeholder="Masukkan User ID" required>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" name="target2" id="target2" placeholder="Masukkan Zone ID" required>
                        </div>
                        <? } else if(in_array($operator, ['Ragnarok M Eternal Love','LifeAfter'])) { ?>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" name="target" id="target" placeholder="Masukkan User ID" required>
                        </div>
                        <div class="form-group col-md-4">
                            <select name="target2" id="target2" class="form-control" required>
                                <option value="">Choose Server</option>
                                <? if(substr($operator,0,8) == 'Ragnarok') { ?>
                                <option value="Eternal Love">Eternal Love</option>
                                <option value="Midnight Party">Midnight Party</option>
                                <? } else if($operator == 'LifeAfter') { ?>
                                <option value="MiskaTown">MiskaTown</option>
                                <option value="SandCastle">SandCastle</option>
                                <option value="MouthSwamp">MouthSwamp</option>
                                <option value="RedwoodTown">RedwoodTown</option>
                                <option value="Obelisk">Obelisk</option>
                                <option value="FallForest">FallForest</option>
                                <option value="MountSnow">MountSnow</option>
                                <option value="NancyCity">NancyCity</option>
                                <option value="CharlesTown">CharlesTown</option>
                                <option value="SnowHighlands">SnowHighlands</option>
                                <option value="Santopany">Santopany</option>
                                <option value="LevinCity">LevinCity</option>
                                <? } ?>
                            </select>
                        </div>
                        <? } ?>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" name="displayname" id="target">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">
                        <i class="mdi mdi-numeric-2-circle-outline text-primary"></i>
                        <b>Pilih Server</b>
                    </h4>
                    <div class="row">
                        <?php
                        $search = $call->query("SELECT * FROM srv_game WHERE game = '$operator' AND status = 'available' ORDER BY server ASC"); $l=[];
                        while($row = $search->fetch_assoc()) {
                            if(!in_array($row['server'],$l)){
                                $l[]=$row['server'];
                        ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                            <label class="btn btn-outline-dark col-md-auto w-100 mb-1 rounded waves-effect waves-light text-primary">
                                <input class="checked" type="radio" name="server" id="server" value="<?= $row['server'] ?>">
                                S<?= $row['server'] ?>
                            </label>
                        </div>
                        <? } } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">
                        <i class="mdi mdi-numeric-3-circle-outline text-primary"></i>
                        <b>Pilih Nominal Topup</b>
                    </h4>
                    <div class="row" id="service"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">
                        <i class="mdi mdi-numeric-4-circle-outline text-primary"></i>
                        <b>Harga</b>
                    </h4>
                    <div class="row">
                        <input type="hidden" name="jumlah" class="form-control" id="jumlah" value="1" readonly>
                        <div class="form-group col-12">
                            <input type="text" class="form-control" name="harga" id="harga" placeholder="Rp 0" readonly>
                            <small class="text-danger">*Pastikan ID yang anda masukan benar! Kesalahan input bukan tanggung jawab kami.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">
                        <i class="mdi mdi-numeric-5-circle-outline text-primary"></i>
                        <b>Keamanan</b>
                    </h4>
                    <div class="row">
                        <div class="form-group col-12 col-md-8">
                            <div class="input-group">
                                <input type="password" inputmode="numeric" class="form-control" id="password" name="pin" data-toggle="password" onkeyup="this.value=this.value.replace(/[^\d]+/g,'')" maxlength="6" minlength="6" placeholder="Two-Factor Authorization (PIN/2FA)" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <button type="submit" id="actionbutton" name="order" class="btn btn-primary btn-block">Order</button>
                            <div id="timerdiv" style="display:none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<? require _DIR_('library/layout/footer.user'); ?>
<script type="text/javascript">
$(document).ready(function() {
    $("#actionbutton").click(function() {
        $("#actionbutton").hide();
        $("#timerdiv").show(); 
        var timer = 10;     
        function counting(){
            var rto = setTimeout(counting,1000);
            $('#timerdiv').html( '<button type="button" class="btn btn-primary btn-block btn-disabled"> Processing </button>' );
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
     
    $('input[name="target"],input[name="target2"],select[name="target2"]').change(function(){
        var safalian = ['Lords Mobile','UC PUBGM'];
        var shennZone = ['Mobile Legends','Mobile Legends A','Mobile Legends B','Ragnarok M Eternal Love','LifeAfter'];
        var target = $("#target").val();
        var target2 = $("#target2").val();
        var operator = '<?= $operator ?>';
        
        if(safalian.includes(operator) == false) {
            if(shennZone.includes(operator) == true && target != '' && target2 != '') {
                var postdata = 'category=' + operator + '&target=' + target + '&target2=' + target2;
                validasi(postdata);
            } else if(shennZone.includes(operator) == false && target != '') {
                var postdata = 'category=' + operator + '&target=' + target;
                validasi(postdata);
            }
        }
    });
    
    function validasi(postdata){
        $.ajax({
            url: '<?= base_url('order/ajax/check') ?>',
            data: postdata,
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function() {
                Swal.fire({title:"Sedang Mengecek...",showConfirmButton:false,allowOutsideClick:false});
            },
            success: function(shenn) {
                if(shenn.result == false){
                    Swal.fire('Ups...',' ' + shenn.message,'error');
                    document.getElementById("myForm").reset();
                }else{
                    Swal.fire('Sukses !',"Player Id ditemukan",'success');
                    document.getElementById("displayname").value = decodeURI(shenn.data);
                }
    		}
    	});
    };
	
    $('input[name="server"]').change(function() {
        var server = $('input[name=server]:checked', '#myForm').val();
        var target = $("#target").val();
        
        if(!target) {
            Swal.fire('Ups...','Harap Isi User ID','error');
            document.getElementById("myForm").reset();
            server = 0;
        }
        
        $.ajax({
            url: '<?=base_url('order/ajax/service')?>',
            data: 'category=<?= $operator ?>&server=' + server,
            type: 'POST',
            dataType: 'html',
            beforeSend: function() {
                $("#service").html("<br><div class=\"col-12\"><center>Please wait..<center></div>");
            },
            success: function(msg) {
                $("#service").html(msg);
                reset();
            }
        });
    });

    $('input[name="jumlah"]').keyup(function() {
        var server =$('input[name=server]:checked', '#myForm').val();
        var jumlah = $("#jumlah").val();
        var layanan =  $('input[name=layanan]:checked', '#myForm').val();

        if(!server){
            Swal.fire('Ups...','Pilih Server Dulu','error');
            reset();
        }
        
        $.ajax({
            url: '<?=base_url('order/ajax/price')?>',
            data: 'server=' + server + '&jumlah=' + jumlah + '&layanan=' + layanan + '&category=<?= $operator ?>',
            type: 'POST',
            dataType: 'html',
            beforeSend: function() {
                $("#harga").val("Please wait..");
            },
            success: function(msg) {
                $("#harga").val(msg);
            }
    	});
    });
});

function reset() {
    document.getElementById("jumlah").value = '';
    document.getElementById("harga").value = '';
}
</script>