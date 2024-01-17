<?php 
require '../connect.php';
require _DIR_('library/session/user');
if(conf('xtra-fitur',3) <> 'true') exit(redirect(0,base_url()));
require _DIR_('library/shennboku.app/order-sosmed');
require _DIR_('library/layout/header.user');
?>
<div class="row">
    <div class="col-12 col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-end">
                <h4 class="mb-0">Social Media</h4>
                <a href="<?= base_url('page/product')?>"><p class="font-medium-5 mb-0"><i class="feather icon-help-circle text-muted cursor-pointer"></i></p></a>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category" id="category">
                            <option value="0" selected disabled>- Select One -</option>
                            <?php
                            $search = $call->query("SELECT code, name FROM category WHERE `order` = 'social' ORDER BY name ASC");
                            if($search->num_rows > 0) {
                                while($row = $search->fetch_assoc()) {
                                    if($call->query("SELECT id FROM srv_socmed WHERE cid = '".$row['code']."' AND status = 'available'")->num_rows > 0)
                                        print '<option value="'.base64_encode($row['code']).'">'.$row['name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Service</label>
                        <select class="form-control" name="service" id="service">
                            <option value="0" selected disabled>- Select One -</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <div class="form-control" style="height:auto !important;" id="note"></div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-12">
                            <label>Price/1000</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><div class="input-group-text">Rp. </div></div>
                                <input type="text" class="form-control" id="price" value="0" readonly>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label>Min.</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="min" value="0" readonly>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label>Max.</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="max" value="0" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Link / Username</label>
                        <input type="text" class="form-control" id="target" name="target">
                    </div>
                    <div class="row">
                        <input type="hidden" id="rate" value="0">
                        <div class="form-group col-md-6 col-12">
                            <label>Amount</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" onkeyup="get_total(this.value).value;">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"> Rp. </div>
                                </div>
                                <input type="text" class="form-control" id="total-price" value="0" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <button type="button" class="btn btn-danger btn-block"> RESET </button>
                        </div>
                        <div class="form-group col-6">
                            <button type="submit" id="actionbutton" name="order" class="btn btn-primary btn-block"> SUBMIT </button>
                            <div id="timerdiv" style="display:none;"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Information</h4>
            </div>
            <div class="card-body">
                <b>Langkah-langkah membuat pesanan baru:</b>
                <ul>
                    <li>Pilih salah satu Kategori.</li>
                    <li>Pilih salah satu Layanan yang ingin dipesan.</li>
                    <li>Masukkan Target pesanan sesuai ketentuan yang diberikan layanan tersebut.</li>
                    <li>Masukkan Jumlah Pesanan yang diinginkan.</li>
                    <li>Klik Pesan untuk membuat pesanan baru.</li>
                </ul>
                <b>Ketentuan membuat pesanan baru:</b>
                <ul>
                    <li>Silahkan membuat pesanan sesuai langkah-langkah diatas.</li>
                    <li>Jika ingin membuat pesanan dengan Target yang sama dengan pesanan yang sudah pernah dipesan sebelumnya, mohon menunggu sampai pesanan sebelumnya selesai diproses.</li>
                    <li>Setelah pesanan berhasil anda buat maka setuju dengan <a href="<?= base_url('page/terms-of-service') ?>">Ketentuan Layanan.</a></li>
                    <li>Hati-hati dalam melakukan pesanan, karena kesalahan pengguna tidak ada pengembalian.</li>
                    <li>Jika terjadi kesalahan / mendapatkan pesan gagal yang kurang jelas, silahkan hubungi Admin untuk informasi lebih lanjut.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>
<script type="text/javascript">
$(document).ready(function() {
    $("#category").change(function() {
        var category = $("#category").val();
        $.ajax({
            type: 'POST',
            data: 'category=' + category + '&csrf_token=<?= $csrf_string ?>',
            url: '<?= ajaxlib('service-socmed') ?>',
            dataType: 'html',
            success: function(msg) {
                $("#service").html(msg);
            }
        });
    });
    $("#service").change(function() {
        var service = $("#service").val();
        $.ajax({
            type: 'POST',
            data: 'pid=' + service + '&csrf_token=<?= $csrf_string ?>',
            url: '<?= ajaxlib('note-socmed') ?>',
            dataType: 'json',
            success: function (data) {
                $('#price').val(data.msg.price);
                $('#min').val(data.msg.min);
                $('#max').val(data.msg.max);
                $('#note').html(data.msg.note);
            }
        });
        $.ajax({
            type: 'POST',
            data: 'service=' + service + '&csrf_token=<?= $csrf_string ?>',
            url: '<?= ajaxlib('price-socmed') ?>',
            dataType: 'html',
            success: function(msg) {
                $("#rate").val(msg);
            }
        });
    });
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
});
function get_total(quantity) {
    var rate = $("#rate").val();
    var result = eval(quantity) * rate;
    $('#total-price').val(result);
}
</script>